<?php
session_start();
$pageTitle = "Access Denied - ArcherInnov Canteen Pre-order System";
?>
<?php include ('../includes/header.php'); ?>

<section class="d-flex flex-column justify-content-center align-items-center vh-100">
  <div class="text-center">
    <h1 class="display-4 text-success">Access Denied</h1>
    <p class="lead">You do not have permission to access this resource.</p>
    <?php if (isset($_SESSION['user_id'])): ?>
        <?php if (!(isset($_SESSION['is_admin']) && $_SESSION['is_admin'])): ?>
            <p class="">Admin privileges are required to view this page.</p>
            <a href="#" class="btn btn-success mt-3" onclick="window.history.back">Go back</a>
        <?php endif ?>
    <?php else: ?>
      <p class="">Please login to gain access.</p>
      <a href="../login.php" class="btn btn-danger mt-3">Login</a>
    <?php endif ?>
  </div>
</section>

<?php include ('../includes/footer.php');