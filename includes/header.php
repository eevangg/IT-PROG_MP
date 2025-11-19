<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

if (!isset($_SESSION['username'])) {
  header("Location: ../pages/login.php");
  exit();
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?php echo isset($pageTitle) ? htmlspecialchars($pageTitle) : 'School Canteen Pre-order System'; ?></title>

    <!-- CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet"> <!-- Bootsrap icons -->
    <link href="../assets/css/main.css" rel="stylesheet" /> <!-- Custom CSS -->

    <style>
      .dropdown-menu li a:hover {
        background-color: #198754;
        color: white;
      }
      .dropdown-menu li a:active {
        background-color: #145c32;
        color: white;
      }
    </style>
  </head>
  <body>
    <nav class="navbar navbar-expand-lg bg-success sticky-top">
      <div class="container-fluid">
        <div class="logo">
          <p class="navbar-brand" href="/">ArcherInnov Canteen</p>
        </div>

        <!-- Nav Bar toggler -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNavDropdown"></div>
          <!-- nav links -->
          <div class="navbar-nav">
            <a href="menu.php" class="nav-link text-white text-decoration-none mx-2">Menu</a>
            <a href="orders.php" class="nav-link text-white text-decoration-none mx-2">Cart</a>
            <a href="history.php" class="nav-link text-white text-decoration-none mx-2">History</a>
          </div>

          <!-- Profile dropdown -->
          <div class="dropdown ms-3">
            <button class="btn btn-outline-light dropdown-toggle d-flex align-items-center" type="button" data-bs-toggle="dropdown" aria-expanded="false">
              <i class="bi bi-person-circle fs-5 me-1"></i>
              <span>
                <?php echo isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : 'Account'; ?>
              </span>
            </button>

            <ul class="dropdown-menu dropdown-menu-end">
              <?php if (isset($_SESSION['username'])): ?>
                <li><a class="dropdown-item" href="profile.php">Profile</a></li>
                <li><a class="dropdown-item" href="../processes/logout.php">Logout</a></li>
                <?php if (isset($_SESSION['is_admin']) && $_SESSION['is_admin']): ?>
                  <li><hr class="dropdown-divider"></li>
                  <li><a class="dropdown-item" href="dashboard.php">Admin Dashboard</a></li>
                <?php endif; ?>
              <?php else: ?>
                <li><a class="dropdown-item" href="login.php">Sign In</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="register.php">Sign Up</a></li>
              <?php endif; ?>
            </ul>
          </div>
        </div>
      </div>
    </nav>
