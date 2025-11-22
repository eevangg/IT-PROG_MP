<?php
    session_start();
    $pageTitle = "Edit Menu Item - ArcherInnov Canteen Pre-order System";
    include('../../includes/sidebar.php'); 
?>

<main class="admin-content container my-5 fullHeight d-flex flex-column align-items-center justify-content-start">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center w-100 mb-3">
        <div class="d-flex align-items-center gap-2">
            <!-- Back to Manage Menu Button -->
            <a href="manage_menu.php" class="btn btn-outline-success btn-sm shadow-sm">
                <i class="bi bi-arrow-left me-1"></i> Back
            </a>
        </div>
        <h1 class="text-center flex-grow-1 fw-bold text-success">Edit Menu Item</h1>
        <div></div>
    </div>

    <!-- Edit Menu Item Form -->
    <div class="card shadow-sm w-100" style="max-width: 800px;">
        <div class="card-body">
            <?php
                include('../../config/db.php');
                if (isset($_GET['id'])) {
                    $itemId = intval($_GET['id']);
                    $stmt = $conn->prepare("SELECT * FROM menu_items WHERE item_id = ?");
                    $stmt->bind_param("i", $itemId);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    if ($result->num_rows > 0) {
                        $menuItem = $result->fetch_assoc();
                    } else {
                        echo "<div class='alert alert-danger'>Menu item not found.</div>";
                        exit();
                    }
                    $stmt->close();
                } else {
                    echo "<div class='alert alert-danger'>Invalid request.</div>";
                    exit();
                }
            ?>
            <form class="needs-validation" id="editMenuForm" method="POST" enctype="multipart/form-data" novalidate>
                <input type="hidden" name="item_id" value="<?php echo htmlspecialchars($menuItem['item_id']); ?>">
                <div class="mb-3">
                    <label for="item_name" class="form-label">Item Name</label>
                    <input type="text" class="form-control" id="item_name" name="item_name" value="<?php echo htmlspecialchars($menuItem['item_name']); ?>" required minlength="2">
                    <div class="invalid-feedback">Please enter the item name.</div>
                </div>
                <div class="mb-3">
                    <label for="category" class="form-label">Category</label>
                    <select class="form-select" id="category" name="category" required>
                        <option value="" disabled>Select Category</option>
                        <option value="Breakfast" <?php if ($menuItem['category'] === 'Breakfast') echo 'selected'; ?>>Breakfast</option>
                        <option value="Lunch" <?php if ($menuItem['category'] === 'Lunch') echo 'selected'; ?>>Lunch</option>
                        <option value="Snack" <?php if ($menuItem['category'] === 'Snack') echo 'selected'; ?>>Snack</option>
                        <option value="Beverage" <?php if ($menuItem['category'] === 'Beverage') echo 'selected'; ?>>Beverage</option>
                    </select>
                    <div class="invalid-feedback">Please select a category.</div>
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="3" minlength="15" required><?php echo htmlspecialchars($menuItem['description']); ?></textarea>
                    <div class="invalid-feedback">Please enter a description.</div>
                </div>
                <div class="mb-3">
                    <label for="price" class="form-label">Price (₱)</label>
                    <input type="number" step="0.01" class="form-control" id="price" name="price" value="<?php echo htmlspecialchars($menuItem['price']); ?>" required>
                    <div class="invalid-feedback">Please enter a valid price.</div>
                </div>
                <div class="mb-3">
                    <label for="stock" class="form-label">Stock Quantity</label>
                    <input type="number" class="form-control" id="stock" name="stock" value="<?php echo htmlspecialchars($menuItem['stock']); ?>" min="1" required>
                    <div class="invalid-feedback">Please enter a valid stock quantity.</div>
                </div>
                <div class="mb-3">
                    <label for="image" class="form-label">Item Image</label>
                    <input type="file" class="form-control" id="image" name="image" accept="image/*">
                    <div class="form-text">Leave blank to keep the current image.</div>
                    <div class="invalid-feedback">Please upload a valid image for the item.</div>
                </div>
                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-select" id="status" name="status" required>
                        <option value="active" <?php if ($menuItem['status'] === 'active') echo 'selected'; ?>>Active</option>
                        <option value="inactive" <?php if ($menuItem['status'] === 'inactive') echo 'selected'; ?>>Inactive</option>
                    </select>
                </div>
                <div class="text-end mt-4">
                    <button type="submit" class="btn btn-danger px-4">
                        <i class="bi bi-save me-2"></i> Update Item
                    </button>
                </div>
            </form>
        </div>
    </div>
</main>

<?php include('../../includes/closing.php'); ?>