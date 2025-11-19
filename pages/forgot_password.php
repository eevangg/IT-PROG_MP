<?php 
$pageTitle = "Password Recovery - ArcherInnov Canteen Pre-order System";
include "../includes/initial.php"; 

if (isset($_SESSION['user_id'])) {
    header("Location: menu.php");
    exit();
}
?>

<main class="container my-5 fullHeight">
    <div class="card" id="forgot-password-auth">
        <form class="needs-validation" id="forgotPasswordForm" name="forgotPasswordForm" method="POST" novalidate>
            <header>
                <h2 class="text-center mb-4">Forgot Your Password?</h2>
            </header>
            <br>
            <div class="mb-3">
                <label for="forgotEmail" class="form-label">Enter your registered email address:</label>
                <input type="email" class="form-control" id="forgotEmail" name="forgotEmail" required pattern="^[^\s@]+@[^\s@]+\.[^\s@]+$">
                <div class="invalid-feedback">Please input a valid email address</div>
            </div>
            <br>

            <div class="mb-3 ">
                <button type="submit" class="btn btn-success">Send Recovery Link</button>
            </div>
            <br>
            <hr>
            <footer>
            <div class="mb-3 text-center">
                <p>Remembered your password? <a href="login.php">Login here.</a></p>
            </div>
            </footer>
            
            <div><p id="forgotPasswordFeedback" class="feedback-message text-danger mt-2"></p></div>
        </form>
    </div>
</main>

<?php include('../includes/footer.php'); ?>