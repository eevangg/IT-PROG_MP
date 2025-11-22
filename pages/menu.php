<?php 
$pageTitle = "Menu - ArcherInnov Canteen Pre-order System";
include('../includes/header.php'); 
?>

<section id="menu" class="container my-5 fullHeight"> 

  <div class="d-flex justify-content-between align-items-center flex-wrap mb-3">
      <div class="input-group">
        <span class="input-group-text bg-success text-white border-success">
          <i class="bi bi-search"></i>
        </span>
        <input type="text" id="menuFilter" class="form-control" placeholder="Search by Meal, Price, Category, Description...">
      </div>
  </div>

    <br>
  <h2>Today's Menu</h2>
  <br>
  <div class="menu-grid">
    <?php
      include ("../config/db.php");
      
      $menuQuery = "SELECT * FROM menu_items WHERE stock > 0";
      $menuResult = $conn->query($menuQuery);
      $menu = [];
      while ($row = $menuResult->fetch_assoc()) {
          $menu[] = $row;
      }

      echo '<div class="row g-2">';
     foreach ($menu as $item): ?> 
          <div class="col-md-3">
            <div class="card menu-cards d-flex flex-column h-100">
              <img src="../assets/images/menu_items/<?= $item['image']?>" class="card-img-top" alt="">
              <div class="card-body d-flex flex-column">
                <h5 class="card-title"><?= $item['item_name'] ?></h5>
                <p class="card-subtitle mb-2 text-body-secondary"><?= $item['category']?></p>
                <h3 class="card-text mb-1">₱ <?= $item['price']?></h3>
                <p class="card-text mb-0"><?= $item['description']?></p>
                <br>
                <p class="card-text"><strong>Available Stock:</strong> <?= $item['stock']?></p>
                <div class="mt-auto">
                    <a href="order.php?id=<?= $item['id'] ?>" class="btn btn-success d-grid gap-2"><i class="bi bi-cart-plus"> add to cart</i></a>
                </div>
              </div>
            </div>
          </div>
    <?php endforeach;  echo '</div>' ?>
    <?php $conn->close(); ?>

  </div>
</section>

<?php include('../includes/footer.php'); ?>
