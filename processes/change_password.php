<?php
    // Handle user password changes with current password verification.
    session_start();
    include("../config/db.php");

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $currentPassword = $_POST['current_password'];
        $newPassword = $_POST['new_password'];
        $confirmPassword = $_POST['confirm_password'];

        $userId = $_SESSION['user_id'];

        // Fetch the current password hash from the database
        $stmt = $conn->prepare("SELECT password FROM users WHERE user_id = ?");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        // Verify current password
        if ($user && password_verify($currentPassword, $user['password'])) {
            if ($newPassword === $confirmPassword) {
                // Update the password
                $newPasswordHash = password_hash($newPassword, PASSWORD_BCRYPT);
                $updateStmt = $conn->prepare("UPDATE users SET password = ? WHERE user_id = ?");
                $updateStmt->bind_param("si", $newPasswordHash, $userId);
                if ($updateStmt->execute()) {
                    echo json_encode(["status" => "success", "message" => "Password updated successfully."]);
                } else {
                    echo json_encode(["status" => "error", "message" => "Failed to update password. Please try again later."]);
                }
                $updateStmt->close();
            } else {
                echo json_encode(["status" => "error", "message" => "New password and confirm password do not match."]);
            }
        } else {
            echo json_encode(["status" => "error", "message" => "Current password is incorrect."]);
        }

        $stmt->close();
        $conn->close();
    }
?>
