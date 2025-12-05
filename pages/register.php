<?php 
$pageTitle = "Register - ArcherInnov Canteen Pre-order System";
include ('../includes/initial.php'); 
?>

<main class="container my-5 fullHeight">

    <div class="card">
        <form class="needs-validation" id="registerForm" name="registerForm" method="POST" novalidate>
            <header>
                <h2 class="text-center mb-4">Create a New Account</h2>
            </header>
            <br>
            <div class="mb-3">
                <label for="fullname" class="form-label">Full Name:</label>
                <input type="text" class="form-control" id="fullname" name="fullname" required minlength="2" pattern="^[A-Za-zÀ-ÿ' -]{2,} [A-Za-zÀ-ÿ' -]{2,}$">
                <div class="invalid-feedback">Please input a valid name</div>
            </div>

            <div class="mb-3">
                <label for="username" class="form-label">Username:</label>
                <input type="text" class="form-control" id="username" name="username" required minlength="2">
                <div class="invalid-feedback">Please input a valid username</div>
            </div>

            <div class="mb-3">
              <label for="email" class="form-label">Email address:</label>
              <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp" pattern="^[^\s@]+@[^\s@]+\.[^\s@]+$" required>
              <div class="invalid-feedback">Enter a valid email address.</div>
              <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password:</label>
                <input type="password" class="form-control" id="password" name="password" required minlength="8" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).+$">
                <div class="invalid-feedback">Please input a valid password</div>
            </div>

            <div class="mb-3 confirm_password">
                <label for="confirm_password" class="form-label">Confirm Password:</label>
                <input type="password" class="form-control" id="confirm_password" name="confirm_password" required minlength="8" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).+$">
                <div class="invalid-feedback">Please confirm your password</div>
            </div>

            <div>
              <p class="form-text">Password Requirements</p>
              <ul class="form-text">
                  <li>At least 8 characters</li>
                  <li>A lowercase letter</li>
                  <li>An uppercase letter</li>
                  <li>A number</li>
                  <li>A symbol</li>
                  <li>No parts of your username</li>
                  <li>Does not include any of your names</li>
                </ul>
            </div>

            <br>
            <div class="mb-3">
                <button type="submit" class="btn btn-success">Register</button>
            </div>
            
            <div class="mb-3">
                <p>Already have an account? <a href="login.php">Login here.</a></p>
            </div>

            <div><p id="registerError" class="error-message text-danger text-center mt-2"></p></div>
            <div id="message"></div>
        </form>
</main>
<?php include ('../includes/footer.php'); ?>