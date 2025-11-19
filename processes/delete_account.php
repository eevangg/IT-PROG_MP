<?php
    session_start();
    include("../config/db.php");

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $userId = $_SESSION['user_id'];

        // Delete user account (soft delete - set status to 'inactive')
        $stmt = $conn->prepare("UPDATE users SET status = 'inactive' WHERE user_id = ?");
        $stmt->bind_param("i", $userId);
        if ($stmt->execute()) {
            // Destroy session and redirect to homepage
            session_unset();
            session_destroy();
            echo json_encode(["status" => "success", "message" => "Account deleted successfully. Redirecting to login..."]);
        } else {
            echo json_encode(["status" => "error", "message" => "Failed to delete account. Please try again later."]);
        }

        $stmt->close();
        $conn->close();
    }
?>