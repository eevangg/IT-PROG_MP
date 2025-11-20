<?php
session_start();
$pageTitle = "Manage Orders - ArcherInnov Canteen Pre-order System";
include('../../includes/sidebar.php'); 
?>

<main class="admin-content container my-5 fullHeight d-flex flex-column align-items-center justify-content-start">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center w-100 mb-3">
        <div class="d-flex align-items-center gap-2">
        <!-- Back to Homepage Button -->
        <a href="../menu.php" class="btn btn-outline-success btn-sm shadow-sm">
            <i class="bi bi-house-door me-1"></i> Home
        </a>
        </div>
        <h1 class="text-center flex-grow-1 fw-bold text-success">Manage Orders</h1>
        <button class="btn btn-outline-secondary" onclick="window.location.reload()">
            <i class="bi bi-arrow-clockwise me-1"></i> Refresh
        </button>
    </div>
    <?php
    include ('../../config/db.php');
        // Fetch summary data
        $totalOrders = $conn->query("SELECT COUNT(*) as count FROM orders")->fetch_assoc()['count'];

        $sql = "SELECT * FROM orders ORDER BY order_date DESC";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        $orders = [];
        while ($row = $result->fetch_assoc()) {
            $orders[] = $row;
        }
        $stmt->close();
    ?>
    <!-- Summary Cards -->
    <div class="row g-3 mb-3 w-100">
        <div class="col-md-4">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                <div class="text-muted small">Total Orders</div>
                <div class="fs-3 fw-bold" id="orderCount"><?= htmlspecialchars($totalOrders)?></div>
                </div>
                <i class="bi bi-receipt-cutoff fs-1 text-success opacity-75"></i>
            </div>
            </div>
        </div>
        </div>
        <div class="col-md-4">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-body">
            <div class="text-muted small mb-1">Search</div>
            <div class="input-group">
                <span class="input-group-text bg-success text-white border-success">
                <i class="bi bi-search"></i>
                </span>
                <input type="text" id="orderFilter" class="form-control" placeholder="Search order id, plan id, date...">
            </div>
            <div class="form-text">Tip: Try order id or order date.</div>
            </div>
        </div>
        </div>
        <div class="col-md-4">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-body">
                <div class="text-muted small mb-1">Quick Links</div>
                <div class="d-flex gap-2 flex-wrap">
                    <a href="dashboard.php" class="btn btn-outline-success btn-sm"><i class="bi bi-speedometer2 me-1"></i>Dashboard</a>
                    <a href="manage_menu.php" class="btn btn-outline-success btn-sm"><i class="bi bi-list-ul me-1"></i>Manage Menu</a>
                </div>
            </div>
        </div>
        </div>
    </div>
    <br>

    <p class="text-muted text-center">This section allows you to view and manage all customer orders.</p>
    <!-- Table -->
    <?php if(count($orders) > 0): ?>
    <div class="card shadow-sm">
        <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover align-middle">
            <thead class="table-success text-center">
                <tr>
                <th>Order ID</th>
                <th>Customer Name</th>
                <th>Order Date</th>
                <th>Order Items</th>
                <th>Payment Method</th>
                <th>Payment Status</th>
                <th>Pickup Time</th>
                <th>Total Amount (₱)</th>
                <th>Status</th>
                <th>Actions</th>
                </tr>
            </thead>
            <tbody id="ordersTable">
            <?php foreach ($orders as $order): ?>
                <?php
                    // Fetch customer name
                    $customerId = $order['user_id'];
                    $customerSql = "SELECT full_name FROM users WHERE user_id = ?";
                    $customerStmt = $conn->prepare($customerSql);
                    $customerStmt->bind_param("i", $customerId);
                    $customerStmt->execute();
                    $customerResult = $customerStmt->get_result();
                    $customer = $customerResult->fetch_assoc();
                    $order['origin'] = $customer['full_name'];

                    // Determine order items
                    $itemsSql = "SELECT mi.item_name, od.quantity, mi.price 
                                FROM menu_items mi
                                JOIN order_details od ON mi.item_id = od.item_id
                                WHERE od.order_id = ?";

                    $itemsStmt = $conn->prepare($itemsSql);
                    $itemsStmt->bind_param("i", $order['order_id']);
                    $itemsStmt->execute();
                    $itemsResult = $itemsStmt->get_result();
                    $items = [];
                    while ($itemRow = $itemsResult->fetch_assoc()) {
                        $items[] = $itemRow['item_name'] . " (x" . $itemRow['quantity'] . ")" . " - ₱" . $itemRow['price'];
                    }

                    // Determine Payment Status
                    $paymentSql = "SELECT payment_status FROM payments WHERE order_id = ?";
                    $paymentStmt = $conn->prepare($paymentSql);
                    $paymentStmt->bind_param("i", $order['order_id']);
                    $paymentStmt->execute();
                    $paymentResult = $paymentStmt->get_result();
                    if ($paymentRow = $paymentResult->fetch_assoc()) {
                        $order['payment_status'] = $paymentRow['payment_status'];
                    } else {
                        $order['payment_status'] = 'pending';
                    }

                    $customerStmt->close();
                    $itemsStmt->close();
                    $paymentStmt->close();
                ?>

                <tr id="order-<?=$order['order_id']?>" class="text-center">
                    <td class="fw-semibold"><?=$order['order_id']?></td>
                    <td><?=$order['origin']?></td>
                    <td><?=$order['order_date']?></td>
                    <td>
                        <button class="btn btn-sm btn-outline-secondary ms-1 toggleItems" data-id="<?=$order['order_id']?>" title="View Order Items">
                            <i class="bi bi-caret-down"></i>
                        </button>
                    </td>
                    <td><?=$order['payment_method']?></td>
                    
                    <td>
                        <!-- Payment Status Display mode -->
                        <div class="payment-display" id="paymentDisplay-<?=$order['order_id']?>">
                            <span class="badge payment-badge
                                <?php if($order['payment_status'] === 'paid'):?>bg-success<?php endif; ?>
                                <?php if($order['payment_status'] === 'pending'):?> bg-warning text-dark<?php endif; ?>
                                <?php if($order['payment_status'] === 'failed'):?>bg-danger<?php endif; ?>
                                <?php if($order['payment_status'] === 'refunded'):?>bg-secondary<?php endif; ?>
                                ">
                            <?=$order['payment_status']?>
                            </span> <br>
                            <button class="btn btn-sm btn-outline-success ms-1 editPaymentBtn" data-id="<?=$order['order_id']?>"  data-type="payment" title="Edit Payment Status">
                                <i class="bi bi-pencil"></i>
                            </button>
                        </div>
                        <!-- Edit mode -->
                        <div class="payment-edit d-none" id="paymentEdit-<?=$order['order_id']?>">
                            <select class="form-select form-select-sm d-inline-block w-auto me-2" id="paymentSelect-<?=$order['order_id']?>">
                                <option value="paid" <?php if($order['payment_status'] === 'paid'):?>selected<?php endif; ?>>Paid</option>
                                <option value="failed" <?php if($order['payment_status'] === 'failed'):?>selected<?php endif; ?>>Failed</option>
                                <option value="pending" <?php if($order['payment_status'] === 'pending'):?>selected<?php endif; ?>>Pending</option>
                                <option value="refunded" <?php if($order['payment_status'] === 'refunded'):?>selected<?php endif; ?>>Refunded</option>
                            </select>
                            <button class="btn btn-sm btn-success me-1 savePaymentBtn" data-id="<?=$order['order_id']?>">
                                <i class="bi bi-check2"></i>
                            </button>
                            <button class="btn btn-sm btn-outline-success cancelPaymentBtn" data-id="<?=$order['order_id']?>" data-type="payment" >
                                <i class="bi bi-x-lg"></i>
                            </button>
                        </div>

                    </td>

                    <td><?=$order['pickup_time']?></td>
                    <td><?=number_format($order['total_amount'], 2)?></td>

                    <td>
                        <!-- Order Status Display mode -->
                        <div class="status-display" id="statusDisplay-<?=$order['order_id']?>"></div>
                            <span class="badge status-badge
                                <?php if($order['status'] === 'ready' || $order['status'] === 'completed'):?>bg-success<?php endif; ?>
                                <?php if($order['status'] === 'confirmed'):?> bg-warning text-dark<?php endif; ?>
                                <?php if($order['status'] === 'cancelled'):?>bg-danger<?php endif; ?>
                                <?php if($order['status'] === 'pending' || $order['status'] === 'preparing'):?>bg-secondary<?php endif; ?>
                                ">
                            <?=$order['status']?>
                            </span> <br>
                            <button class="btn btn-sm btn-outline-success ms-1 editStatusBtn" data-id="<?=$order['order_id']?>" data-type="status" title="Edit Status">
                                <i class="bi bi-pencil"></i>
                            </button>
                        </div>
                        <!-- Edit mode -->
                        <div class="status-edit d-none" id="statusEdit-<?=$order['order_id']?>">
                            <select class="form-select form-select-sm d-inline-block w-auto me-2" id="statusSelect-<?=$order['order_id']?>">
                                <option value="confirmed" <?php if($order['status'] === 'confirmed'):?>selected<?php endif; ?>>Confirmed</option>
                                <option value="cancelled" <?php if($order['status'] === 'cancelled'):?>selected<?php endif; ?>>Cancelled</option>
                                <option value="pending" <?php if($order['status'] === 'pending'):?>selected<?php endif; ?>>Pending</option>
                                <option value="preparing" <?php if($order['status'] === 'preparing'):?>selected<?php endif; ?>>Preparing</option>
                                <option value="ready" <?php if($order['status'] === 'ready'):?>selected<?php endif; ?>>Ready</option>
                                <option value="completed" <?php if($order['status'] === 'completed'):?>selected<?php endif; ?>>Completed</option>
                            </select>
                            <button class="btn btn-sm btn-success me-1 saveStatusBtn" data-id="<?=$order['order_id']?>">
                                <i class="bi bi-check2"></i>
                            </button>
                            <button class="btn btn-sm btn-outline-success cancelStatusBtn" data-id="<?=$order['order_id']?>" data-type="status" >
                                <i class="bi bi-x-lg"></i>
                            </button>
                        </div>

                    </td>
                    <td>
                        <button class="btn btn-sm btn-outline-danger deleteOrderBtn" data-id="<?=$order['order_id']?>" title="Delete Order">
                            <i class="bi bi-trash"></i>
                        </button>
                    </td>
                </tr>

                <!-- Expandable Order Items Row -->
                <tr class="items-row d-none" id="item-<?=$order['order_id']?>">
                <td colspan="9">
                    <div class="p-3 bg-light rounded border">
                    <div class="fw-semibold mb-2">Order Items</div>
                    <?php if(count($items) > 0):?>
                        <!--div class="row row-cols-1 row-cols-md-2 g-2"-->
                        <table class="table table-bordered">
                            <thead class="table-secondary">
                                <tr>
                                    <th>Item Name</th>
                                    <th>Quantity</th>
                                    <th>Unit Price</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php foreach($items as $item): ?>
                            <!--div class="col" -->
                                <tr>
                                    <?php
                                        // Extract item name and quantity and price
                                        preg_match('/^(.*?) \(x(\d+)\) - ₱([\d\.]+)$/', $item, $matches);
                                        $itemName = $matches[1];
                                        $quantity = $matches[2];
                                        $price = $matches[3];   
                                    ?>
                                    <td><?=htmlspecialchars($itemName)?></td>
                                    <td><?=htmlspecialchars($quantity)?></td>
                                    <td>₱<?=htmlspecialchars(number_format($price, 2))?></td>
                                </tr>
                                <!--/div-->
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                        <!--/div-->
                    <?php else: ?>
                        <div class="text-muted">No Item details available.</div>
                    <?php endif; ?>
                    </div>
                </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
            </table>
        </div>
        </div>
    </div>
    <?php else: ?>
        <div class="alert alert-secondary text-center" role="alert">
            No Orders found.
        </div>
    <?php endif; ?>
    </div>
    <?php $conn->close(); ?>
    
</main>

<!-- confirmation toast -->
<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
  <div id="toast" class="toast align-items-center text-white bg-danger border-0" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="d-flex">
      <div class="toast-body" id="toastBody"></div>
      <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
    </div>
  </div>
</div>

<!-- delete toast -->
<div aria-live="polite" aria-atomic="true" class="position-fixed top-50 start-50 translate-middle">
    <div id="deleteOrderToast" class="toast background-white" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-body">
            <form id="deleteOrderForm" method="post">
                <p>Are you sure you want to delete this order?</p>
                <p>This action cannot be undone!</p>

                <div id="delete_message"></div>
                <div class="mt-2 pt-2 border-top">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="toast">Close</button>
                    <button id="deleteToastBtn" type="submit" class="btn btn-danger btn-sm float-end">Confirm</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include ('../../includes/closing.php');