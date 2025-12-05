<?php
    // Admin edits to menu items with optional image replacement.
    session_start();

    include('../../config/db.php');

    if ($_SERVER['REQUEST_METHOD'] === 'POST'){
        // Retrieve and sanitize form inputs
        $item_id = intval($_POST['item_id']);
        $item_name = $conn->real_escape_string(trim($_POST['item_name']));
        $category = $conn->real_escape_string(trim($_POST['category']));
        $description = $conn->real_escape_string(trim($_POST['description']));
        $price = floatval($_POST['price']);
        $stock = intval($_POST['stock']);
        $status = $conn->real_escape_string(trim($_POST['status']));

        // Handle file upload if a new image is provided
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $fileTmpPath = $_FILES['image']['tmp_name'];
            $fileName = $_FILES['image']['name'];
            $fileSize = $_FILES['image']['size'];
            $fileType = $_FILES['image']['type'];
            $fileNameCmps = explode(".", $fileName);
            $fileExtension = strtolower(end($fileNameCmps));

            // Sanitize file name
            $newFileName = md5(time() . $fileName) . '.' . $fileExtension;

            // Check if the file has one of the allowed extensions
            $allowedfileExtensions = array('jpg', 'gif', 'png', 'jpeg');
            if (in_array($fileExtension, $allowedfileExtensions)) {
                // Directory in which the uploaded file will be moved
                $uploadFileDir = '../../assets/images/menu_items/';
                $dest_path = $uploadFileDir . $newFileName;

                // Move the file to the destination directory
                if(move_uploaded_file($fileTmpPath, $dest_path)) {
                    // Update database with new image
                    $sql = "UPDATE menu_items SET item_name = ?, category = ?, price = ? , stock = ?, description = ?, image = ?, status= ? WHERE item_id = ?";
                    $stmt = $conn->prepare($sql);  
                    $stmt->bind_param("ssdssssi", $item_name, $category, $price, $stock, $description, $newFileName, $status, $item_id);

                    if ($stmt->execute()) {
                        echo json_encode(["status" => "success", "message" => "Menu item updated successfully."]);
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
                    echo json_encode(["status" => "error", "message" => "Error moving the uploaded file."]);
                    $conn->close();
                    exit();
                }
            } else {
                echo json_encode(["status" => "error", "message" => "Invalid file extension."]);
                $conn->close();
                exit();
            }
        } 
       
        // Update database without changing the image
        $sql = "UPDATE menu_items SET
            item_name='$item_name', 
            category='$category', 
            price=$price, 
            stock=$stock, 
            description='$description', 
            status='$status' 
            WHERE item_id=$item_id";

        if ($conn->query($sql) === TRUE) {
            echo json_encode(["status" => "success", "message" => "Menu item updated successfully."]);
            $conn->close();
            exit();
        } else {
            echo json_encode(["status" => "error", "message" => "Database error: " . $conn->error]);
            $conn->close();
            exit();
        }

    } else {
        echo json_encode(["status" => "error", "message" => "Invalid request method."]);
        $conn->close();
        exit();
    }
      
?>
