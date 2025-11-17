<?php include('../includes/header.php'); ?>

<section id="menu" class="container my-5 fullHeight"> 
  <h2>Today's Menu</h2>
  <div class="menu-grid">
    <?php
    // Placeholder menu array – later can come from DB
    $menu = [
      ["name" => "Chicken Adobo", "price" => 75, "category" => "Main", "stock" => 15, "image" => "assets/images/rice-meal.jpg"],
      ["name" => "Ham Sandwich", "price" => 40, "category" => "Snack", "stock" => 30, "image" => "assets/images/sandwich.jpg"],
      ["name" => "Iced Tea", "price" => 25, "category" => "Beverage", "stock" => 50, "image" => "assets/images/icedtea.jpg"]
    ];

    foreach ($menu as $item): ?>
      <div class="menu-item">
        <img src="<?= $item['image'] ?>" alt="<?= $item['name'] ?>">
        <h3><?= $item['name'] ?></h3>
        <p>₱<?= $item['price'] ?> | <span class="tag"><?= $item['category'] ?></span></p>
        <p class="stock">Available: <?= $item['stock'] ?></p>
        <button class="btn">Pre-order</button>
      </div>
    <?php endforeach; ?>
  </div>
</section>

<?php include('../includes/footer.php'); ?>
