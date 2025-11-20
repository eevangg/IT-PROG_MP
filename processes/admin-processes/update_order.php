<?php
    session_start();
    // Include database configuration 
    include('../../config/db.php');

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $raw = file_get_contents("php://input");

        $data = json_decode($raw, true);

        $orderId = $_POST['order_id'];
        $status = $_POST['status'];
        $paymentStatus = $_POST['payment_status'] ;
        $type = $_POST['type'];

        // Validate inputs
        if (empty($orderId) || empty($type)) {
            echo json_encode(['status' => 'error', 'message' => 'Order ID and type are required.']);
            exit();
        }

        if ($type === 'payment') {
            if (empty($paymentStatus)) {
                echo json_encode(['status' => 'error', 'message' => 'Payment status is required.']);
                exit();
            }

            // Update payment status in the database
            $updatePaymentQuery = "UPDATE payments SET payment_status = ? WHERE order_id = ?";
            $stmtPayment = $conn->prepare($updatePaymentQuery);
            $stmtPayment->bind_param("si", $paymentStatus, $orderId);

            if ($stmtPayment->execute()) {
                echo json_encode(['status' => 'success', 'message' => 'Payment status updated successfully.']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Failed to update payment status. Please try again later.']);
            }

            $stmtPayment->close();
            $conn->close();
            exit();
        }else if ($type === 'status') {
            if (empty($status)) {
                echo json_encode(['status' => 'error', 'message' => 'Order status is required.']);
                exit();
            }
            // Update order status in the database
            $updateQuery = "UPDATE orders SET status = ? WHERE order_id = ?";
            $stmt = $conn->prepare($updateQuery);
            $stmt->bind_param("si", $status, $orderId);

            if ($stmt->execute()) {
                echo json_encode(['status' => 'success', 'message' => 'Order updated successfully.']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Failed to update order. Please try again later.']);
            }
            $stmt->close();
            $conn->close();
            exit();
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Invalid update type.']);
            exit();
        }
        
    } else {
        header("Location: ../pages/manage_orders.php");
        exit();
    }
?>