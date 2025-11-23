<?php
    session_start();
    $pageTitle = "Menu Management - ArcherInnov Canteen Pre-order System";
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
        <div><h1 class="text-center flex-grow-1 fw-bold text-success">Manage Menu</h1></div>
        <div>
            <a href="create_menu.php" class="btn btn-success">
                <i class="bi bi-plus-circle me-2"></i> Add Menu Item
            </a>
            <button class="btn btn-outline-secondary" onclick="window.location.reload()">
                <i class="bi bi-arrow-clockwise me-1"></i> Refresh
            </button>
        </div>
    </div>

    <?php
        include ('../../config/db.php');
        // Fetch summary data
        $menuCount = $conn->query("SELECT COUNT(*) as count FROM menu_items")->fetch_assoc()['count'];

        // Fetch menu items
        $sql = "SELECT * FROM menu_items ORDER BY item_name ASC";
        $result = $conn->query($sql);
        $menuItems = [];
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $menuItems[] = $row;
            }
        }
        $conn->close();
    ?>

    <!-- Summary Cards -->
    <div class="row g-3 mb-3 w-100">
        <div class="col-md-4">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                <div class="text-muted small">Total Menu Items</div>
                <div class="fs-3 fw-bold" id="menuCount"><?= htmlspecialchars($menuCount)?></div>
                </div>
                <i class="bi bi-list-ul fs-1 text-success opacity-75"></i>
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
                <input type="text" id="menuFilter" class="form-control" placeholder="Search item name, category...">
            </div>
            <div class="form-text">Tip: Try item name, category or price.</div>
            </div>
        </div>
        </div>
        <div class="col-md-4">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-body">
                <div class="text-muted small mb-1">Quick Links</div>
                <div class="d-flex gap-2 flex-wrap">
                    <a href="dashboard.php" class="btn btn-outline-success btn-sm"><i class="bi bi-speedometer2 me-1"></i>Dashboard</a>
                    <a href="manage_meal_plans.php" class="btn btn-outline-success btn-sm"><i class="bi bi-journal-bookmark me-1"></i>Manage Meal Plans</a>
                </div>
            </div>
        </div>
        </div>
    </div>
    <br>

    <p class="text-muted text-center">This section allows you to view and manage all Menu Items.</p>

    <!-- Menu Management Table -->
    <?php if(count($menuItems) > 0): ?>
    <div class="card shadow-sm w-100">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle">
                    <thead class="table-success text-center">
                        <tr>
                            <th>Item ID</th>
                            <th>Item Name</th>
                            <th>Category</th>
                            <th>Price (₱)</th>
                            <th>Available Stock</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="menuItemsTable">
                    <?php foreach ($menuItems as $menuItem): ?>
                        <tr id="menu-<?=$menuItem['item_id']?>" class="text-center">
                            <td class="fw-semibold"><?= htmlspecialchars($menuItem['item_id']) ?></td>
                            <td><?= htmlspecialchars($menuItem['item_name']) ?></td>
                            <td><?= htmlspecialchars($menuItem['category']) ?></td>
                            <td><?= number_format($menuItem['price'], 2) ?></td>
                            <td><?= htmlspecialchars($menuItem['stock']) ?></td>
                            <td>
                                <!-- Item Status Display mode -->
                                <div class="item-display" id="itemDisplay-<?=$menuItem['item_id']?>">
                                    <span class="badge item-badge
                                        <?php if($menuItem['status'] === 'active'):?>bg-success<?php endif; ?>
                                        <?php if($menuItem['status'] === 'inactive'):?> bg-secondary <?php endif; ?>
                                        ">
                                    <?=$menuItem['status']?>
                                    </span> <br>
                                    <button class="btn btn-sm btn-outline-success ms-1 editItemStatusBtn" data-id="<?=$menuItem['item_id']?>" data-type="itemStatus" title="Edit Item Status">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                </div>
                                
                                <!-- Item Status Edit mode -->
                                <div class="item-edit d-none" id="itemEdit-<?=$menuItem['item_id']?>">
                                    <select class="form-select form-select-sm d-inline-block w-auto me-2" id="itemStatusSelect-<?=$menuItem['item_id']?>">
                                        <option value="active" <?php if($menuItem['status'] === 'active'):?>selected<?php endif; ?>>Active</option>
                                        <option value="inactive" <?php if($menuItem['status'] === 'inactive'):?>selected<?php endif; ?>>Inactive</option>
                                    </select>
                                    <button class="btn btn-sm btn-success me-1 saveItemStatusBtn" data-id="<?=$menuItem['item_id']?>" data-type="itemStatus">
                                        <i class="bi bi-check2"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline-success cancelItemStatusBtn" data-id="<?=$menuItem['item_id']?>" data-type="itemStatus">
                                        <i class="bi bi-x-lg"></i>
                                    </button>
                                </div>
                            </td>
                            <td class="text-end">
                                <a href="edit_menu_item.php?id=<?=$menuItem['item_id']?>" class="btn btn-sm btn-outline-success me-1" data-id="<?=$menuItem['item_id']?>" title="Edit Item">
                                    <i class="bi bi-pencil-square"></i> Edit Item
                                </a>
                                <button class="btn btn-sm btn-outline-danger deleteItemBtn" data-id="<?=$menuItem['item_id']?>" data-action="delete_menu" title="Delete Menu Item">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <?php else: ?>
        <div class="alert alert-info text-center" role="alert">
            No menu items found. Please add new menu items.
        </div>
    <?php endif; ?>

</main>

<?php include('../../includes/closing.php'); ?>