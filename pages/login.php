<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login - School Canteen Pre-order System</title>

        <link rel="stylesheet" href="style.css">
    </head>

    <body>
        <header>
            <nav class="navbar">
                <div class="logo">
                    <a href="homepage.php"><h1>School Canteen Pre-order System</h1></a>
                </div>
                
                <ul>
                    <li><a href="login.php">Login</a></li>
                    <li><a href="create.php">Create Order</a></li>
                    <li><a href="read.php">View Orders</a></li>
                    <li><a href="update.php">Edit Order</a></li>
                    <li><a href="delete.php">Delete Orders</a></li>
                </ul>
            </nav>
        </header>
        
        <main>
            <div class="container">
                <h2>Login</h2>
                <form action="authenticate.php" method="POST">
                    <label for="user_id">Student/Staff ID:</label>
                    <input type="text" id="user_id" name="user_id" required>

                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" required>

                    <button type="submit">Login</button>
                </form>
            </div>
        </main>
    </body>
</html>