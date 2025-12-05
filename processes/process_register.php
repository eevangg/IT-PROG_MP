<?php
    // Handle new user registrations with basic validation and uniqueness checks.
    session_start();
    include ("../config/db.php");

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = $_POST['username'];
        $fullname = $_POST['fullname'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Example validation
        if (empty($username) || empty($fullname) || empty($email) || empty($password)) {
            echo json_encode(['error' => 'All fields are required.']);
            exit;
        }
      
         // Check if username or email already exists
        $sql = "SELECT * FROM users WHERE username = ? OR email = ?";
        $stmt1 = $conn->prepare($sql);
        $stmt1->bind_param("ss", $username, $email);
        $stmt1->execute();
        $result = $stmt1->get_result();
        if ($result->num_rows > 0) {
            echo json_encode(['error' => 'Username or Email already exists!']);
            exit;
        }
        $stmt1->close();
        
        // Hash the password before storing
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        $query = "INSERT INTO users (username, password, full_name, email) VALUES (?, ?, ?, ?)";
        $stmt2 = $conn->prepare($query);
        $stmt2->bind_param("ssss", $username, $hashed_password, $fullname, $email);

        if ($stmt2->execute()) {
            echo json_encode(['success' => 'Registration successful!']);
            $stmt2->close();
            $conn->close();
            exit;
        } else {
            echo json_encode(['error' => 'Registration failed.']);
            $stmt2->close();
            $conn->close();
            exit;
        }

       
    } else {
        echo json_encode(['error' => 'Invalid request method.']);
        $conn->close();
        exit();
    }

?>
