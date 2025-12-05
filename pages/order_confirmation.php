<?php 
    $pageTitle = "Order Confirmation - ArcherInnov Canteen Pre-order System";
    include('../includes/initial.php');

    // Redirect if not logged in
    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php");
        exit();
    }

    include('../config/db.php');

    // Get order ID from URL
    $order_id = $_GET['order_id'] ?? null;
    if (!$order_id || !is_numeric($order_id)) {
        header("Location: orders.php");
        exit();
    }

    // Fetch order details
    $user_id = $_SESSION['user_id'];
    $sql = "SELECT o.*, u.full_name, u.email FROM orders o 
            JOIN users u ON o.user_id = u.user_id 
            WHERE o.order_id = ? AND o.user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $order_id, $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $order = $result->fetch_assoc();
    $stmt->close();

    if (!$order) {
        header("Location: orders.php");
        exit();
    }

    // Fetch order items
    $sql = "SELECT od.*, m.item_name FROM order_details od 
            JOIN menu_items m ON od.item_id = m.item_id 
            WHERE od.order_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    $items_result = $stmt->get_result();
    $order_items = $items_result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();

    $conn->close();

    // Format payment method
    $paymentLabels = [
        'wallet' => 'School Wallet',
        'qr' => 'QR Code',
        'cash' => 'Cash',
        'card' => 'Debit/Credit Card'
    ];
    $paymentMethod = $paymentLabels[$order['payment_method']] ?? $order['payment_method'];

    // Status badge colors
    $statusColors = [
        'pending' => 'warning',
        'confirmed' => 'info',
        'preparing' => 'info',
        'ready' => 'success',
        'completed' => 'success',
        'cancelled' => 'danger'
    ];
    $statusColor = $statusColors[$order['status']] ?? 'secondary';
?>

