<?php 
$pageTitle = "Profile - ArcherInnov Canteen Pre-order System";
include('../includes/header.php');    
?>

<main class="container my-5 fullHeight">

    <div class="d-flex justify-content-between align-items-center w-100 mb-3">
        <h2 class="text-center flex-grow-1 fw-bold text-success">User Profile</h2>
    </div>

    <!-- Welcome Section -->
    <div class="profile-overview text-center mb-4 w-100">
        <p class="fw-semibold fs-5">Welcome, <?= htmlspecialchars($_SESSION['name'])?>!</p>
        <p class="text-muted">Here you can view and manage your profile.</p>
    </div>

    <?php
        include("../config/db.php");

        $userId = $_SESSION['user_id'];

        // Fetch user statistics
        $statsQuery = "SELECT 
                            COUNT(*) AS totalOrders, 
                            COALESCE(SUM(total_amount), 0) AS totalSpend 
                        FROM orders 
                        WHERE user_id = ?";
        $stmt = $conn->prepare($statsQuery);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $statsResult = $stmt->get_result();
        $stats = $statsResult->fetch_assoc();

        $stmt->close();
        $conn->close();
    ?>

    <div class="row text-center justify-content-center w-100" style="max-width:900px;margin:0 auto;">
        <div class="col-md-4 mb-3">
            <div class="card stat-card shadow-sm border-0">
                <div class="card-body">
                    <h5 class="card-title">Balance</h5>
                    <h3 id="balance"> <?= htmlspecialchars($_SESSION['balance'])?></h3>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card stat-card shadow-sm border-0">
                <div class="card-body">
                    <h5 class="card-title">Total Orders</h5>
                    <h3 id="totalOrders"><?= htmlspecialchars($stats['totalOrders'])?></h3>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card stat-card shadow-sm border-0">
                <div class="card-body">
                    <h5 class="card-title">Total Spend</h5>
                    <h3 id="totalSpend"><?= htmlspecialchars($stats['totalSpend'])?></h3>
                </div>
            </div>
        </div>
    </div>

    <div class="card profile-card shadow-sm border-0">
        <div class="card-header bg-success text-white text-center">
            <h4 class="mb-0">Account Information</h4>
        </div>
        <div class="card-body text-center">
            <p><strong>Name:</strong> <?= htmlspecialchars($_SESSION['name']) ?></p>
            <p><strong>Email:</strong> <?= htmlspecialchars($_SESSION['email']) ?></p>
            <p><strong>Member Since:</strong> <?= htmlspecialchars($_SESSION['member']) ?></p>
        </div>
    </div>
    <br>

    <div class="profile-actions mt-4 text-center">
        <a href="edit_profile.php" class="btn btn-success mx-2">Edit Profile</a>
        <a href="#" id="changePasswordBtn" data-bs-toggle="modal" data-bs-target="#changePasswordModal" class="btn btn-warning mx-2">Change Password</a>
        <a href="#" id="deleteAccountBtn" class="btn btn-danger mx-2">Delete Account</a>
    </div>

</main>

<!-- Change Password Modal -->
<div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <form id="changePasswordForm" method="POST" class="needs-validation" data-user-id='<?= $_SESSION["user_id"] ?>' novalidate>
                    <header class="text-center">
                        <h1 class="modal-title fs-5" id="changePasswordModalLabel">Change Your Password</h1>
                    </header>
                    <br>
                    <div class="mb-3">
                        <label for="current_password" class="form-label">Current Password</label>
                        <input type="password" class="form-control" id="current_password" name="current_password" required>
                        <div class="invalid-feedback">Please enter your current password.</div>
                    </div>
                    <div class="mb-3">
                        <label for="new_password" class="form-label">New Password</label>
                        <input type="password" class="form-control" id="new_password" name="new_password" minlength="8" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).+$" required>
                        <div class="invalid-feedback">Passwords must follow requirments.</div>
                    </div>
                    <div class="mb-3">
                        <label for="confirm_password" class="form-label">Confirm New Password</label>
                        <input type="password" class="form-control" id="confirm_password" name="confirm_password" minlength="8" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).+$"  required>
                        <div class="invalid-feedback">Please confirm your new password.</div>
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
                    <div id="password_message"></div>
                    <br>
                    <div class="mb-3 text-right">
                        <button type="submit" class="btn btn-success float-end">Change Password</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

<!-- delete toast -->
<div aria-live="polite" aria-atomic="true" class="position-fixed top-50 start-50 translate-middle">
    <div id="deleteToast" class="toast background-white" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-body">
            <form id="deleteToastForm" method="post">
                <p>Are you sure you want to delete your account?</p>
                <p>This action cannot be undone!</p>

                <div id="delete_message"></div>
                <div class="mt-2 pt-2 border-top">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="toast">Close</button>
                    <button id="deleteToastBtn" type="submit" class="btn btn-danger btn-sm float-end">Confirm</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include('../includes/footer.php'); ?>