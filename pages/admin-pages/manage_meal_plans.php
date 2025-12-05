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
                <input type="text" id="planFilter" class="form-control" placeholder="Search meal plan..." data-table="mealPlansTable">
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
                    <?php if (isset($_SESSION['is_admin'])) : ?>
                        <a href="manage_users.php" class="btn btn-outline-success btn-sm"><i class="bi bi-people me-1"></i>Manage Users</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        </div>
    </div>
    <br>

    <p class="text-muted text-center">This section allows you to view and manage Meal Plans.</p>

    <!-- Meal Plans Table -->
    <?php if(count($groupedMealPlans) > 0): ?>
        <div class="card shadow-sm w-100">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover align-middle">
                        <thead class="table-success text-center">
                            <tr>
                                <th>Plan ID</th>
                                <th>Item Name</th>
                                <th>Day of the Week</th>
                                <th>Available Stock</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="mealPlansTable">
                            <!-- display meal plans grouped by week_start -->
                            <?php foreach ($groupedMealPlans as $weekStart => $plans): ?>
                                    <tr span="7" class="table-secondary">
                                        <td colspan="7" class="fw-bold text-center">Week Starting: <?= htmlspecialchars(date('F j, Y', strtotime($weekStart))) ?></td>
                                    </tr>

                                <!-- display meal plans for the week -->
                                <?php foreach ($plans as $plan): ?>
                                    <?php
                                        // retrieve item names for each meal plan
                                        $sql = "SELECT item_name FROM menu_items WHERE item_id = ?";
                                        $stmt = $conn->prepare($sql);
                                        $stmt->bind_param("i", $plan['item_id']);
                                        $stmt->execute();
                                        $itemResult = $stmt->get_result();
                                        $item = $itemResult->fetch_assoc();
                                        $item = $item ? $item['item_name'] : 'Unknown Item';

                                    ?>
                                    <tr id="plan-<?=$plan['plan_id']?>" class="text-center">
                                        <td class="fw-semibold"><?= htmlspecialchars($plan['plan_id']) ?></td>
                                        <td><?= htmlspecialchars($item) ?></td>
                                        <td><?= htmlspecialchars($plan['day_of_week']) ?></td>
                                        <td><?= htmlspecialchars($plan['available_qty']) ?></td>

                                        <td>
                                            <!-- Item Status Display mode -->
                                            <div class="plan-display" id="planDisplay-<?=$plan['plan_id']?>">
                                                <span class="badge plan-badge
                                                    <?php if($plan['status'] === 'available'):?>bg-success<?php endif; ?>
                                                    <?php if($plan['status'] === 'unavailable'):?> bg-secondary <?php endif; ?>
                                                    ">
                                                <?=$plan['status']?>
                                                </span> <br>
                                                <button class="btn btn-sm btn-outline-success ms-1 editPlanStatusBtn" data-id="<?=$plan['plan_id']?>" data-type="planStatus" title="Edit Plan Status">
                                                    <i class="bi bi-pencil"></i>
                                                </button>
                                            </div>
                                            
                                            <!-- Item Status Edit mode -->
                                            <div class="plan-edit d-none" id="planEdit-<?=$plan['plan_id']?>">
                                                <select class="form-select form-select-sm d-inline-block w-auto me-2" id="planStatusSelect-<?=$plan['plan_id']?>">
                                                    <option value="available" <?php if($plan['status'] === 'available'):?>selected<?php endif; ?>>Available</option>
                                                    <option value="unavailable" <?php if($plan['status'] === 'unavailable'):?>selected<?php endif; ?>>Unavailable</option>
                                                </select>
                                                <button class="btn btn-sm btn-success me-1 savePlanStatusBtn" data-id="<?=$plan['plan_id']?>" data-type="planStatus">
                                                    <i class="bi bi-check2"></i>
                                                </button>
                                                <button class="btn btn-sm btn-outline-success cancelPlanStatusBtn" data-id="<?=$plan['plan_id']?>" data-type="planStatus">
                                                    <i class="bi bi-x-lg"></i>
                                                </button>
                                            </div>
                                        </td>
                                        <td class="text-end">
                                            <a href="edit_meal_plan.php?id=<?= $plan['plan_id'] ?>" class="btn btn-sm btn-outline-success me-1" data-id="<?=$plan['plan_id']?>">
                                                <i class="bi bi-pencil-square"></i> Edit
                                            </a>
                                            <button class="btn btn-sm btn-outline-danger deletePlanBtn" data-id="<?=$plan['plan_id']?>" data-action="delete_plan" title="Delete Meal Plan">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            
                            <?php endforeach; ?>
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="alert alert-info text-center" role="alert">
            No upcoming meal plans found. <a href="create_meal_plan.php" class="alert-link">Create a new meal plan</a>.
        </div>
    <?php endif; ?>
    <?php $conn->close(); ?>

</main>

<?php include('../../includes/closing.php'); ?>