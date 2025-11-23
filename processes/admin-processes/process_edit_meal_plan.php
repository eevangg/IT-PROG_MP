<?php
    session_start();

    include('../../config/db.php');

    if ($_SERVER['REQUEST_METHOD'] === 'POST'){
        // Retrieve and sanitize form inputs
        $plan_id = intval($_POST['plan_id']);
        $item_id = intval($_POST['item_id']);
        $day_of_week = $conn->real_escape_string(trim($_POST['day_of_week']));
        $weekStartDate = $conn->real_escape_string(trim($_POST['week_start']));
        $available_qty = intval($_POST['available_qty']);

        // check if the week start date is a Monday
        $date = new DateTime($weekStartDate);   
        if ($date->format('N') != 1) {
            echo json_encode(["status" => "error", "message" => "Week start date must be a Monday."]);
            $conn->close();
            exit();
        }

        // Update meal plan in the database
        $sql = "UPDATE meal_plans SET item_id = ?, day_of_week = ?, week_start = ?, available_qty = ? WHERE plan_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("issii", $item_id, $day_of_week, $weekStartDate, $available_qty, $plan_id);
        if ($stmt->execute()) {
            echo json_encode(["status" => "success", "message" => "Meal plan updated successfully."]);
            $stmt->close();
            $conn->close();
            exit();
        } else {
            echo json_encode(["status" => "error", "message" => "Database error: " . $conn->error]);
            $stmt->close();
            $conn->close();
            exit();
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Invalid request method."]);
        exit();
    }
?>