<?php
    session_start();
    $pageTitle = "Reports - ArcherInnov Canteen Pre-order System";
    include('../../includes/sidebar.php'); 

    include('../../config/db.php');
    /* ---------- AJAX HANDLER ---------- */
    if (isset($_POST['ajax']) && $_POST['ajax'] === '1') {

        $reportType = $_POST['reportType'];
        $month = $_POST['month'];
        $year  = $_POST['year'];

        ob_start();  // capture HTML output

        /* ---------------- SALES REPORT ---------------- */
        if ($reportType === 'sales-report') {

            $sql = "SELECT o.order_date AS order_date, m.item_name AS meal, m.category AS category,
                        SUM(od.quantity) AS total_quantity,
                        SUM(od.quantity * m.price) AS total_price
                    FROM orders o
                    JOIN order_details od ON o.order_id = od.order_id
                    JOIN menu_items m ON od.item_id = m.item_id
                    WHERE o.status = 'completed'
                    AND MONTH(o.order_date) = ?
                    AND YEAR(o.order_date) = ?
                    GROUP BY m.item_name, o.order_date
                    ORDER BY o.order_date DESC";

            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ii", $month, $year);
            $stmt->execute();
            $result = $stmt->get_result();
        ?>

            <!-- Output HTML table -->
            <div class="card shadow-sm w-100 mb-4">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover align-middle">
                            <thead class="table-success text-center">
                            <tr>
                                <th>Date</th>
                                <th>Meal</th>
                                <th>Category</th>
                                <th>Qty</th>
                                <th>Total (₱)</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php while ($row = $result->fetch_assoc()): ?>
                                <tr class="text-center">
                                    <td><?= date('Y-m-d', strtotime($row['order_date'])) ?></td>
                                    <td><?= $row['meal'] ?></td>
                                    <td><?= $row['category'] ?></td>
                                    <td><?= $row['total_quantity'] ?></td>
                                    <td>₱<?= number_format($row['total_price'], 2) ?></td>
                                </tr>
                            <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        <?php
        }

        /* ---------------- ORDER TRENDS report ---------------- */
        if ($reportType === 'order-trends') {

            $sql = "SELECT 
                    m.item_name,
                    COUNT(o.order_id) AS total_orders,
                    SUM(o.total_amount) AS total_revenue
                FROM orders o
                JOIN order_details od ON o.order_id = od.order_id
                JOIN menu_items m ON od.item_id = m.item_id
                WHERE o.status = 'completed'
                AND MONTH(o.order_date) = ?
                AND YEAR(o.order_date) = ?
                GROUP BY m.item_name
                ORDER BY total_orders DESC, total_revenue DESC";

            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ii", $month, $year);
            $stmt->execute();
            $result = $stmt->get_result();
        ?>

            <div class="card shadow-sm w-100 mb-4">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover align-middle">
                            <thead class="table-success text-center">
                                <tr>
                                    <th>Meal</th>
                                    <th>Total Orders</th>
                                    <th>Total Revenue</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php while ($row = $result->fetch_assoc()): ?>
                                <tr class="text-center">
                                    <td><?= $row['item_name'] ?></td>
                                    <td><?= $row['total_orders'] ?></td>
                                    <td>₱<?= number_format($row['total_revenue'], 2) ?></td>
                                </tr>
                            <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        <?php
        }

        /* ---------------- INVENTORY REPORT ---------------- */
        if ($reportType === 'inventory-report') {

            $sql = "SELECT *
                    FROM inventory_logs i
                    JOIN menu_items m ON i.item_id = m.item_id
                    WHERE MONTH(i.log_date) = ?
                    AND YEAR(i.log_date) = ?
                    ORDER BY i.log_date DESC";

            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ii", $month, $year);
            $stmt->execute();
            $result = $stmt->get_result();
        ?>

            <div class="card shadow-sm w-100">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover align-middle">
                            <thead class="table-success text-center">
                                <tr>
                                    <th>Date</th>
                                    <th>Item</th>
                                    <th>Change Type</th>
                                    <th>Qty Changed</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php while ($row = $result->fetch_assoc()): ?>
                                <tr class="text-center">
                                    <td><?= date('Y-m-d', strtotime($row['log_date'])) ?></td>
                                    <td><?= $row['item_name'] ?></td>
                                    <td><?= $row['change_type'] ?></td>
                                    <td><?= $row['quantity_changed'] ?></td>
                                </tr>
                            <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        <?php
        }

        // SEND THE GENERATED HTML BACK TO JS
        $html = ob_get_clean();
        echo $html;
        exit;
    }

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
        <div><h1 class="text-center flex-grow-1 fw-bold text-success">Reports</h1></div>
        <div>
            <button class="btn btn-outline-secondary" onclick="window.location.reload()">
                <i class="bi bi-arrow-clockwise me-1"></i> Refresh
            </button>
        </div>
    </div>
    <br>

    <div class="card shadow-sm border-0 w-100 h-30">
        <br>
        <p class="text-center">Select Month and Year of reports to display</p>
        <form method="POST" id="report_form">
            <input type="hidden" name="reportType" id="reportType">
            <div class="row mb-6 report-range mt-4 d-flex justify-content-center">
                <div class="col-md-4">         
                    <select id="month" class="form-select" name="month" required>
                        <option value="" disabled selected>Select Month</option>
                        <option value="1">January</option>
                        <option value="2">February</option>
                        <option value="3">March</option>
                        <option value="4">April</option>
                        <option value="5">May</option>
                        <option value="6">June</option>
                        <option value="7">July</option>
                        <option value="8">August</option>
                        <option value="9">September</option>
                        <option value="10">October</option>
                        <option value="11">November</option>
                        <option value="12">December</option>
                    </select>          
                </div>
                <div class="col-md-4">        
                    <select id="year" name="year" class="form-control" required>
                        <option value="" disabled selected>Select Year</option>
                        <?php
                            $currentYear = date("Y");
                            for ($y = $currentYear; $y >= 2015; $y--) {
                                echo "<option value='$y'>$y</option>";
                            }
                        ?>
                    </select>
                </div>        
            </div>

            <div class="reports mt-4 text-center">
                <button type="button" id="sales-report" class="btn btn-success">
                    <i class="bi bi-pie-chart-fill"></i> View Sales Report 
                        </button>
                <button type="button" id="order-trends" class="btn btn-success">
                    <i class="bi bi-graph-up"></i> View Order Trends
                </button>
                <button type="button" id="inventory-report" class="btn btn-success">
                    <i class="bi bi-file-earmark-text"></i> View Inventory Report
                </button>
            </div>
            <div id="formInfo"></div>
            <br>
        </form>
    </div> 
    <br>
    
 
    <div class="reports-display w-100">
        
    </div>
</main>

<script>
    const reportArea = document.querySelector(".reports-display");
    const reportTypeInput = document.getElementById("reportType");

    // attach click handlers
    ["sales-report","order-trends","inventory-report"].forEach(id => {
        document.getElementById(id).addEventListener("click", () => {
            reportTypeInput.value = id;
            submitReport();
        });
    });

    // AJAX function
    async function submitReport() {
        const form = document.getElementById('report_form');
        const formData = new FormData(form);
        formData.append("ajax", "1");

        const response = await fetch("", {
            method: "POST",
            body: formData
        });

        const html = await response.text();

        reportArea.innerHTML = "";      // clear old report
        reportArea.innerHTML = html;    // display new report
    }
</script>

<?php include('../../includes/closing.php'); ?>