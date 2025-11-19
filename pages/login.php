<?php 
$pageTitle = "Login - ArcherInnov Canteen Pre-order System";
include "../includes/initial.php"; 

if (isset($_SESSION['user_id'])) {
    header("Location: menu.php");
    exit();
}
?>
        
<main class="container my-5 fullHeight">

    <div class="card" id="login-auth">
        <form class="needs-validation" id="loginForm" name="loginForm" method="POST" novalidate>
            <header>
                <h2 class="text-center mb-4">Login to Your Account</h2>
            </header>
            <br>
            <div class="mb-3">
                <label for="loginUsername" class="form-label">Username:</label>
                <input type="text" class="form-control" id="loginUsername" name="loginUsername" required>
                <div class="invalid-feedback">Please input valid username</div>
            </div>

            <div class="mb-3">
                <label for="loginPassword" class="form-label">Password:</label>
                <input type="password" class="form-control" id="loginPassword" name="loginPassword" required>
                <div class="invalid-feedback">Please input valid password</div>
            </div>
            <div id="forgotPassword" class="form-text"><a href="forgot_password.php">Forgot Password?</a></div>
            <br>

            <div class="mb-3 ">
                <button type="submit" class="btn btn-success">Login</button>
            </div>
            <br>
            <hr>
            <footer>
            <div class="mb-3 text-center">
                <p>Don't have an account? <a href="register.php">Register here.</a></p>
            </div>
            </footer>
            
            <div><p id="loginFeedback" class="feedback-message text-danger mt-2"></p></div>
        </form>
    </div>
</main>

<?php include('../includes/footer.php'); ?>
