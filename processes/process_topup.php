<?php
session_start();
include "../config/db.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 1. Capture where the user came from (Default to 'checkout')
    $redirect_source = $_POST['redirect_to'] ?? 'checkout'; 

    // Validate session
    if (!isset($_SESSION['user_id'])) {
        $_SESSION['cart_feedback'] = ['type' => 'danger', 'message' => 'Session expired. Please login again.'];
        header("Location: ../pages/login.php");
        exit();
    }

    $user_id = $_SESSION['user_id'];
    $topup_amount = $_POST['topup_amount'] ?? null;

    // Define redirect function to avoid code repetition
    function doRedirect($source) {
        if ($source === 'profile') {
            header("Location: ../pages/profile.php");
        } else {
            header("Location: ../pages/checkout.php");
        }
        exit();
    }

    // Validate amount
    if (!$topup_amount || $topup_amount <= 0) {
        $_SESSION['cart_feedback'] = ['type' => 'danger', 'message' => 'Please enter a valid amount.'];
        doRedirect($redirect_source);
    }

    // Validate amount is numeric
    if (!is_numeric($topup_amount)) {
        $_SESSION['cart_feedback'] = ['type' => 'danger', 'message' => 'Amount must be a valid number.'];
        doRedirect($redirect_source);
    }

    $topup_amount = floatval($topup_amount);

    try {
        // Check if topup requests table exists, if not create it
        $sql = "CREATE TABLE IF NOT EXISTS topup_requests (
                  request_id INT NOT NULL AUTO_INCREMENT,
                  user_id INT NOT NULL,
                  amount DECIMAL(10,2) NOT NULL,
                  status ENUM('pending', 'approved', 'rejected') DEFAULT 'pending',
                  request_date DATETIME DEFAULT CURRENT_TIMESTAMP,
                  approved_date DATETIME NULL,
                  PRIMARY KEY (request_id),
                  INDEX user_id (user_id ASC),
                  CONSTRAINT topup_requests_ibfk_1
                    FOREIGN KEY (user_id)
                    REFERENCES users (user_id)
                    ON DELETE CASCADE
                    ON UPDATE CASCADE
                ) ENGINE = InnoDB DEFAULT CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci";
        
        $conn->query($sql);

        // Insert topup request
        $sql = "INSERT INTO topup_requests (user_id, amount, status) VALUES (?, ?, 'pending')";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            throw new Exception("Prepare failed: " . $conn->error);
        }
        $stmt->bind_param("id", $user_id, $topup_amount);
        if (!$stmt->execute()) {
            throw new Exception("Execute failed: " . $stmt->error);
        }
        $stmt->close();

        // Success Message
        $_SESSION['cart_feedback'] = [
            'type' => 'success', 
            'message' => 'Top-up request submitted! Amount: ₱' . number_format($topup_amount, 2) . ' is pending admin approval.'
        ];

    } catch (Exception $e) {
        $_SESSION['cart_feedback'] = ['type' => 'danger', 'message' => 'Top-up failed: ' . $e->getMessage()];
    } finally {
        $conn->close();
    }

    // Final Redirect based on source
    doRedirect($redirect_source);

} else {
    // If someone tries to access file directly without POST
    header("Location: ../pages/checkout.php");
    exit();
}
?>
