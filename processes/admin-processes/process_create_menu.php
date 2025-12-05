<?php
    // Admin creation of menu items, handling image uploads and basic validation.
    session_start();

    include('../../config/db.php');

    if ($_SERVER['REQUEST_METHOD'] === 'POST'){ 
        // Retrieve and sanitize form inputs
        $item_name = $conn->real_escape_string(trim($_POST['item_name']));
        $category = $conn->real_escape_string(trim($_POST['category']));
        $description = $conn->real_escape_string(trim($_POST['description']));
        $price = floatval($_POST['price']);
        $stock = intval($_POST['stock']);
        $status = 'active'; // Default status

        // Handle file upload
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
                
                // Additional checks/Debugging
                // Check if the temporary file exists
                if (!file_exists($fileTmpPath)) {
                    echo json_encode(["status" => "error", "message" => "Temporary file does not exist."]);
                    $conn->close();
                    exit();
                }
                // Check if the upload directory exists and is writable
                if (!is_dir($uploadFileDir)) {
                    echo json_encode(["status" => "error", "message" => "Directory not found: $uploadFileDir"]);
                    $conn->close();
                    exit();
                }
                // check if the upload directory is writable
                if (!is_writable($uploadFileDir)) {
                    echo json_encode(["status" => "error", "message" => "Upload folder is not writable."]);
                    $conn->close();
                    exit();
                }

                // Move the file to the destination directory
                if(move_uploaded_file($fileTmpPath, $dest_path)) {
                    // Insert into database
                    $sql = "INSERT INTO menu_items (item_name, category, price, stock, description, image, status) 
                            VALUES ('$item_name', '$category', $price, $stock, '$description', '$newFileName', '$status')";

                    if ($conn->query($sql) === TRUE) {
                        echo json_encode(["status" => "success", "message" => "Menu item created successfully."]);
                        $conn->close();
                        exit();
                    } else {
                       echo json_encode(["status" => "error", "message" => "Database error: " . $conn->error]);
                       $conn->close();
                        exit();
                    }
                } else {
                    echo json_encode(["status" => "error", "message" => "There was an error moving the uploaded file."]);
                    $conn->close();
                    exit();
                }
            } else {
                echo json_encode(["status" => "error", "message" => "Upload failed. Allowed file types: " . implode(',', $allowedfileExtensions)]);
                $conn->close();
                exit();
            }
        } else {
            echo json_encode(["status" => "error", "message" => "There was an error with the file upload."]);
            $conn->close();
            exit();
        }

    }else{
        echo json_encode(["status" => "error", "message" => "Invalid request method."]);
        $conn->close();
        exit();
    }
?>
