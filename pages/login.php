<?php
session_start();
?>

<?php include "../includes/initial.php"; ?>
        
<main class="container my-5 fullHeight">

    <?php if(isset($_SESSION['error'])): ?>
        <p class="error"><?= $_SESSION['error']; unset($_SESSION['error']); ?></p>
    <?php endif; ?>

    <div class="card" id="login-auth">
        <form class="needs-validation" id="loginForm" name="loginForm" action="../processes/process_login.php" method="POST" novalidate>
            <header>
                <h2 class="text-center mb-4">Login to Your Account</h2>
            </header>
            <br>
            <div class="mb-3">
                <label for="username" class="form-label">Username:</label>
                <input type="text" class="form-control" id="username" name="username" required>
                <div class="invalid-feedback">Please input valid username</div>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password:</label>
                <input type="password" class="form-control" id="password" name="password" required>
                <div class="invalid-feedback">Please input valid password</div>
            </div>
            <br>
            <div class="mb-3">
                <button type="submit" class="btn btn-success">Login</button>
            </div>
            
            <div class="mb-3">
                <p>Don't have an account? <a href="register.php">Register here.</a></p>
            </div>

            <div><p id="loginError" class="error-message text-danger mt-2"></p></div>
        </form>
    </div>
</main>

<?php include('../includes/footer.php'); ?>
