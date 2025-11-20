<?php
session_start();
$pageTitle = "Manage Orders - ArcherInnov Canteen Pre-order System";
include('../includes/sidebar.php'); 
?>

<main class="admin-content container my-5 fullHeight d-flex flex-column align-items-center justify-content-start">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center w-100 mb-3">
        <div class="d-flex align-items-center gap-2">
        <!-- Back to Homepage Button -->
        <a href="menu.php" class="btn btn-outline-success btn-sm shadow-sm">
            <i class="bi bi-house-door me-1"></i> Home
        </a>
        </div>
        <h1 class="text-center flex-grow-1 fw-bold text-success">Manage Orders</h1>
        <button class="btn btn-outline-secondary" onclick="window.location.reload()">
            <i class="bi bi-arrow-clockwise me-1"></i> Refresh
        </button>
    </div>
    <?php
    include ('../config/db.php');
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

    ?>
    <!-- Summary Cards -->
    <div class="row g-3 mb-3 w-100">
        <div class="col-md-4">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                <div class="text-muted small">Total Orders</div>
                <div class="fs-3 fw-bold"><?= htmlspecialchars($totalOrders)?></div>
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
                <input type="text" id="flightFilter" class="form-control" placeholder="Search order id, plan id, date...">
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
                <a href="/admin" class="btn btn-outline-success btn-sm"><i class="bi bi-speedometer2 me-1"></i>Dashboard</a>
                <a href="/admin/reservations" class="btn btn-outline-success btn-sm"><i class="bi bi-journal-bookmark me-1"></i>Reservations</a>
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
            <thead class="table-danger text-center">
                <tr>
                <th>Order ID</th>
                <th>Customer Name</th>
                <th>Order Date</th>
                <th>Order Items</th>
                <th>Payment Method</th>
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
                $itemsSql = "SELECT item_name, quantity 
                             FROM menu_items mi
                             JOIN order_details od ON mi.item_id = od.item_id
                             JOIN orders o ON od.order_id = o.order_id
                             WHERE o.order_id = ?";

                $itemsStmt = $conn->prepare($itemsSql);
                $itemsStmt->bind_param("i", $order['order_id']);
                $itemsStmt->execute();
                $itemsResult = $itemsStmt->get_result();
                $items = [];
                while ($itemRow = $itemsResult->fetch_assoc()) {
                    $items[] = $itemRow['item_name'] . " (x" . $itemRow['quantity'] . ")";
                }
                ?>
                <tr id="order-<?=$order['order_id']?>" class="text-center">
                <td class="fw-semibold"><?=$order['order_id']?></td>
                <td><?=$order['origin']?></td>
                <td><?=$order['order_date']?></td>
                <td>
                    <button class="btn btn-sm btn-outline-secondary ms-1 toggleRoute" data-id="<?=$order['order_id']?>" title="View Order Items">
                        <i class="bi bi-caret-down"></i>
                    </button>
                </td>
                <td><?=$order['payment_method']?></td>
                <td><?=$order['pickup_time']?></td>
                <td><?=$order['total_amount']?></td>
                <td>
                    <span class="badge
                        <?php if($order['status'] === 'ready' || $order['status'] === 'completed'):?>bg-success<?php endif; ?>
                        <?php if($order['status'] === 'confirmed'):?> bg-warning text-dark<?php endif; ?>
                        <?php if($order['status'] === 'cancelled'):?>bg-danger<?php endif; ?>
                        <?php if($order['status'] === 'pending' || $order['status'] === 'preparing'):?>bg-secondary<?php endif; ?>
                        ">
                    <?=$order['status']?>
                    </span>
                </td>
                <td>
                    <a href="#" class="btn btn-sm btn-outline-primary me-1" title="Edit">
                    <i class="bi bi-pencil"></i>
                    </a>
                    <button class="btn btn-sm btn-outline-danger deleteFlightBtn" data-id="<?=$order['order_id']?>" title="Delete">
                    <i class="bi bi-trash"></i>
                    </button>
                </td>
                </tr>

                <!-- Expandable Order Items Row -->
                <tr class="items-row d-none" id="items-<?=$order['order_id']?>">
                <td colspan="9">
                    <div class="p-3 bg-light rounded border">
                    <div class="fw-semibold mb-2">Order Items</div>
                    <?php if(count($items) > 0):?>
                        <div class="row row-cols-1 row-cols-md-2 g-2">
                        <?php foreach($items as $item): ?>
                            <div class="col">
                            <div class="p-2 bg-white rounded border">
                                <div><strong>Flight Number:</strong> {{this.flightNumber}}</div>
                                <div><strong>Route:</strong> {{this.origin}} → {{this.destination}}</div>
                                <div><strong>Aircraft:</strong> {{this.aircraft}}</div>
                                <div><strong>Depart:</strong> {{this.departureDate}}</div>
                            </div>
                            </div>
                        <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div class="text-muted">No Routes details available.</div>
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
        
    
</main>


<?php include ('../includes/closing.php');