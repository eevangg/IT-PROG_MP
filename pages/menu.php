<?php include('../includes/header.php'); ?>

<section id="menu" class="container my-5 fullHeight"> 
  <h2>Today's Menu</h2>
  <div class="menu-grid">
    <?php
      include ("../config/db.php");
      
      $menuQuery = "SELECT * FROM menu_items WHERE stock > 0";
      $menuResult = $conn->query($menuQuery);
      $menu = [];
      while ($row = $menuResult->fetch_assoc()) {
          $menu[] = $row;
      }

     foreach ($menu as $item): ?> 
      <div class="row g-2">
          <div class="col-md-3">
            <div class="card d-flex flex-column h-100">
              <img src="" class="card-img-top" alt="">
              <div class="card-body d-flex flex-column">
                <h5 class="card-title"><?= $item['item_name'] ?></h5>
                <p class="card-subtitle mb-2 text-body-secondary"><?= $item['category']?></p>
                <h3 class="card-text mb-1">₱ <?= $item['price']?></h3>
                <p class="card-text mb-0"><?= $item['description']?></p>
                <p class="card-text">Available Stock: <?= $item['stock']?></p>
                <div class="mt-auto">
                    <a href="order.php?id=<?= $item['id'] ?>" class="btn btn-danger d-grid gap-2">Order</a>
                </div>
              </div>
            </div>
          </div>
      </div>
    <?php endforeach; ?>
    
  </div>
</section>

<?php include('../includes/footer.php'); ?>
