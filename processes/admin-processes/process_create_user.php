<?php
    session_start();
    include('../../config/db.php');

    if ($_SERVER['REQUEST_METHOD'] === 'POST'){ 
        // Retrieve and sanitize form inputs
        $username = $conn->real_escape_string(trim($_POST['username']));
        $fullname = $conn->real_escape_string(trim($_POST['full_name']));
        $email = $conn->real_escape_string(trim($_POST['email']));
        $password = $_POST['password'];
        $user_type = $conn->real_escape_string(trim($_POST['user_type']));

        // validation
        if (empty($username) || empty($fullname) || empty($email) || empty($password) || empty($user_type)) {
            echo json_encode(['status' => 'error', 'message' => 'All fields are required.']);
            exit;
        }
      
         // Check if username or email already exists
        $sql = "SELECT * FROM users WHERE username = ? OR email = ?";
        $stmt1 = $conn->prepare($sql);
        $stmt1->bind_param("ss", $username, $email);
        $stmt1->execute();
        $result = $stmt1->get_result();
        if ($result->num_rows > 0) {
            echo json_encode(['status' => 'error', 'message' => 'Username or Email already exists.']);
            exit;
        }
        $stmt1->close();
        
        // Hash the password before storing
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        $query = "INSERT INTO users (username, password, full_name, email, user_type) VALUES (?, ?, ?, ?, ?)";
        $stmt2 = $conn->prepare($query);
        $stmt2->bind_param("sssss", $username, $hashed_password, $fullname, $email, $user_type);

        if ($stmt2->execute()) {
            echo json_encode(['status' => 'success', 'message' => 'User created successfully.']);
            $stmt2->close();
            $conn->close();
            exit;
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Error creating user. Please try again.']);
            $stmt2->close();
            $conn->close();
            exit;
        }

       
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
        $conn->close();
        exit();
    }

?>