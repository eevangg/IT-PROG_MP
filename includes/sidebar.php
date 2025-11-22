<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['username'])) {
    header("Location: ../pages/login.php");
    exit();
}

if (isset($_SESSION['username']) && !isset($_SESSION['is_admin'])) {
    header("Location: ../pages/error_pages/access_denied.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?php echo isset($pageTitle) ? htmlspecialchars($pageTitle) : 'Admin - School Canteen Pre-order System'; ?></title>
  
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet" />
  <link href="../../assets/css/admin.css" rel="stylesheet" type="text/css" media="all">

  <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
  <script src="../../assets/js/admin.js"></script>
  
</head>

<body>
  <div class="admin-wrapper d-flex">
    <!-- Sidebar -->
    <nav class="admin-sidebar d-flex flex-column justify-content-between p-3">
      <div>
        <h4 class="text-white mb-4 text-center fw-bold">Canteen Admin</h4>
        <ul class="nav flex-column">
          <li class="nav-item mb-2">
            <a href="dashboard.php" class="nav-link text-white <?php if ($pageTitle === 'Admin Dashboard - ArcherInnov Canteen Pre-order System'): ?> active<?php endif?>">
              <i class="bi bi-speedometer2 me-2"></i> Dashboard
            </a>
          </li>
          <li class="nav-item mb-2">
            <a href="manage_orders.php" class="nav-link text-white <?php if ($pageTitle === 'Manage Orders - ArcherInnov Canteen Pre-order System') : ?> active<?php endif?>">
              <i class="bi bi-receipt-cutoff me-2"></i> Manage Orders
            </a>
          </li>
          <li class="nav-item mb-2">
            <a href="manage_menu.php" class="nav-link text-white <?php if ($pageTitle === 'Menu Management - ArcherInnov Canteen Pre-order System'): ?> active<?php endif?>">
              <i class="bi bi-list-ul me-2"></i> Menu Management
            </a>
          </li>
          <li class="nav-item mb-2">
            <a href="manage_meal_plans.php" class="nav-link text-white<?php if ($pageTitle === 'Meal Plans - ArcherInnov Canteen Pre-order System'): ?> active<?php endif?>?>">
              <i class="bi bi-journal-bookmark me-2"></i> Meal Plans
            </a>
          </li>
            <li class="nav-item mb-2">
                <a href="manage_users.php" class="nav-link text-white <?php if ($pageTitle === 'User Management - ArcherInnov Canteen Pre-order System'): ?> active<?php endif?>">
                <i class="bi bi-people me-2"></i> User Management
                </a>
            </li>
            <li class="nav-item mb-2">
                <a href="#" class="nav-link text-white <?php if ($pageTitle === 'Reports - ArcherInnov Canteen Pre-order System'): ?> active<?php endif?>">
                <i class="bi bi-bar-chart-line me-2"></i> Reports
                </a>
            </li>
        </ul>
      </div>
      <div>
        <a href="../menu.php" class="btn btn-outline-light w-100 mt-3 logoutButton">
          <i class="bi bi-box-arrow-left me-2"></i> Back to Home
        </a>
      </div>
    </nav>
