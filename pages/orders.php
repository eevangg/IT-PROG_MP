<?php include('../includes/header.php'); ?>

<section id="orders" class="container my-5 fullHeight">
  <h2>My Orders</h2>
  <?php
  // Sample orders (later from database)
  $orders = [
    ["id" => "10123", "item" => "Chicken Adobo", "price" => 75, "status" => "Preparing", "pickup" => "Recess (10:00 AM)"],
    ["id" => "10124", "item" => "Iced Tea", "price" => 25, "status" => "Ready for Pickup", "pickup" => "Lunch (12:00 NN)"]
  ];
  foreach ($orders as $order): ?>
    <div class="card order-card">
      <p><strong>Order #<?= $order['id'] ?></strong> — <?= $order['item'] ?> (₱<?= $order['price'] ?>)</p>
      <p>Status: 
        <span class="status <?= strtolower(str_replace(' ', '', $order['status'])) ?>">
          <?= $order['status'] ?>
        </span>
      </p>
      <p>Pickup: <?= $order['pickup'] ?></p>
    </div>
  <?php endforeach; ?>
</section>

<?php include('../includes/footer.php'); ?>
