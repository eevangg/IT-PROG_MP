<?php
    session_start();
    // Include database configuration 
    include('../../config/db.php');

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $raw = file_get_contents("php://input");

        $data = json_decode($raw, true);

        $id = $data['id'];
        $status = $data['status'];
        $paymentStatus = $data['payment_status'] ;
        $itemStatus = $data['item_status'];
        $type = $data['type'];

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

            // Update payment status in the database
            $updatePaymentQuery = "UPDATE payments SET payment_status = ? WHERE order_id = ?";
            $stmtPayment = $conn->prepare($updatePaymentQuery);
            $stmtPayment->bind_param("si", $paymentStatus, $id);

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
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Invalid update type.']);
            exit();
        }
        
    } else {
        header("Location: ../pages/manage_orders.php");
        exit();
    }
?>