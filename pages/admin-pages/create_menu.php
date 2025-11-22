<?php
    session_start();
    $pageTitle = "Create Menu Item - ArcherInnov Canteen Pre-order System";
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
        <h1 class="text-center flex-grow-1 fw-bold text-success">Add New Menu Item</h1>
        <div></div>
    </div>

    <!-- Create Menu Item Form -->
    <div class="card shadow-sm w-100" style="max-width: 800px;">
        <div class="card-body">
            <form class="needs-validation" id="createMenuForm" method="POST" enctype="multipart/form-data" novalidate>
                <div class="mb-3">
                    <label for="item_name" class="form-label">Item Name</label>
                    <input type="text" class="form-control" id="item_name" name="item_name" required minlength="2">
                    <div class="invalid-feedback">Please enter the item name.</div>
                </div>
                <div class="mb-3">
                    <label for="category" class="form-label">Category</label>
                    <select class="form-select" id="category" name="category" required>
                        <option value="" disabled selected>Select Category</option>
                        <option value="Breakfast">Breakfast</option>
                        <option value="Lunch">Lunch</option>
                        <option value="Snack">Snack</option>
                        <option value="Beverage">Beverage</option>
                    </select>
                    <div class="invalid-feedback">Please select a category.</div>
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="3" minlength="15" required></textarea>
                    <div class="invalid-feedback">Please enter a description.</div>
                </div>
                <div class="mb-3">
                    <label for="price" class="form-label">Price (₱)</label>
                    <input type="number" step="0.01" class="form-control" id="price" name="price" required>
                    <div class="invalid-feedback">Please enter a valid price.</div>
                </div>
                <div class="mb-3">
                    <label for="stock" class="form-label">Stock Quantity</label>
                    <input type="number" class="form-control" id="stock" name="stock" min="1" required>
                    <div class="invalid-feedback">Please enter a valid stock quantity.</div>
                </div>
                <div class="mb-3">
                    <label for="image" class="form-label">Item Image</label>
                    <input type="file" class="form-control" id="image" name="image" accept="image/*" required>
                    <div class="invalid-feedback">Please upload an image for the item.</div>
                </div>
                <div class="text-end mt-4">
                    <button type="submit" class="btn btn-success px-4">
                        <i class="bi bi-plus-circle me-2"></i>Create Menu Item
                    </button>
                </div>
            </form>
        </div>
    </div>
</main>

<?php include('../../includes/closing.php'); ?>
