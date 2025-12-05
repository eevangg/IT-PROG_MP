<?php
// Database credentials
$servername = "localhost:3308"; 
$username = "root";
$password = "";
$database = "canteen_preorder_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>