<?php
    // Admin status updater for payments, orders, items, and meal plans via JSON payloads.
    session_start();
    // Include database configuration 
    include('../../config/db.php');

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $raw = file_get_contents("php://input");
        $data = json_decode($raw, true);

        $id = isset($data['id']) ? intval($data['id']) : 0;
        $status = $data['status'] ?? null;
        $paymentStatus = $data['payment_status'] ?? null;
        $itemStatus = $data['item_status'] ?? null;
        $planStatus = $data['plan_status'] ?? null;
        $type = $data['type'] ?? null;

        // Validate inputs
        if (empty($id) || empty($type)) {
            echo json_encode(['status' => 'error', 'message' => 'Order ID and type are required.']);
            exit();
        }

        if ($type === 'payment') {
            if (empty($paymentStatus)) {
                echo json_encode(['status' => 'error', 'message' => 'Payment status is required.']);
                exit();
            }

            // Pull order info so we can upsert into payments if the record is missing.
            $orderSql = "SELECT payment_method, total_amount FROM orders WHERE order_id = ?";
            $orderStmt = $conn->prepare($orderSql);
            $orderStmt->bind_param("i", $id);
            $orderStmt->execute();
            $orderResult = $orderStmt->get_result();
            $order = $orderResult->fetch_assoc();
            $orderStmt->close();

            if (!$order) {
                echo json_encode(['status' => 'error', 'message' => 'Order not found.']);
                $conn->close();
                exit();
            }

            // Check if a payment row already exists; if not, insert one so updates always stick.
            $existingPayment = null;
            $checkSql = "SELECT payment_id FROM payments WHERE order_id = ?";
            $checkStmt = $conn->prepare($checkSql);
            $checkStmt->bind_param("i", $id);
            $checkStmt->execute();
            $checkResult = $checkStmt->get_result();
            if ($checkResult->num_rows > 0) {
                $existingPayment = $checkResult->fetch_assoc();
            }
            $checkStmt->close();

            if ($existingPayment) {
                $updatePaymentQuery = "UPDATE payments SET payment_status = ? WHERE order_id = ?";
                $stmtPayment = $conn->prepare($updatePaymentQuery);
                $stmtPayment->bind_param("si", $paymentStatus, $id);
                $ok = $stmtPayment->execute();
                $stmtPayment->close();
            } else {
                $insertPaymentQuery = "INSERT INTO payments (order_id, payment_method, amount_paid, payment_status) VALUES (?, ?, ?, ?)";
                $stmtPayment = $conn->prepare($insertPaymentQuery);
                $stmtPayment->bind_param("isds", $id, $order['payment_method'], $order['total_amount'], $paymentStatus);
                $ok = $stmtPayment->execute();
                $stmtPayment->close();
            }

            if ($ok) {
                echo json_encode(['status' => 'success', 'message' => 'Payment status updated successfully.']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Failed to update payment status. Please try again later.']);
            }

            $conn->close();
            exit();
        }else if ($type === 'status') {
            if (empty($status)) {
                echo json_encode(['status' => 'error', 'message' => 'Order status is required.']);
                $conn->close();
                exit();
            }
            // Update order status in the database
            $updateQuery = "UPDATE orders SET status = ? WHERE order_id = ?";
            $stmt = $conn->prepare($updateQuery);
            $stmt->bind_param("si", $status, $id);

            if ($stmt->execute()) {
                echo json_encode(['status' => 'success', 'message' => 'Order updated successfully.']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Failed to update order. Please try again later.']);
            }
            $stmt->close();
            $conn->close();
            exit();
        } else if  ($type === 'itemStatus') {
            if (empty($itemStatus)) {
                echo json_encode(['status' => 'error', 'message' => 'Item status is required.']);
                $conn->close();
                exit();
            }
            // Update item status in the database
            $updateItemQuery = "UPDATE menu_items SET status = ? WHERE item_id = ?";
            $stmtItem = $conn->prepare($updateItemQuery);
            $stmtItem->bind_param("si", $itemStatus, $id);

            if ($stmtItem->execute()) {
                echo json_encode(['status' => 'success', 'message' => 'Item status updated successfully.']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Failed to update item status. Please try again later.']);
            }

            $stmtItem->close();
            $conn->close();
            exit();
        } else if ($type === 'planStatus') {
            if (empty($planStatus)) {
                echo json_encode(['status' => 'error', 'message' => 'Plan status is required.']);
                $conn->close();
                exit();
            }
            // Update meal plan status in the database
            $updatePlanQuery = "UPDATE meal_plans SET status = ? WHERE plan_id = ?";
            $stmtPlan = $conn->prepare($updatePlanQuery);
            $stmtPlan->bind_param("si", $planStatus, $id);

            if ($stmtPlan->execute()) {
                echo json_encode(['status' => 'success', 'message' => 'Meal plan status updated successfully.']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Failed to update meal plan status. Please try again later.']);
            }

            $stmtPlan->close();
            $conn->close();
            exit();
        }else {
            echo json_encode(['status' => 'error', 'message' => 'Invalid update type.']);
            $conn->close();
            exit();
        }
        
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
        $conn->close();
        exit();
    }
?>
