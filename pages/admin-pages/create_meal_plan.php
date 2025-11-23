<?php
    session_start();
    $pageTitle = "Create Meal Plan - ArcherInnov Canteen Pre-order System";
    include('../../includes/sidebar.php'); 
?>

<main class="admin-content container my-5 fullHeight d-flex flex-column align-items-center justify-content-start">
    
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center w-100 mb-3">
        <div class="d-flex align-items-center gap-2">
            <!-- Back to Manage Menu Button -->
            <a href="manage_meal_plans.php" class="btn btn-outline-success btn-sm shadow-sm">
                <i class="bi bi-arrow-left me-1"></i> Back
            </a>
        </div>
        <h1 class="text-center flex-grow-1 fw-bold text-success">Create Meal Plan</h1>
        <div></div>
    </div>

    <?php
        include ('../../config/db.php');

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
    <!-- Create Meal Plan Form -->
    <div class="card shadow-sm w-100" style="max-width: 800px;">
        <div class="card-body">
            <form class="needs-validation" id="createMealPlanForm" method="POST" novalidate>
                <div class="mb-3">
                    <label for="plan_name" class="form-label">Menu Item</label>
                    <select class="form-select" id="item_id" name="item_id" required>
                        <option value="" disabled selected>Select Menu Item</option>
                        <?php foreach ($menuItems as $item): ?>
                            <option value="<?= htmlspecialchars($item['item_id']) ?>"><?= htmlspecialchars($item['item_name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                    <div class="invalid-feedback">Please select a menu item.</div>
                </div>
                <div class="mb-3">
                    <label for="day_of_week" class="form-label">Day of The Week</label>
                    <select class="form-select" id="day_of_week" name="day_of_week" required>
                        <option value="" disabled selected>Select Day</option>
                        <option value="Monday">Monday</option>
                        <option value="Tuesday">Tuesday</option>
                        <option value="Wednesday">Wednesday</option>
                        <option value="Thursday">Thursday</option>
                        <option value="Friday">Friday</option>
                    </select>
                    <div class="invalid-feedback">Please select a day of the week</div>
                </div>
                <div class="mb-3">
                    <label for="week_start" class="form-label">Week Start</label>
                    <input type="date" class="form-control" id="week_start" name="week_start" required>
                    <div class="invalid-feedback">Please select the start date of the week.</div>
                </div>
                <div class="mb-3">
                    <label for="available_qty" class="form-label">Available Quantity</label>
                    <input type="number" class="form-control" id="available_qty" name="available_qty" min="1" required>
                    <div class="invalid-feedback">Please enter a valid available quantity.</div>
                </div>

                 <div class="text-end mt-4">
                    <button type="submit" class="btn btn-success px-4">
                        <i class="bi bi-plus-circle me-2"></i>Create Meal Plan
                    </button>
                </div>
            </form>
        </div>
    </div>

</main>

<?php include('../../includes/closing.php'); ?>
