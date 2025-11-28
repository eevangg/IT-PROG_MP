<?php 
$pageTitle = "My Orders - ArcherInnov Canteen Pre-order System";
include('../includes/header.php'); 
?>

<section id="orders" class="container my-5 fullHeight">
  <h2>My Cart</h2>
  <?php if (!empty($_SESSION['cart_feedback'])): ?>
    <div class="alert alert-<?= $_SESSION['cart_feedback']['type'] ?> alert-dismissible fade show" role="alert">
      <?= htmlspecialchars($_SESSION['cart_feedback']['message']) ?>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php unset($_SESSION['cart_feedback']); ?>
  <?php endif; ?>

  <?php
    $cartItems = $_SESSION['cart'] ?? [];
    $cartTotal = 0;
    $accountBalance = isset($_SESSION['balance']) ? (float) $_SESSION['balance'] : 0;
  ?>

  <div class="card mb-4">
    <div class="card-body d-flex justify-content-between flex-wrap gap-2">
      <div>
        <h5 class="mb-1">Account Balance</h5>
        <p class="fs-4 mb-0"><strong>&#8369;<?= number_format($accountBalance, 2) ?></strong></p>
      </div>
      <div class="text-muted small align-self-center">
        Balance is based on your latest login. Deposits or deductions appear here once processed.
      </div>
    </div>
  </div>

  <?php if (empty($cartItems)): ?>
    <div class="alert alert-info mt-4" role="alert">
      Your cart is empty. Visit the <a href="menu.php" class="alert-link">menu</a> to add items.
    </div>
  <?php else: ?>
    <?php foreach ($cartItems as $item): ?>
      <?php $itemTotal = $item['price'] * $item['quantity']; $cartTotal += $itemTotal; ?>
      <div class="card order-card mb-3">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-start flex-wrap">
            <div>
              <h5 class="card-title mb-1"><?= htmlspecialchars($item['name']) ?></h5>
              <p class="mb-1 text-muted">Price: &#8369;<?= number_format($item['price'], 2) ?></p>
              <p class="mb-1">Subtotal: <strong>&#8369;<?= number_format($itemTotal, 2) ?></strong></p>
              <p class="mb-0 text-muted">Available stock: <?= (int) $item['stock'] ?></p>
            </div>
            <div class="d-flex flex-column gap-2 mt-3 mt-sm-0">
              <form action="../processes/process_menu.php" method="POST" class="d-flex align-items-center gap-2">
                <input type="hidden" name="action" value="update_quantity">
                <input type="hidden" name="item_id" value="<?= (int) $item['item_id'] ?>">
                <input type="hidden" name="redirect" value="../pages/orders.php">
                <label class="form-label mb-0 small">Qty</label>
                <input type="number" name="quantity" class="form-control" style="width: 90px;" min="0" max="<?= (int) $item['stock'] ?>" value="<?= (int) $item['quantity'] ?>">
                <button type="submit" class="btn btn-outline-success btn-sm">Update</button>
              </form>
              <form action="../processes/process_menu.php" method="POST">
                <input type="hidden" name="action" value="remove_item">
                <input type="hidden" name="item_id" value="<?= (int) $item['item_id'] ?>">
                <input type="hidden" name="redirect" value="../pages/orders.php">
                <button type="submit" class="btn btn-outline-danger btn-sm w-100">Remove</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    <?php endforeach; ?>

    <div class="card mt-4">
      <div class="card-body d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">
        <div>
          <h5 class="mb-1">Cart Total</h5>
          <p class="fs-4 mb-0"><strong>&#8369;<?= number_format($cartTotal, 2) ?></strong></p>
        </div>
        <div class="d-flex flex-column flex-md-row gap-2 mt-3 mt-md-0">
          <form action="../processes/process_menu.php" method="POST">
            <input type="hidden" name="action" value="clear_cart">
            <input type="hidden" name="redirect" value="../pages/orders.php">
            <button type="submit" class="btn btn-outline-secondary">Clear Cart</button>
          </form>
          <button class="btn btn-success" type="button" disabled>Proceed to Checkout</button>
        </div>
      </div>
    </div>
  <?php endif; ?>
</section>

<?php include('../includes/footer.php'); ?>
