<?php
    session_start();
    $pageTitle = "Manage Top-ups - ArcherInnov Canteen";
    include('../../includes/sidebar.php'); 
    include ('../../config/db.php');

    // Handle Admin alerts
    if (isset($_SESSION['admin_msg'])) {
        $alertType = $_SESSION['admin_msg']['type'];
        $alertMsg = $_SESSION['admin_msg']['text'];
        echo "<div class='alert alert-$alertType alert-dismissible fade show m-3' role='alert'>
                $alertMsg
                <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
            </div>";
        unset($_SESSION['admin_msg']);
    }
?>

<main class="admin-content container my-5 fullHeight d-flex flex-column align-items-center justify-content-start">
    <div class="d-flex justify-content-between align-items-center w-100 mb-3">
        <div class="d-flex align-items-center gap-2">
            <a href="../dashboard.php" class="btn btn-outline-success btn-sm shadow-sm">
                <i class="bi bi-speedometer2 me-1"></i> Dashboard
            </a>
        </div>
        <h1 class="text-center flex-grow-1 fw-bold text-success">Manage Top-ups</h1>
        <button class="btn btn-outline-secondary" onclick="window.location.reload()">
            <i class="bi bi-arrow-clockwise me-1"></i> Refresh
        </button>
    </div>

    <?php
        // Make sure the top-up table exists to avoid fatal errors when the page is opened before any requests are made.
        $topupTableSql = "CREATE TABLE IF NOT EXISTS topup_requests (
            request_id INT NOT NULL AUTO_INCREMENT,
            user_id INT NOT NULL,
            amount DECIMAL(10,2) NOT NULL,
            status ENUM('pending', 'approved', 'rejected') DEFAULT 'pending',
            request_date DATETIME DEFAULT CURRENT_TIMESTAMP,
            approved_date DATETIME NULL,
            PRIMARY KEY (request_id),
            INDEX user_id (user_id ASC),
            CONSTRAINT topup_requests_ibfk_1
                FOREIGN KEY (user_id)
                REFERENCES users (user_id)
                ON DELETE CASCADE
                ON UPDATE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARACTER SET=utf8mb4 COLLATE=utf8mb4_general_ci";

        $tableError = null;
        if (!$conn->query($topupTableSql)) {
            $tableError = "Unable to load top-up requests right now. " . $conn->error;
            $pendingCount = 0;
            $pendingTotal = 0.00;
            $requests = [];
        }

        if (!$tableError) {
            // 1. Fetch Summary Data (Only Pending)
            $pendingData = $conn->query("SELECT COUNT(*) as count, SUM(amount) as total FROM topup_requests WHERE status = 'pending'")->fetch_assoc();
            $pendingCount = $pendingData['count'] ?? 0;
            $pendingTotal = $pendingData['total'] ?? 0;

            // 2. Fetch All Requests (Pending first, then by date)
            $sql = "SELECT r.*, u.username, u.full_name 
                    FROM topup_requests r 
                    JOIN users u ON r.user_id = u.user_id 
                    ORDER BY FIELD(r.status, 'pending', 'approved', 'rejected'), r.request_date DESC";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->get_result();
            $requests = [];
            while ($row = $result->fetch_assoc()) {
                $requests[] = $row;
            }
            $stmt->close();
        }
    ?>

    <div class="row g-3 mb-3 w-100">
        <div class="col-md-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-muted small">Pending Requests</div>
                            <div class="fs-3 fw-bold"><?= htmlspecialchars($pendingCount)?></div>
                        </div>
                        <i class="bi bi-hourglass-split fs-1 text-warning opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-muted small">Total Pending Amount</div>
                            <div class="fs-3 fw-bold">₱ <?= number_format($pendingTotal, 2)?></div>
                        </div>
                        <i class="bi bi-cash-coin fs-1 text-success opacity-75"></i>
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
                        <input type="text" id="topupFilter" class="form-control" placeholder="Search User, ID, Amount..." onkeyup="filterTable()">
                    </div>
                    <div class="form-text">Tip: Try searching for user name.</div>
                </div>
            </div>
        </div>
    </div>
    <br>

    <p class="text-muted text-center">Manage user wallet top-up requests. Approving a request will automatically add funds to the user's balance.</p>

    <?php if ($tableError): ?>
        <div class="alert alert-danger text-center w-100" role="alert">
            <?= htmlspecialchars($tableError) ?>
        </div>
    <?php endif; ?>

    <?php if(count($requests) > 0): ?>
    <div class="card shadow-sm w-100">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle" id="topupTable">
                    <thead class="table-success text-center">
                        <tr>
                            <th>Request ID</th>
                            <th>Customer Name</th>
                            <th>Request Date</th>
                            <th>Amount (₱)</th>
                            <th>Status</th>
                            <th>Processed Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($requests as $req): ?>
                        <tr class="text-center">
                            <td class="fw-semibold">#<?= $req['request_id'] ?></td>
                            <td>
                                <div class="fw-bold"><?= htmlspecialchars($req['full_name']) ?></div>
                                <small class="text-muted">@<?= htmlspecialchars($req['username']) ?></small>
                            </td>
                            <td><?= date('M d, Y h:i A', strtotime($req['request_date'])) ?></td>
                            <td class="fw-bold text-success">₱ <?= number_format($req['amount'], 2) ?></td>
                            
                            <td>
                                <span class="badge 
                                    <?php if($req['status'] === 'approved'):?>bg-success<?php endif; ?>
                                    <?php if($req['status'] === 'rejected'):?>bg-danger<?php endif; ?>
                                    <?php if($req['status'] === 'pending'):?>bg-secondary<?php endif; ?>
                                ">
                                    <?= ucfirst($req['status']) ?>
                                </span>
                            </td>

                            <td>
                                <?php 
                                    echo $req['approved_date'] ? date('M d, Y h:i A', strtotime($req['approved_date'])) : '-';
                                ?>
                            </td>

                            <td>
                                <?php if($req['status'] === 'pending'): ?>
                                    <form action="../../processes/admin-processes/process_topup_requests.php" method="POST" class="d-flex justify-content-center gap-2">
                                        <input type="hidden" name="request_id" value="<?= $req['request_id'] ?>">
                                        
                                        <button type="submit" name="action" value="approve" class="btn btn-sm btn-success" title="Approve" onclick="return confirm('Confirm adding ₱<?= $req['amount']?> to this user?');">
                                            <i class="bi bi-check-lg"></i> Approve
                                        </button>
                                        
                                        <button type="submit" name="action" value="reject" class="btn btn-sm btn-outline-danger" title="Reject" onclick="return confirm('Are you sure you want to reject this request?');">
                                            <i class="bi bi-x-lg"></i>
                                        </button>
                                    </form>
                                <?php else: ?>
                                    <span class="text-muted small fst-italic">Completed</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <?php else: ?>
        <div class="alert alert-secondary text-center w-100" role="alert">
            No top-up requests found.
        </div>
    <?php endif; ?>
    
    <?php $conn->close(); ?>
</main>

<script>
    // Simple Table Filter Script
    function filterTable() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("topupFilter");
        filter = input.value.toUpperCase();
        table = document.getElementById("topupTable");
        tr = table.getElementsByTagName("tr");

        for (i = 1; i < tr.length; i++) { // Start at 1 to skip header
            // Search in Name (index 1) and ID (index 0) and Amount (index 3)
            var tdId = tr[i].getElementsByTagName("td")[0];
            var tdName = tr[i].getElementsByTagName("td")[1];
            var tdAmount = tr[i].getElementsByTagName("td")[3];
            
            if (tdId || tdName || tdAmount) {
                var txtId = tdId.textContent || tdId.innerText;
                var txtName = tdName.textContent || tdName.innerText;
                var txtAmount = tdAmount.textContent || tdAmount.innerText;
                
                if (txtId.toUpperCase().indexOf(filter) > -1 || 
                    txtName.toUpperCase().indexOf(filter) > -1 || 
                    txtAmount.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }       
        }
    }
</script>

<?php include ('../../includes/closing.php'); ?>
