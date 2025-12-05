<?php 
$pageTitle = "Payment Confirmations - Admin Dashboard";
include('../includes/header.php');

// Check if user is admin
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    header("Location: access_denied.php");
    exit();
}

include('../config/db.php');

// Get all pending payment confirmations
$sql = "SELECT o.order_id, o.total_amount, o.payment_method, o.order_date, o.pickup_time, o.status,
               u.full_name, u.user_id, COUNT(od.item_id) as item_count
        FROM orders o
        JOIN users u ON o.user_id = u.user_id
        LEFT JOIN order_details od ON o.order_id = od.order_id
        WHERE o.payment_method IN ('cash', 'qr') AND o.status = 'pending'
        GROUP BY o.order_id
        ORDER BY o.order_date DESC";
$result = $conn->query($sql);
$pending_payments = $result->fetch_all(MYSQLI_ASSOC);

$conn->close();
?>

<main class="container my-5">
    <h2 class="mb-4">Payment Confirmations</h2>

    <?php if (!empty($pending_payments)): ?>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th>Order ID</th>
                        <th>Customer</th>
                        <th>Amount</th>
                        <th>Payment Method</th>
                        <th>Items</th>
                        <th>Order Date</th>
                        <th>Pickup Time</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($pending_payments as $payment): ?>
                        <tr>
                            <td><strong>#<?= str_pad($payment['order_id'], 5, '0', STR_PAD_LEFT) ?></strong></td>
                            <td><?= htmlspecialchars($payment['full_name']) ?></td>
                            <td><strong class="text-success">&#8369;<?= number_format($payment['total_amount'], 2) ?></strong></td>
                            <td>
                                <span class="badge bg-info"><?= ucfirst($payment['payment_method']) ?></span>
                            </td>
                            <td><?= (int) $payment['item_count'] ?> item(s)</td>
                            <td><?= date('M d, Y h:i A', strtotime($payment['order_date'])) ?></td>
                            <td><?= date('h:i A', strtotime($payment['pickup_time'])) ?></td>
                            <td>
                                <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#confirmModal" 
                                        onclick="setOrderData(<?= $payment['order_id'] ?>, '<?= htmlspecialchars($payment['full_name']) ?>', <?= $payment['total_amount'] ?>, '<?= $payment['payment_method'] ?>')">
                                    <i class="bi bi-check-circle"></i> Confirm
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="alert alert-info">
            <i class="bi bi-info-circle me-2"></i>
            No pending payment confirmations at this time.
        </div>
    <?php endif; ?>
</main>

<!-- Confirmation Modal -->
<div class="modal fade" id="confirmModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirm Payment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="../processes/admin-processes/process_confirm_payment.php">
                <div class="modal-body">
                    <input type="hidden" id="orderId" name="order_id">
                    
                    <div class="mb-3">
                        <label class="form-label">Order ID</label>
                        <input type="text" class="form-control" id="displayOrderId" readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Customer</label>
                        <input type="text" class="form-control" id="customerName" readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Amount</label>
                        <input type="text" class="form-control" id="amount" readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Payment Method</label>
                        <input type="text" class="form-control" id="paymentMethod" readonly>
                    </div>

                    <div class="mb-3">
                        <label for="confirmStatus" class="form-label">Status</label>
                        <select class="form-select" id="confirmStatus" name="status" required>
                            <option value="confirmed">Confirm & Mark as Confirmed</option>
                            <option value="cancelled">Cancel Order</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="notes" class="form-label">Notes (Optional)</label>
                        <textarea class="form-control" id="notes" name="notes" rows="3" placeholder="Add any notes about this payment..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">Confirm Payment</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function setOrderData(orderId, customerName, amount, paymentMethod) {
    document.getElementById('orderId').value = orderId;
    document.getElementById('displayOrderId').value = '#' + String(orderId).padStart(5, '0');
    document.getElementById('customerName').value = customerName;
    document.getElementById('amount').value = '₱' + parseFloat(amount).toFixed(2);
    document.getElementById('paymentMethod').value = paymentMethod.charAt(0).toUpperCase() + paymentMethod.slice(1);
}
</script>

<?php include('../includes/footer.php'); ?>
