<?php
    session_start();
    $pageTitle = "Meal Plans - ArcherInnov Canteen Pre-order System";
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
        <div><h1 class="text-center flex-grow-1 fw-bold text-success">Meal Plans</h1></div>
        <div>
            <a href="create_meal_plan.php" class="btn btn-success">
                <i class="bi bi-plus-circle me-2"></i> Create Meal Plan
            </a>
            <button class="btn btn-outline-secondary" onclick="window.location.reload()">
                <i class="bi bi-arrow-clockwise me-1"></i> Refresh
            </button>
        </div>
    </div>

    <?php
        include ('../../config/db.php'); 

        // Fetch weekly meal plans
        $sql = "SELECT * FROM meal_plans WHERE week_start >= CURDATE() ORDER BY week_start ASC";
        $result = $conn->query($sql);
        $mealPlans = [];

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $mealPlans[] = $row;
            }
        }

        //  group meal plans by week_start
        $groupedMealPlans = [];
        foreach ($mealPlans as $plan) {
            $weekStart = $plan['week_start'];
            if (!isset($groupedMealPlans[$weekStart])) {
                $groupedMealPlans[$weekStart] = [];
            }
            $groupedMealPlans[$weekStart][] = $plan;
        }

        // fetch summary data
        $mealPlanCount = $conn->query("SELECT COUNT(*) as count FROM meal_plans WHERE week_start >= CURDATE()")->fetch_assoc()['count'];
    ?>

    <!-- Summary Cards -->
    <div class="row g-3 mb-3 w-100">
        <div class="col-md-4">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                <div class="text-muted small">Total Meal Plans</div>
                <div class="fs-3 fw-bold" id="mealPlanCount"><?= htmlspecialchars($mealPlanCount)?></div>
                </div>
                <i class="bi bi-journal-bookmark fs-1 text-success opacity-75"></i>
            </div>
            </div>
        </div>
        </div>
        <div class="col-md-4">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-body">
            <div class="text-muted small mb-1">Search</div>
            <div class="input-group">
                <span class="input-group-text bg-success text-white border-success">
                <i class="bi bi-search"></i>
                </span>
                <input type="text" id="planFilter" class="form-control" placeholder="Search meal plan...">
            </div>
            <div class="form-text">Tip: Try plan id, day of the week or week start.</div>
            </div>
        </div>
        </div>
        <div class="col-md-4">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-body">
                <div class="text-muted small mb-1">Quick Links</div>
                <div class="d-flex gap-2 flex-wrap">
                    <a href="dashboard.php" class="btn btn-outline-success btn-sm"><i class="bi bi-speedometer2 me-1"></i>Dashboard</a>
                    <a href="manage_users.php" class="btn btn-outline-success btn-sm"><i class="bi bi-people me-1"></i>Manage Users</a>
                </div>
            </div>
        </div>
        </div>
    </div>
    <br>

    <p class="text-muted text-center">This section allows you to view and manage Meal Plans.</p>

    <!-- Meal Plans Table -->


</main>

<?php include('../../includes/closing.php'); ?>