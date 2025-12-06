<?php
// Process checkout: validate cart/inputs, create order + details inside a transaction, adjust stock, and handle wallet deductions.
session_start();
include "../config/db.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate session
    if (!isset($_SESSION['user_id'])) {
        $_SESSION['order_feedback'] = ['type' => 'danger', 'message' => 'Session expired. Please login again.'];
        header("Location: ../pages/login.php");
        exit();
    }

    $user_id = $_SESSION['user_id'];
    // Whitelist payment methods to avoid falling back to the enum default unexpectedly.
    $payment_method = trim($_POST['payment_method'] ?? 'wallet');
    $allowed_payment_methods = ['wallet', 'cash'];
    if (!in_array($payment_method, $allowed_payment_methods, true)) {
        $payment_method = 'wallet';
    }
    $pickup_time = $_POST['pickup_time'] ?? null;
    $agree = $_POST['agree'] ?? false;

    // Validate required fields
    if (!$agree || empty($pickup_time) || empty($payment_method)) {
        $_SESSION['order_feedback'] = ['type' => 'danger', 'message' => 'Please fill in all required fields.'];
        header("Location: ../pages/checkout.php");
        exit();
    }

    // Validate pickup time format
    if (!preg_match('/^([0-1]?[0-9]|2[0-3]):[0-5][0-9]$/', $pickup_time)) {
        $_SESSION['order_feedback'] = ['type' => 'danger', 'message' => 'Invalid pickup time format.'];
        header("Location: ../pages/checkout.php");
        exit();
    }

    // Get cart items
    $cartItems = [];

    if (!empty($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $itemId => $plans) {
            foreach ($plans as $planId => $itemData) {
                // Add plan_id inside itemData for convenience
                $itemData['plan_id'] = $planId;
                $cartItems[] = $itemData;
            }
        }
    }
    if (empty($cartItems)) {
        $_SESSION['order_feedback'] = ['type' => 'danger', 'message' => 'Your cart is empty.'];
        header("Location: ../pages/orders.php");
        exit();
    }

    // Calculate total
    $total_amount = 0;
    foreach ($cartItems as $item) {
        $total_amount += $item['price'] * $item['quantity'];
    }

    // Get user's current balance
    $sql = "SELECT balance FROM users WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $current_balance = $user['balance'] ?? 0;
    $stmt->close();

    // Validate wallet payment
    if ($payment_method === 'wallet') {
        if ($current_balance < $total_amount) {
            $_SESSION['order_feedback'] = ['type' => 'danger', 'message' => 'Insufficient wallet balance. Please choose another payment method.'];
            header("Location: ../pages/checkout.php");
            exit();
        }
    }

    try {
        // Start transaction
        $conn->begin_transaction();

        // Create order
        $sql = "INSERT INTO orders (user_id, total_amount, payment_method, pickup_time, status) 
                VALUES (?, ?, ?, ?, 'pending')";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            throw new Exception("Prepare failed: " . $conn->error);
        }
        $stmt->bind_param("idss", $user_id, $total_amount, $payment_method, $pickup_time);
        if (!$stmt->execute()) {
            throw new Exception("Execute failed: " . $stmt->error);
        }
        
        $order_id = $conn->insert_id;
        $stmt->close();

        // Create order details
        foreach ($cartItems as $item) {
            $sql = "INSERT INTO order_details (order_id, item_id, quantity, subtotal) 
                    VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            if (!$stmt) {
                throw new Exception("Prepare failed: " . $conn->error);
            }
            $item_id = $item['item_id'];
            $plan_id = $item['plan_id'];
            $quantity = $item['quantity'];
            $price = $item['price'];
            $subtotal = $quantity * $price;
            $stmt->bind_param("iiid", $order_id, $item_id, $quantity, $subtotal);
            if (!$stmt->execute()) {
                throw new Exception("Execute failed: " . $stmt->error);
            }
            $stmt->close();

            // Update inventory
            $sql = "UPDATE menu_items SET stock = stock - ? WHERE item_id = ? AND stock >= 0";
            $planQuery = "UPDATE meal_plans SET available_qty = available_qty - ? WHERE plan_id = ?";
            $stmt1 = $conn->prepare($sql);
            $stmt2 = $conn->prepare($planQuery);
            if (!$stmt1 || !$stmt2) {
                if ($stmt1) {
                    $stmt1->close();
                }
                if ($stmt2) {
                    $stmt2->close();
                }
                throw new Exception("Prepare failed: " . $conn->error);
            }
            $stmt1->bind_param("ii", $quantity, $item_id);
            $stmt2->bind_param("ii", $quantity, $plan_id);
            if (!$stmt1->execute()) {
                $error = $stmt1->error;
                $stmt1->close();
                $stmt2->close();
                throw new Exception("Execute failed: " . $error);
            }
            if (!$stmt2->execute()) {
                $error = $stmt2->error;
                $stmt1->close();
                $stmt2->close();
                throw new Exception("Execute failed: " . $error);
            }
            $stmt1->close();
            $stmt2->close();
        }

        // Deduct from wallet if payment method is wallet
        $new_balance = $current_balance;
        if ($payment_method === 'wallet') {
            $new_balance = $current_balance - $total_amount;
            $sql = "UPDATE users SET balance = ? WHERE user_id = ?";
            $stmt = $conn->prepare($sql);
            if (!$stmt) {
                throw new Exception("Prepare failed: " . $conn->error);
            }
            $stmt->bind_param("di", $new_balance, $user_id);
            if (!$stmt->execute()) {
                throw new Exception("Execute failed: " . $stmt->error);
            }
            $stmt->close();
        }

        // Record payment status (wallet orders are paid immediately; others stay pending until confirmed)
        $paymentStatus = $payment_method === 'wallet' ? 'paid' : 'pending';
        $paymentStmt = $conn->prepare("INSERT INTO payments (order_id, payment_method, amount_paid, payment_status) VALUES (?, ?, ?, ?)");
        if (!$paymentStmt) {
            throw new Exception("Prepare failed: " . $conn->error);
        }
        $paymentStmt->bind_param("isds", $order_id, $payment_method, $total_amount, $paymentStatus);
        if (!$paymentStmt->execute()) {
            $error = $paymentStmt->error;
            $paymentStmt->close();
            throw new Exception("Execute failed: " . $error);
        }
        $paymentStmt->close();

        // Delete cart items from the database after checkout
        $cartIdStmt = $conn->prepare("SELECT cart_id FROM cart WHERE user_id = ?");
        if (!$cartIdStmt) {
            throw new Exception("Prepare failed: " . $conn->error);
        }
        $cartIdStmt->bind_param("i", $user_id);
        if (!$cartIdStmt->execute()) {
            $error = $cartIdStmt->error;
            $cartIdStmt->close();
            throw new Exception("Execute failed: " . $error);
        }
        $cartIdResult = $cartIdStmt->get_result();
        $cartRow = $cartIdResult->fetch_assoc();
        $cartIdStmt->close();

        if ($cartRow) {
            $cart_id = $cartRow['cart_id'];

            // Delete all cart items
            $deleteCartItems = $conn->prepare("DELETE FROM cart_items WHERE cart_id = ?");
            if (!$deleteCartItems) {
                throw new Exception("Prepare failed: " . $conn->error);
            }
            $deleteCartItems->bind_param("i", $cart_id);
            if (!$deleteCartItems->execute()) {
                $error = $deleteCartItems->error;
                $deleteCartItems->close();
                throw new Exception("Execute failed: " . $error);
            }
            $deleteCartItems->close();

        }
        // Commit transaction
        $conn->commit();

        // Clear cart and update session balance

        $_SESSION['cart'] = [];
        $_SESSION['balance'] = $new_balance;

        // Set success message
        $_SESSION['order_feedback'] = [
            'type' => 'success', 
            'message' => 'Order placed successfully! Order ID: #' . str_pad($order_id, 5, '0', STR_PAD_LEFT)
        ];

        // Redirect to order confirmation
        header("Location: ../pages/order_confirmation.php?order_id=" . $order_id);
        exit();

    } catch (Exception $e) {
        // Rollback on error
        $conn->rollback();
        $_SESSION['order_feedback'] = ['type' => 'danger', 'message' => 'Order failed: ' . $e->getMessage()];
        header("Location: ../pages/checkout.php");
        exit();
    } finally {
        $conn->close();
    }
} else {
    header("Location: ../pages/checkout.php");
    exit();
}
?>
