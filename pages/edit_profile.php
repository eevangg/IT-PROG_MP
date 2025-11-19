<?php
$pageTitle = "Edit Profile - ArcherInnov Canteen Pre-order System";
include('../includes/header.php');
?>

<main class="container my-5 fullHeight">
    <div class="go-back text-left mb-4">
        <button class="btn text-success" onclick="window.location.href='profile.php'">
            <i class="bi bi-arrow-left"></i> Back
        </button>
    </div>

    <div class="d-flex justify-content-between align-items-center w-100 mb-3">
        <h2 class="text-center flex-grow-1 fw-bold text-success">Edit Profile</h2>
    </div>

    <form class="needs-validation" id="editProfileForm" method="POST" style="max-width:600px;margin:0 auto;" novalidate>
        <div class="mb-3">
            <label for="name" class="form-label">Full Name</label>
            <input type="text" class="form-control" id="name" name="name" value="<?= htmlspecialchars($_SESSION['name']) ?>" required minlength="2">
            <div class="invalid-feedback">Name must be at least 2 characters long.</div>
        </div>
        <div class="mb-3">
            <label for="editUsername" class="form-label">Username</label>
            <input type="text" class="form-control" id="editUsername" name="editUsername" value="<?= htmlspecialchars($_SESSION['username']) ?>" required minlength="2">
            <div class="invalid-feedback">Username must be at least 2 characters long.</div>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email address</label>
            <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($_SESSION['email']) ?>" required pattern="^[^\s@]+@[^\s@]+\.[^\s@]+$">
            <div class="invalid-feedback">Enter a valid email address.</div>
        </div>
        
        <button type="submit" class="btn btn-success d-grid gap-2 w-100">Update Profile</button>
    </form>

    <br>
    <div id="editMessage"></div>
</main>


<?php include('../includes/footer.php'); ?>