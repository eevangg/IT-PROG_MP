<?php
    session_start();
    include ("../config/db.php");

    $username = $_POST['username'];
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
   
    // Hash the password before storing
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    $sql = "INSERT INTO users (username, password, full_name, email) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $username, $hashed_password, $fullname, $email);

    if ($stmt->execute()) {
        $_SESSION['success'] = "Registration successful! Please log in.";
        header("Location: login.php");
        exit;
    } else {
        $_SESSION['error'] = "Registration failed! Please try again.";
        header("Location: register.php");
        exit;
    }
?>