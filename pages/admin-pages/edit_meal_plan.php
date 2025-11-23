<?php
    session_start();
    $pageTitle = "Edit Meal Plan - ArcherInnov Canteen Pre-order System";
    include('../../includes/sidebar.php'); 
?>

<main class="admin-content container my-5 fullHeight d-flex flex-column align-items-center justify-content-start">
    <?php
        include('../../config/db.php');
        if (isset($_GET['id'])) {
            $planId = intval($_GET['id']);
            $stmt = $conn->prepare("SELECT * FROM meal_plans WHERE plan_id = ?");
            $stmt->bind_param("i", $planId);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                $mealPlan = $result->fetch_assoc();
            } else {
                echo "<div class='alert alert-danger'>Meal plan not found.</div>";
                exit();
            }
            $stmt->close();
        } else {
            echo "<div class='alert alert-danger'>Invalid request.</div>";
            exit();
        }

        // get menu item name
        $stmt = $conn->prepare("SELECT item_name FROM menu_items WHERE item_id = ?");
        $stmt->bind_param("i", $mealPlan['item_id']);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $item = $result->fetch_assoc();
            $item = $item['item_name'];
        } else {
            $item = "Unknown Item";
        }

        // get the menu items
        $sql = "SELECT item_id, item_name FROM menu_items WHERE status = 'active' ORDER BY item_name ASC";
        $result = $conn->query($sql);
        $menuItems = [];
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $menuItems[] = $row;
            }
        }
        $conn->close();
    ?>

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center w-100 mb-3">
        <div class="d-flex align-items-center gap-2">
            <!-- Back to Manage Menu Button -->
            <a href="manage_meal_plans.php" class="btn btn-outline-success btn-sm shadow-sm">
                <i class="bi bi-arrow-left me-1"></i> Back
            </a>
        </div>
        <h1 class="text-center flex-grow-1 fw-bold text-success">Edit <?php echo htmlspecialchars($item); ?></h1>
        <div></div>
    </div>

    <!-- Edit Meal Plan Form -->
    <div class="card shadow-sm w-100" style="max-width: 800px;">
        <div class="card-body">
            <form class="needs-validation" id="editMealPlanForm" method="POST" novalidate>
                <input type="hidden" name="plan_id" value="<?php echo htmlspecialchars($mealPlan['plan_id']); ?>">
                <div class="mb-3">
                    <label for="item_id" class="form-label">Menu Item</label>
                    <select class="form-select" id="item_id" name="item_id" required>
                        <option value="" disabled>Select Menu Item</option>
                        <?php foreach ($menuItems as $item): ?>
                            <option value="<?php echo htmlspecialchars($item['item_id']); ?>" <?php if ($mealPlan['item_id'] == $item['item_id']) echo 'selected'; ?>>
                                <?php echo htmlspecialchars($item['item_name']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <div class="invalid-feedback">Please select a menu item.</div>
                </div>
                <div class="mb-3">
                    <label for="day_of_week" class="form-label">Day of the Week</label>
                    <select class="form-select" id="day_of_week" name="day_of_week" required>
                        <option value="" disabled>Select Day</option>
                        <option value="Monday" <?php if ($mealPlan['day_of_week'] === 'Monday') echo 'selected'; ?>>Monday</option>
                        <option value="Tuesday" <?php if ($mealPlan['day_of_week'] === 'Tuesday') echo 'selected'; ?>>Tuesday</option>
                        <option value="Wednesday" <?php if ($mealPlan['day_of_week'] === 'Wednesday') echo 'selected'; ?>>Wednesday</option>
                        <option value="Thursday" <?php if ($mealPlan['day_of_week'] === 'Thursday') echo 'selected'; ?>>Thursday</option>
                        <option value="Friday" <?php if ($mealPlan['day_of_week'] === 'Friday') echo 'selected'; ?>>Friday</option>
                    </select>  
                    <div class="invalid-feedback">Please select a day of the week.</div>
                </div>
                <div class="mb-3">
                    <label for="week_start" class="form-label">Week Start</label>
                    <input type="date" class="form-control" id="week_start" name="week_start" value="<?php echo htmlspecialchars($mealPlan['week_start']); ?>" required>
                    <div class="invalid-feedback">Please select the week start date.</div>
                </div>
                <div class="mb-3">
                    <label for="available_qty" class="form-label">Available Quantity</label>
                    <input type="number" class="form-control" id="available_qty" name="available_qty" value="<?php echo htmlspecialchars($mealPlan['available_qty']); ?>" required min="1">
                    <div class="invalid-feedback">Please enter the available quantity (minimum 1).</div>
                </div>

                <div class="text-end mt-4">
                    <button type="submit" class="btn btn-danger px-4">
                        <i class="bi bi-save me-2"></i> Update Meal Plan
                    </button>
                </div>
            </form>
        </div>
    </div>

</main>

<?php include('../../includes/closing.php'); ?>
