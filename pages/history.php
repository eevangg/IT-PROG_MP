<?php
$pageTitle = "Order History - ArcherInnov Canteen Pre-order System";
include('../includes/header.php'); 
include('../config/db.php');

$userId = $_SESSION['user_id'];
$orders = [];

$orderSql = "SELECT o.order_id, o.order_date, o.total_amount, o.status, COALESCE(p.payment_status, 'pending') AS payment_status
             FROM orders o
             LEFT JOIN payments p ON p.order_id = o.order_id
             WHERE o.user_id = ?
             ORDER BY o.order_date DESC";
$stmt = $conn->prepare($orderSql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$orderResult = $stmt->get_result();

while ($row = $orderResult->fetch_assoc()) {
    $orders[] = $row;
}

$stmt->close();
?>

<section id="history" class="container my-5 fullHeight">
  <h2>Order History</h2>

  <?php if (empty($orders)): ?>
    <div class="alert alert-info mt-4" role="alert">
      You haven't placed any orders yet. Visit the <a href="menu.php" class="alert-link">menu</a> to get started.
    </div>
  <?php else: ?>
    <div class="table-responsive">
      <table class="table table-striped history-table align-middle">
        <thead class="table-success">
          <tr>
            <th scope="col">Date</th>
            <th scope="col">Items</th>
            <th scope="col">Total</th>
            <th scope="col">Order Status</th>
            <th scope="col">Payment Status</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($orders as $order): ?>
            <?php
              $itemsSql = "SELECT mi.item_name, od.quantity
                           FROM order_details od
                           JOIN menu_items mi ON mi.item_id = od.item_id
                           WHERE od.order_id = ?";
              $itemsStmt = $conn->prepare($itemsSql);
              $itemsStmt->bind_param("i", $order['order_id']);
              $itemsStmt->execute();
              $itemsResult = $itemsStmt->get_result();
              $itemDescriptions = [];

              while ($itemRow = $itemsResult->fetch_assoc()) {
                  $safeName = $itemRow['item_name'];
                  $itemDescriptions[] = "{$safeName} (x{$itemRow['quantity']})";
              }
              $itemsText = empty($itemDescriptions) ? 'No items recorded' : implode(', ', $itemDescriptions);
              $itemsStmt->close();
            ?>
            <tr>
              <td><?= date('M j, Y', strtotime($order['order_date'])) ?></td>
              <td><?= htmlspecialchars($itemsText) ?></td>
              <td>₱<?= number_format($order['total_amount'], 2) ?></td>
              <td><?= ucfirst(htmlspecialchars($order['status'])) ?></td>
              <td><?= ucfirst(htmlspecialchars($order['payment_status'])) ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  <?php endif; ?>
</section>

<?php $conn->close(); ?>
<?php include('../includes/footer.php'); ?>
