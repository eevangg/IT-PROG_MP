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

            // check if user status is active
            if ($user['status'] !== 'active') {
                echo json_encode(['error' => "Account has been deleted. Please contact support."]);
                $stmt->close();
                $conn->close();
                exit;
            }
        
            if (password_verify($password, $user['password'])) {
        
                // store session data
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['name'] = $user['full_name'];
                $_SESSION['role'] = $user['user_type'];
                $_SESSION['balance'] = $user['balance'];
                $_SESSION['member'] = $user['date_created'];
        
                // redirect based on role
                if ($user['user_type'] == 'admin') {
                    $_SESSION['is_admin'] = true;
                    echo json_encode(['success' => "Login successful!", 'role' => 'admin']);
                    //header("Location: pages/admin_dashboard.php");
                } elseif ($user['user_type'] == 'staff') {
                    echo json_encode(['success' => "Login successful!", 'role' => 'staff']);
                    //header("Location: pages/staff_dashboard.php");
                } else {
                    echo json_encode(['success' => "Login successful!", 'role' => 'student']);
                    //header("Location: pages/student_dashboard.php");
                }
                $stmt->close();
                $conn->close();
                exit;
        
            } else {
                echo json_encode(['error' => "Incorrect password!"]);
                //header("Location: login.php");
                $stmt->close();
                $conn->close();
                exit;
            }
        } else {
            echo json_encode(['error' => "Username not found!"]);
            $stmt->close();
            $conn->close();
            exit;
        }
    }
?>