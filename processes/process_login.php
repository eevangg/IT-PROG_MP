<?php
    session_start();
    include "../config/db.php";
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = $_POST['loginUsername'];
        $password = $_POST['loginPassword'];

        // Secure hashed password check
        $sql = "SELECT * FROM users WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
        
            if (password_verify($password, $user['password'])) {
        
                // store session data
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['user_type'];
        
                // redirect based on role
                if ($user['user_type'] == 'admin') {
                    echo json_encode(['success' => "Login successful!", 'role' => 'admin']);
                    //header("Location: pages/admin_dashboard.php");
                } elseif ($user['user_type'] == 'staff') {
                    echo json_encode(['success' => "Login successful!", 'role' => 'staff']);
                    //header("Location: pages/staff_dashboard.php");
                } else {
                    echo json_encode(['success' => "Login successful!", 'role' => 'student']);
                    //header("Location: pages/student_dashboard.php");
                }
                exit;
        
            } else {
                echo json_encode(['error' => "Incorrect password!"]);
                header("Location: login.php");
                exit;
            }
        } else {
            $_SESSION['error'] = "Email not found!";
            header("Location: login.php");
            exit;
        }

    }
?>