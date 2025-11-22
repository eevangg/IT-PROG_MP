<?php
session_start();
include('../config/db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $username = trim($_POST['editUsername']);

    // Validate inputs
    if (empty($name) || empty($email) || empty($username)) {
        echo json_encode(['status' => 'error', 'message' => 'All fields are required.']);
        exit();
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid email format.']);
        exit();
    }

    // Check for username and email uniqueness
    $userId = $_SESSION['user_id'];

    $checkQuery = "SELECT user_id FROM users WHERE (username = ? OR email = ?) AND user_id != ?";
    $stmt1 = $conn->prepare($checkQuery);
    $stmt1->bind_param("ssi", $username, $email, $userId);
    $stmt1->execute();
    $result = $stmt1->get_result();
    if ($result->num_rows > 0) {
        echo json_encode(['status' => 'error', 'message' => 'Username or Email already taken by another user.']);
        $stmt1->close();
        exit();
    }

    // Update user profile in the database
    $updateQuery = "UPDATE users SET username = ?, full_name = ?, email = ? WHERE user_id = ?";
    $stmt2 = $conn->prepare($updateQuery);
    $stmt2->bind_param("sssi", $username, $name, $email, $userId);

    if ($stmt2->execute()) {
        // Update session variables
        $_SESSION['name'] = $name;
        $_SESSION['email'] = $email;
        $_SESSION['username'] = $username;
        echo json_encode(['status' => 'success', 'message' => 'Profile updated successfully.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to update profile. Please try again later.']);
    }

    $stmt2->close();
    $conn->close();
    exit();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
    $conn->close();
    exit();
}
?>