<main class="container my-5 fullHeight">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <!-- Success Message -->
            <div class="alert alert-success mb-4" role="alert">
                <div class="d-flex align-items-center">
                    <i class="bi bi-check-circle me-3" style="font-size: 2rem;"></i>
                    <div>
                        <h4 class="alert-heading mb-1">Order Placed Successfully!</h4>
                        <p class="mb-0">Thank you for your order. Your items will be ready for pickup at your scheduled time.</p>
                    </div>
                </div>
            </div>

            <!-- Order Details Card -->
            <div class="card mb-4">
                <div class="card-header bg-success text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Order #<?= str_pad($order['order_id'], 5, '0', STR_PAD_LEFT) ?></h5>
                        <span class="badge bg-<?= $statusColor ?>"><?= ucfirst($order['status']) ?></span>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 class="text-muted mb-2">Order Information</h6>
                            <p class="mb-1"><strong>Order Date:</strong> <?= date('M d, Y h:i A', strtotime($order['order_date'])) ?></p>
                            <p class="mb-1"><strong>Pickup Time:</strong> <?= date('h:i A', strtotime($order['pickup_time'])) ?></p>
                            <p class="mb-0"><strong>Payment Method:</strong> <?= $paymentMethod ?></p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted mb-2">Customer Information</h6>
                            <p class="mb-1"><strong>Name:</strong> <?= htmlspecialchars($order['full_name']) ?></p>
                            <p class="mb-1"><strong>Email:</strong> <?= htmlspecialchars($order['email']) ?></p>
                            <p class="mb-0"><strong>User ID:</strong> <?= (int) $order['user_id'] ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Items -->
            <div class="card mb-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Order Items</h5>
                </div>
                <div class="card-body">
                    <?php foreach ($order_items as $item): ?>
                        <div class="d-flex justify-content-between align-items-center mb-3 pb-3 border-bottom">
                            <div>
                                <h6 class="mb-1"><?= htmlspecialchars($item['item_name']) ?></h6>
                                <small class="text-muted"><?= (int) $item['quantity'] ?> x &#8369;<?= number_format($item['subtotal'] / $item['quantity'], 2) ?></small>
                            </div>
                            <strong>&#8369;<?= number_format($item['subtotal'], 2) ?></strong>
                        </div>
                    <?php endforeach; ?>
                    
                    <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top">
                        <h5 class="mb-0">Total Amount:</h5>
                        <h4 class="text-success mb-0">&#8369;<?= number_format($order['total_amount'], 2) ?></h4>
                    </div>
                </div>
            </div>

            <!-- Payment Status Section -->
            <div class="card mb-4">
                <div class="card-body">
                    <h6 class="mb-3 border-bottom pb-2">Payment Status</h6>
                    
                    <?php if ($order['payment_method'] === 'wallet'): ?>
                        <div class="alert alert-success mb-0">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-check-circle me-2"></i>
                                <div>
                                    <strong>Payment Confirmed</strong>
                                    <br>
                                    <small>Your wallet has been charged &#8369;<?= number_format($order['total_amount'], 2) ?></small>
                                </div>
                            </div>
                        </div>
                    <?php elseif ($order['payment_method'] === 'cash'): ?>
                        <div class="alert alert-warning mb-0">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-hourglass me-2"></i>
                                <div>
                                    <strong>Awaiting Payment Confirmation</strong>
                                    <br>
                                    <small>Admin will confirm cash payment at pickup. Amount: &#8369;<?= number_format($order['total_amount'], 2) ?></small>
                                </div>
                            </div>
                        </div>
                    <?php elseif ($order['payment_method'] === 'qr'): ?>
                        <div class="alert alert-warning mb-0">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-hourglass me-2"></i>
                                <div>
                                    <strong>Awaiting Payment Confirmation</strong>
                                    <br>
                                    <small>Admin will verify QR code payment. Amount: &#8369;<?= number_format($order['total_amount'], 2) ?></small>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Next Steps -->
            <div class="card mb-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0">What's Next?</h5>
                </div>
                <div class="card-body">
                    <?php if ($order['payment_method'] === 'wallet'): ?>
                        <div class="alert alert-info mb-3">
                            <i class="bi bi-info-circle me-2"></i>
                            <strong>Payment Confirmed!</strong> Your wallet has been charged &#8369;<?= number_format($order['total_amount'], 2) ?>. 
                            Your order is now pending confirmation.
                        </div>
                    <?php elseif ($order['payment_method'] === 'cash'): ?>
                        <div class="alert alert-warning mb-3">
                            <i class="bi bi-exclamation-circle me-2"></i>
                            <strong>Payment at Pickup:</strong> Please bring &#8369;<?= number_format($order['total_amount'], 2) ?> 
                            when picking up at <strong><?= date('h:i A', strtotime($order['pickup_time'])) ?></strong>.
                        </div>
                    <?php elseif ($order['payment_method'] === 'qr'): ?>
                        <div class="alert alert-info mb-3">
                            <i class="bi bi-qr-code me-2"></i>
                            <strong>QR Code Payment:</strong> Please scan the QR code to complete payment.
                        </div>
                    <?php endif; ?>
                    
                    <h6>Order Status:</h6>
                    <ol class="mb-0">
                        <li class="mb-2">Current status: <strong class="text-uppercase"><?= $order['status'] ?></strong></li>
                        <li class="mb-2">Staff will prepare your items</li>
                        <li class="mb-2">Pick up at <strong><?= date('h:i A', strtotime($order['pickup_time'])) ?></strong></li>
                        <li>Check "My Orders" for updates</li>
                    </ol>
                </div>
            </div>

            <!-- Actions -->
            <div class="d-flex gap-2 flex-wrap">
                <a href="menu.php" class="btn btn-outline-success flex-grow-1">Continue Shopping</a>
                <a href="history.php" class="btn btn-outline-success flex-grow-1">View My Orders</a>
                <a href="profile.php" class="btn btn-outline-success flex-grow-1">Account</a>
            </div>
        </div>
    </div>
</main>

<?php include('../includes/footer.php'); ?>
