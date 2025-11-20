<?php
    session_start();
    // Include database configuration 
    include('../../config/db.php');

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = json_decode(file_get_contents("php://input"), true);

        $orderId = intval($data['order_id']);

        // Validate inputs
        if (empty($orderId)) {
            echo json_encode(['status' => 'error', 'message' => 'Order ID is required.']);
            exit();
        }

        // Delete order from the database
        $deleteQuery = "DELETE FROM orders WHERE order_id = ?";
        $stmt = $conn->prepare($deleteQuery);
        $stmt->bind_param("i", $orderId);

        //count the total orders left
        $totalOrdersQuery = "SELECT COUNT(*) as count FROM orders";
        $stmtCount = $conn->prepare($totalOrdersQuery);
        $stmtCount->execute();
        $result = $stmtCount->get_result();
        $totalOrders = $result->fetch_assoc()['count'];
        $stmtCount->close();

        if ($stmt->execute()) {
            echo json_encode(['status' => 'success', 'message' => 'Order deleted successfully.', 'total_orders' => $totalOrders]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to delete order. Please try again later.']);
        }
        $stmt->close();
        $conn->close();
        exit();
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
        exit();
    }

?>