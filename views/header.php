<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>School Canteen Pre-order System</title>

    <!-- CSS -->
    <link rel="stylesheet" href="style.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet"> <!-- Bootsrap icons -->

    <!-- JS -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
  </head>
  <body>
    <nav class="navbar navbar-expand-lg bg-success sticky-top">
      <div class="container-fluid">
        <div class="logo">
          <p class="navbar-brand text-white" href="/">ArcherInnov Canteen</p>
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
            <a href="index.php" class="nav-link text-white text-decoration-none mx-2">Profile</a>
          </div>

          <!-- Profile dropdown -->
          <div class="dropdown ms-3">
            <button class="btn btn-outline-light dropdown-toggle d-flex align-items-center" type="button" data-bs-toggle="dropdown" aria-expanded="false">
              <i class="bi bi-person-circle fs-5 me-1"></i>
              <span>Account</span>
            </button>

            <ul class="dropdown-menu dropdown-menu-end">
              <li><a class="dropdown-item" href="#">Sign In</a></li>
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item" href="#">Sign Up</a></li>
            </ul>
          </div>
        </div>
      </div>
    </nav>
