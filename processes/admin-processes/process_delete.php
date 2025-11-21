<?php
    session_start();
    // Include database configuration 
    include('../../config/db.php');

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = json_decode(file_get_contents("php://input"), true);

        $orderId = intval($data['order_id']);
        $itemId = intval($data['item_id']);
        $action = $data['action'];

        if (empty($action)) {
            echo json_encode(['status' => 'error', 'message' => 'Action is required.']);
            exit();
        }

        if ($action === 'delete_order') {
            if (empty($orderId)) {
                echo json_encode(['status' => 'error', 'message' => 'Order ID is required.']);
                exit();
            }

             // Delete order from the database
            $deleteQuery = "DELETE FROM orders WHERE order_id = ?";
            $stmt = $conn->prepare($deleteQuery);
            $stmt->bind_param("i", $orderId);

            if ($stmt->execute()) {
                echo json_encode(['status' => 'success', 'message' => 'Order deleted successfully.']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Failed to delete order. Please try again later.']);
            }
            $stmt->close();
            $conn->close();
            exit();

        } else if ($action === 'delete_menu') {
            if (empty($itemId)) {
                echo json_encode(['status' => 'error', 'message' => 'Menu Item ID is required.']);
                exit();
            }

            // Delete menu item from the database
            $deleteQuery = "DELETE FROM menu_items WHERE item_id = ?";
            $stmt = $conn->prepare($deleteQuery);
            $stmt->bind_param("i", $itemId);

            if ($stmt->execute()) {
                echo json_encode(['status' => 'success', 'message' => 'Menu item deleted successfully.']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Failed to delete menu item. Please try again later.']);
            }
            $stmt->close();
            $conn->close();
            exit();

        } else {
            echo json_encode(['status' => 'error', 'message' => 'Invalid action specified.']);
            exit();
        }

       
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
        exit();
    }

?>