<?php 
$pageTitle = "Menu - ArcherInnov Canteen Pre-order System";
include('../includes/header.php'); 
?>

<section id="menu" class="container my-5 fullHeight"> 
  <?php if (!empty($_SESSION['cart_feedback'])): ?>
    <div class="alert alert-<?= $_SESSION['cart_feedback']['type'] ?> alert-dismissible fade show" role="alert">
      <?= htmlspecialchars($_SESSION['cart_feedback']['message']) ?>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php unset($_SESSION['cart_feedback']); ?>
  <?php endif; ?>

  <!-- Search Bar -->
  <div class="mb-4">
    <div class="input-group">
      <span class="input-group-text bg-success text-white border-success">
        <i class="bi bi-search"></i>
      </span>
      <input type="text" id="menuSearch" class="form-control" placeholder="Search by meal name...">
    </div>
  </div>

  <!-- Filter Controls -->
  <div class="row mb-4">
    <div class="col-md-6">
      <label for="categoryFilter" class="form-label"><strong>Filter by Category</strong></label>
      <select id="categoryFilter" class="form-select">
        <option value="">All Categories</option>
      </select>
    </div>
    <div class="col-md-6">
      <label for="priceFilter" class="form-label"><strong>Filter by Price Range</strong></label>
      <select id="priceFilter" class="form-select">
        <option value="">All Prices</option>
        <option value="0-100">₱0 - ₱100</option>
        <option value="100-200">₱100 - ₱200</option>
        <option value="200-300">₱200 - ₱300</option>
        <option value="300-9999">₱300+</option>
      </select>
    </div>
  </div>

  <h2>Today's Menu</h2>
  <br>
  <div class="menu-grid">
    <?php
      include ("../config/db.php");
      
      $menuQuery = "SELECT * FROM menu_items WHERE stock > 0 AND status = 'active' ORDER BY item_name ASC";
      $menuResult = $conn->query($menuQuery);
      $menu = [];
      $categories = [];
      while ($row = $menuResult->fetch_assoc()) {
          $menu[] = $row;
          if (!in_array($row['category'], $categories)) {
              $categories[] = $row['category'];
          }
      }

      echo '<div class="row g-2">';
     foreach ($menu as $item): ?> 
          <div class="col-md-3">
            <div class="card menu-cards d-flex flex-column h-100" data-name="<?= strtolower($item['item_name']) ?>" data-category="<?= $item['category'] ?>" data-price="<?= $item['price'] ?>">
              <img src="../assets/images/menu_items/<?= $item['image']?>" class="card-img-top" alt="">
              <div class="card-body d-flex flex-column">
                <h5 class="card-title"><?= $item['item_name'] ?></h5>
                <p class="card-subtitle mb-2 text-body-secondary"><?= $item['category']?></p>
                <h3 class="card-text mb-1">₱ <?= $item['price']?></h3>
                <p class="card-text mb-0"><?= $item['description']?></p>
                <br>
                <p class="card-text"><strong>Available Stock:</strong> <?= $item['stock']?></p>
                <div class="mt-auto">
                    <form action="../processes/process_menu.php" method="POST" class="d-grid gap-2">
                      <input type="hidden" name="action" value="add_to_cart">
                      <input type="hidden" name="item_id" value="<?= $item['item_id'] ?>">
                      <input type="hidden" name="redirect" value="../pages/menu.php">
                      <div class="input-group">
                        <span class="input-group-text">Qty</span>
                        <input type="number" name="quantity" class="form-control" min="1" max="<?= $item['stock'] ?>" value="1" required>
                      </div>
                      <button type="submit" class="btn btn-success">
                        <i class="bi bi-cart-plus"></i> Add to Cart
                      </button>
                    </form>
                </div>
              </div>
            </div>
          </div>
    <?php endforeach;  echo '</div>' ?>
    <?php $conn->close(); ?>
      
  </div>
</section>

<?php include('../includes/footer.php'); ?>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Populate category dropdown
    const categories = <?php echo json_encode($categories); ?>;
    const categorySelect = document.getElementById('categoryFilter');
    
    categories.forEach(category => {
        let option = document.createElement('option');
        option.value = category;
        option.textContent = category;
        categorySelect.appendChild(option);
    });
});
</script>
