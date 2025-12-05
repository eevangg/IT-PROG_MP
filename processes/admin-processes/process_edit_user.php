<?php
    // Admin update endpoint for user records, including optional password resets.
    session_start();
    include('../../config/db.php');

    header('Content-Type: application/json');

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
        $conn->close();
        exit();
    }

    $user_id = intval($_POST['user_id'] ?? 0);
    $full_name = trim($_POST['full_name'] ?? '');
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $user_type = trim($_POST['user_type'] ?? '');
    $status = trim($_POST['status'] ?? '');
    $new_password = $_POST['new_password'] ?? '';
    $confirm_new_password = $_POST['confirm_new_password'] ?? '';

    if ($user_id <= 0 || $full_name === '' || $username === '' || $email === '' || $user_type === '' || $status === '') {
        echo json_encode(['status' => 'error', 'message' => 'All required fields must be filled.']);
        $conn->close();
        exit();
    }

    if ($new_password !== '' || $confirm_new_password !== '') {
        if ($new_password !== $confirm_new_password) {
            echo json_encode(['status' => 'error', 'message' => 'Passwords do not match.']);
            $conn->close();
            exit();
        }

        if (strlen($new_password) < 8) {
            echo json_encode(['status' => 'error', 'message' => 'Password must be at least 8 characters.']);
            $conn->close();
            exit();
        }
    }

    // Ensure the user exists before attempting an update.
    $existingStmt = $conn->prepare("SELECT user_id, user_type, status FROM users WHERE user_id = ?");
    $existingStmt->bind_param("i", $user_id);
    $existingStmt->execute();
    $existingResult = $existingStmt->get_result();
    if ($existingResult->num_rows === 0) {
        echo json_encode(['status' => 'error', 'message' => 'User not found.']);
        $existingStmt->close();
        $conn->close();
        exit();
    }
    $existingUser = $existingResult->fetch_assoc();
    $existingStmt->close();

    // Limit status and role to known values, but preserve the user's current values if they are already outside the defaults.
    $allowedStatuses = ['active', 'inactive', $existingUser['status']];
    if (!in_array($status, $allowedStatuses, true)) {
        $status = $existingUser['status'];
    }

    $allowedRoles = ['admin', 'staff', 'customer', $existingUser['user_type']];
    if (!in_array($user_type, $allowedRoles, true)) {
        $user_type = $existingUser['user_type'];
    }

    // Enforce unique username/email while editing (ignore the current user).
    $uniqueStmt = $conn->prepare("SELECT user_id FROM users WHERE (username = ? OR email = ?) AND user_id <> ?");
    $uniqueStmt->bind_param("ssi", $username, $email, $user_id);
    $uniqueStmt->execute();
    $uniqueResult = $uniqueStmt->get_result();
    if ($uniqueResult->num_rows > 0) {
        echo json_encode(['status' => 'error', 'message' => 'Username or email already exists.']);
        $uniqueStmt->close();
        $conn->close();
        exit();
    }
    $uniqueStmt->close();

    if ($new_password !== '') {
        // Only touch the password when a new one is provided.
        $hashedPassword = password_hash($new_password, PASSWORD_BCRYPT);
        $updateSql = "UPDATE users SET username = ?, full_name = ?, email = ?, user_type = ?, status = ?, password = ? WHERE user_id = ?";
        $updateStmt = $conn->prepare($updateSql);
        $updateStmt->bind_param("ssssssi", $username, $full_name, $email, $user_type, $status, $hashedPassword, $user_id);
    } else {
        $updateSql = "UPDATE users SET username = ?, full_name = ?, email = ?, user_type = ?, status = ? WHERE user_id = ?";
        $updateStmt = $conn->prepare($updateSql);
        $updateStmt->bind_param("sssssi", $username, $full_name, $email, $user_type, $status, $user_id);
    }

    if ($updateStmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'User updated successfully.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error updating user: ' . $conn->error]);
    }

    $updateStmt->close();
    $conn->close();
?>
