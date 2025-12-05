<?php
// Admin endpoint to confirm or cancel payments, optionally refunding wallet orders inside a transaction.
session_start();

// Check if user is admin
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    http_response_code(403);
    exit("Access denied");
}

// Check if request method is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(400);
    exit("Invalid request method");
}

include('../../config/db.php');

$order_id = filter_input(INPUT_POST, 'order_id', FILTER_VALIDATE_INT);
$status = filter_input(INPUT_POST, 'status', FILTER_SANITIZE_STRING);
$notes = filter_input(INPUT_POST, 'notes', FILTER_SANITIZE_STRING) ?? '';
$admin_id = $_SESSION['user_id'] ?? null;

// Validate inputs
if (!$order_id || !in_array($status, ['confirmed', 'cancelled'])) {
    $_SESSION['error'] = "Invalid request data";
    header("Location: ../../pages/admin-pages/payment_confirmations.php");
    exit();
}

try {
    // Get order details first
    $get_order = "SELECT o.user_id, o.total_amount, o.payment_method FROM orders o WHERE o.order_id = ?";
    $stmt = $conn->prepare($get_order);
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 0) {
        $_SESSION['error'] = "Order not found";
        header("Location: ../../pages/admin-pages/payment_confirmations.php");
        exit();
    }
    
    $order = $result->fetch_assoc();
    $stmt->close();
    
    // Start transaction
    $conn->begin_transaction();
    
    // Update order status
    $update_sql = "UPDATE orders SET status = ? WHERE order_id = ?";
    $stmt = $conn->prepare($update_sql);
    $stmt->bind_param("si", $status, $order_id);
    $stmt->execute();
    $stmt->close();
    
    // If cancelled and payment was from wallet, refund the amount
    if ($status === 'cancelled' && $order['payment_method'] === 'wallet') {
        $refund_sql = "UPDATE users SET balance = balance + ? WHERE user_id = ?";
        $stmt = $conn->prepare($refund_sql);
        $stmt->bind_param("di", $order['total_amount'], $order['user_id']);
        $stmt->execute();
        $stmt->close();
    }
    
    // Log the action (optional - requires audit_log table)
    // You can add audit logging here if needed
    
    $conn->commit();
    
    $_SESSION['success'] = "Payment " . ($status === 'confirmed' ? 'confirmed' : 'cancelled') . " successfully";
    
} catch (Exception $e) {
    $conn->rollback();
    $_SESSION['error'] = "An error occurred: " . $e->getMessage();
}

$conn->close();
header("Location: ../../pages/admin-pages/payment_confirmations.php");
exit();
?>
