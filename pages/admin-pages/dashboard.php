
<?php
session_start();
$pageTitle = "Admin Dashboard - ArcherInnov Canteen Pre-order System";
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
    <h1 class="text-center flex-grow-1 fw-bold text-success">Admin Dashboard</h1>
    <a href="../../processes/logout.php" class="btn btn-outline-success btn-sm shadow-sm logoutButton">Logout</a>
  </div>

  <!-- Welcome Section -->
  <div class="dashboard-overview text-center mb-4 w-100" style="max-width: 700px;">
    <p class="fw-semibold fs-5">Welcome, <?php echo $_SESSION['name']; ?>!</p>
    <p class="text-muted">Here you can manage users, view reports, and configure system settings.</p>
  </div>

  <?php
    include ('../../config/db.php');
    // Fetch summary data
    $totalOrders = $conn->query("SELECT COUNT(*) as count FROM orders")->fetch_assoc()['count'];
    $activeMenu = $conn->query("SELECT COUNT(*) as count FROM menu_items WHERE status = 'active'")->fetch_assoc()['count'];
    $totalUsers = $conn->query("SELECT COUNT(*) as count FROM users WHERE status = 'active'")->fetch_assoc()['count'];
    $payments = $conn->query("SELECT COUNT(*) as count FROM payments WHERE DATE(payment_date) = CURDATE()")->fetch_assoc()['count'];

    $conn->close();
  ?>

  <br>
  <h3 class="text-center fw-bold text-success">Overview</h3>
  <hr>
  <!-- Summary Cards -->
  <div class="row text-center justify-content-center w-100" style="max-width:900px;margin:0 auto;">
    <div class="col-md-6 mb-3">
      <div class="card stat-card shadow-sm border-0">
        <div class="card-body">
          <h5 class="card-title">Total Orders</h5>
          <h3 id="totalOrders"><?= htmlspecialchars($totalOrders)?></h3>
        </div>
      </div>
    </div>
    <div class="col-md-6 mb-3">
      <div class="card stat-card shadow-sm border-0">
        <div class="card-body">
          <h5 class="card-title">Active Menu</h5>
          <h3 id="activeMenu"><?= htmlspecialchars($activeMenu)?></h3>
        </div>
      </div>
    </div>
    <div class="col-md-6 mb-3">
      <div class="card stat-card shadow-sm border-0">
        <div class="card-body">
          <h5 class="card-title">Active Users</h5>
          <h3 id="totalUsers"><?= htmlspecialchars($totalUsers)?></h3>
        </div>
      </div>
    </div>
    <div class="col-md-6 mb-3">
      <div class="card stat-card shadow-sm border-0">
        <div class="card-body">
          <h5 class="card-title">Payments Today</h5>
          <h3 id="payments"><?= htmlspecialchars($payments)?></h3>
        </div>
      </div>
    </div>

     <!-- Dashboard Actions -->
     <div class="dashboard-actions mt-4 text-center">
      <h3 class="text-center fw-bold text-success">Quick Actions</h3>
      <br>
      <a href="manage_orders.php" class="btn btn-success mx-2">Manage Orders</a>
      <a href="manage_menu.php" class="btn btn-success mx-2">Manage Menu</a>
      <a href="manage_meal_plans.php" class="btn btn-success mx-2">Meal Plans</a>
      <a href="#" class="btn btn-success mx-2">User Management</a>
      <a href="#" class="btn btn-success mx-2">View Reports</a>
    </div>
  </div>


</main>




<?php include('../../includes/closing.php'); ?>