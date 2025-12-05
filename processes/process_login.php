<?php
    session_start();
    include "../config/db.php";
    require_once __DIR__ . '/../includes/cart_functions.php';

    // Derive project path from document root so redirects are absolute within localhost
    $projectRoot = str_replace('\\', '/', realpath(dirname(__DIR__)));
    $docRoot = str_replace('\\', '/', rtrim($_SERVER['DOCUMENT_ROOT'] ?? '', '/'));

    $basePath = '';
    if ($projectRoot !== false && $docRoot !== '') {
        $projectLower = strtolower($projectRoot);
        $docRootLower = strtolower($docRoot);
        if (strpos($projectLower, $docRootLower) === 0) {
            $basePath = substr($projectRoot, strlen($docRoot));
        }
    }

    $basePath = '/' . ltrim($basePath, '/');
    if ($basePath === '/') {
        $basePath = '';
    }

    $redirectMap = [
        'admin' => $basePath . '/pages/admin-pages/dashboard.php',
        'staff' => $basePath . '/pages/admin-pages/dashboard.php',
        'student' => $basePath . '/pages/menu.php',
    ];
    
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

                refreshSessionCart($conn, (int) $user['user_id']);
        
                // redirect based on role
                $role = 'student';
                if ($user['user_type'] === 'admin') {
                    $_SESSION['is_admin'] = true;
                    $role = 'admin';
                } elseif ($user['user_type'] === 'staff') {
                    $_SESSION['is_staff'] = true;
                    $role = 'staff';
                }

                $redirectUrl = $redirectMap[$role] ?? $redirectMap['student'];

                echo json_encode([
                    'success' => "Login successful!",
                    'role' => $role,
                    'redirect_url' => $redirectUrl
                ]);
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
