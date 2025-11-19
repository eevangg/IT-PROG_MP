<?php 
session_start();
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    header("Location: ../pages/error_pages/access_denied.php");
    exit();
}
$pageTitle = "Admin Dashboard - ArcherInnov Canteen Pre-order System";
include('../includes/sidebar.php');
?>

<div class="container my-5 fullHeight d-flex flex-column align-items-center justify-content-start">

  <!-- Header -->
  <div class="d-flex justify-content-between align-items-center w-100 mb-3">
    <div class="d-flex align-items-center gap-2">
      <!-- Back to Homepage Button -->
      <a href="/" class="btn btn-outline-danger btn-sm shadow-sm">
        <i class="bi bi-house-door me-1"></i> Home
      </a>
    </div>
    <h1 class="text-center flex-grow-1 fw-bold text-danger">Admin Dashboard</h1>
    <a href="#" class="btn btn-outline-danger btn-sm shadow-sm logoutButton">Logout</a>
  </div>

  <!-- Welcome Section -->
  <div class="dashboard-overview text-center mb-4 w-100" style="max-width: 700px;">
    <p class="fw-semibold fs-5">Welcome, <?php echo $_SESSION['name']; ?>!</p>
    <p class="text-muted">Here you can manage users, view reports, and configure system settings.</p>
  </div>

</div>




<?php include('../includes/closing.php'); ?>