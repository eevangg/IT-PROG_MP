<?php
    // processes/process_admin_topup.php
    session_start();
    include('../../config/db.php');

    // Basic Admin Security Check (Adjust 'role' or 'is_admin' based on your users table)
    // if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    //     header("Location: ../pages/login.php");
    //     exit();
    // }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $request_id = $_POST['request_id'];
        $action = $_POST['action']; // 'approve' or 'reject'

        if (!$request_id || !in_array($action, ['approve', 'reject'])) {
            $_SESSION['admin_msg'] = ['type' => 'danger', 'text' => 'Invalid request.'];
            header("Location: ../../pages/admin-pages/manage_topup_requests.php");
            exit();
        }

        // fetch the request details first
        $stmt = $conn->prepare("SELECT user_id, amount, status FROM topup_requests WHERE request_id = ?");
        $stmt->bind_param("i", $request_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $request = $result->fetch_assoc();

        if (!$request) {
            $_SESSION['admin_msg'] = ['type' => 'danger', 'text' => 'Request not found.'];
            header("Location: ../../pages/admin-pages/manage_topup_requests.php");
            exit();
        }

        if ($request['status'] !== 'pending') {
            $_SESSION['admin_msg'] = ['type' => 'warning', 'text' => 'This request has already been processed.'];
            header("Location: ../../pages/admin-pages/manage_topup_requests.php");
            exit();
        }

        // Start Transaction
        $conn->begin_transaction();

        try {
            if ($action === 'approve') {
                // 1. Update Request Status
                $updateStmt = $conn->prepare("UPDATE topup_requests SET status = 'approved', approved_date = NOW() WHERE request_id = ?");
                $updateStmt->bind_param("i", $request_id);
                $updateStmt->execute();

                // 2. Update User Balance
                // assuming your users table has a 'balance' column
                $balanceStmt = $conn->prepare("UPDATE users SET balance = balance + ? WHERE user_id = ?");
                $balanceStmt->bind_param("di", $request['amount'], $request['user_id']);
                $balanceStmt->execute();

                $msg = "Top-up approved. User balance updated.";
            } else {
                // Reject logic
                $updateStmt = $conn->prepare("UPDATE topup_requests SET status = 'rejected', approved_date = NOW() WHERE request_id = ?");
                $updateStmt->bind_param("i", $request_id);
                $updateStmt->execute();

                $msg = "Top-up request rejected.";
            }

            // Commit changes if everything worked
            $conn->commit();
            $_SESSION['admin_msg'] = ['type' => 'success', 'text' => $msg];

        } catch (Exception $e) {
            // Rollback if error occurs
            $conn->rollback();
            $_SESSION['admin_msg'] = ['type' => 'danger', 'text' => 'Error processing request: ' . $e->getMessage()];
        }

        header("Location: ../../pages/admin-pages/manage_topup_requests.php");
        exit();
    }
?>