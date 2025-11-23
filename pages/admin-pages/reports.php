<?php
    session_start();
    $pageTitle = "User Management - ArcherInnov Canteen Pre-order System";
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
        <div><h1 class="text-center flex-grow-1 fw-bold text-success">Reports</h1></div>
        <div>
            <button class="btn btn-outline-secondary" onclick="window.location.reload()">
                <i class="bi bi-arrow-clockwise me-1"></i> Refresh
            </button>
        </div>
    </div>
</main>

<?php include('../../includes/closing.php'); ?>