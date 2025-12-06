<?php
    // Admin creation of meal plan entries (day/week availability per item).
    session_start();

    include('../../config/db.php');

    if ($_SERVER['REQUEST_METHOD'] === 'POST'){ 
        // Retrieve and sanitize form inputs
        $item_id = intval($_POST['item_id']);
        $day_of_week = $conn->real_escape_string(trim($_POST['day_of_week']));
        $weekStart = $conn->real_escape_string(trim($_POST['week_start']));
        $available_qty = intval($_POST['available_qty']);

        $dayOfWeek = date('N', strtotime($week_start)); // Monday = 1

        if ($dayOfWeek != 1) {
            echo json_encode(["status" => "error", "message" => "Week must start on a Monday"]);
            exit();
        }

        // Insert into database
        $sql = "INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty) 
                VALUES ($item_id, '$day_of_week', '$weekStart', $available_qty)";
        if ($conn->query($sql) === TRUE) {
            echo json_encode(["status" => "success", "message" => "Meal plan created successfully."]);
        } else {
            echo json_encode(["status" => "error", "message" => "Database error: " . $conn->error]);
        }
        $conn->close();
    } else {
        echo json_encode(["status" => "error", "message" => "Invalid request method."]);
        $conn->close();
    }
?>
