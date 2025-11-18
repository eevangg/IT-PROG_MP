<?php 
    include('../includes/header.php'); 
    
?>

<main class="container my-5 fullHeight">

    <div class="d-flex justify-content-between align-items-center w-100 mb-3">
        <h2 class="text-center flex-grow-1 fw-bold text-success">User Profile</h2>
    </div>

    <!-- Welcome Section -->
    <div class="profile-overview text-center mb-4 w-100">
        <p class="fw-semibold fs-5">Welcome, <?= htmlspecialchars($_SESSION['name'])?>!</p>
        <p class="text-muted">Here you can manage manage your profile.</p>
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
        <a href="change_password.php" class="btn btn-warning mx-2">Change Password</a>
        <a href="delete_account.php" class="btn btn-danger mx-2">Delete Account</a>
    </div>

</main>

<?php include('../includes/footer.php'); ?>