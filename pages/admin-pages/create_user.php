<?php
    session_start();
    $pageTitle = "Create User - ArcherInnov Canteen Pre-order System";
    include('../../includes/sidebar.php'); 
?>

<main class="admin-content container my-5 fullHeight d-flex flex-column align-items-center justify-content-start">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center w-100 mb-3">
        <div class="d-flex align-items-center gap-2">
            <!-- Back to Homepage Button -->
            <a href="../menu.php" class="btn btn-outline-success btn-sm shadow-sm">
                <i class="bi bi-house-door me-1"></i> Home
            </a>
        </div>
        <div><h1 class="text-center flex-grow-1 fw-bold text-success">Create New User</h1></div>
        <div>
            <a href="manage_users.php" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left-circle me-2"></i> Back to User Management
            </a>
        </div>
    </div>

    <!-- Create User Form -->
    <div class="card shadow-sm w-100" style="max-width: 600px;">
        <div class="card-body">
            <form class="needs-validation" method="POST" id="createUserForm" novalidate>
                <div class="mb-3">
                    <label for="full_name" class="form-label">Full Name</label>
                    <input type="text" class="form-control" id="full_name" name="full_name" required>
                    <div class="invalid-feedback">Please enter the full name.</div>
                </div>
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username" name="username" required>
                    <div class="invalid-feedback">Please enter a username.</div>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" pattern="^[^\s@]+@[^\s@]+\.[^\s@]+$" required>
                    <div class="invalid-feedback">Please enter a valid email address.</div>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" minlength="8" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).+$" required>
                    <div class="invalid-feedback">Please enter a password.</div>
                </div>
                <div class="mb-3  confirm_password">
                    <label for="confirm_password" class="form-label">Confirm Password</label>
                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" minlength="8" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).+$" required>
                    <div class="invalid-feedback">Please confirm your password.</div>
                </div>
                <div class="mb-3">
                    <label for="user_type" class="form-label">User Role</label>
                    <select class="form-select" id="user_type" name="user_type" required>
                        <option value="" disabled selected>Select Role</option>
                        <option value="admin">Admin</option>
                        <option value="staff">Staff</option>
                    </select>
                    <div class="invalid-feedback">Please select a user role.</div>
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
                <div class="text-end mt-4">
                    <button type="submit" class="btn btn-success px-4">
                        <i class="bi bi-plus-circle me-2"></i>Create User
                    </button>
                </div>
            </form>
        </div>
    </div>
</main>

<?php include('../../includes/closing.php'); ?>