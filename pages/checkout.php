<?php 
$pageTitle = "Checkout - ArcherInnov Canteen Pre-order System";
include('../includes/initial.php');

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include('../config/db.php');

// Get user's balance
$user_id = $_SESSION['user_id'];
$sql = "SELECT balance FROM users WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$accountBalance = $user['balance'] ?? 0;
$stmt->close();

// Get cart items
$cartItems = $_SESSION['cart'] ?? [];
$cartTotal = 0;

if (empty($cartItems)) {
    header("Location: orders.php");
    exit();
}

foreach ($cartItems as $item) {
    $cartTotal += $item['price'] * $item['quantity'];
}

$conn->close();
?>

<main class="container my-5 fullHeight">
    <h2 class="mb-4">Checkout</h2>
    
    <div class="row g-10">
        <!-- Order Summary (Left) -->
        <div class="col-lg-8">
            <div class="card sticky-top" style="top: 20px;">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">Order Summary</h5>
                </div>
                <div class="card-body">
                    <?php foreach ($cartItems as $item): ?>
                        <?php $itemTotal = $item['price'] * $item['quantity']; ?>
                        <div class="d-flex justify-content-between align-items-center mb-3 pb-3 border-bottom">
                            <div>
                                <h6 class="mb-1"><?= htmlspecialchars($item['name']) ?></h6>
                                <small class="text-muted"><?= (int) $item['quantity'] ?> x &#8369;<?= number_format($item['price'], 2) ?></small>
                            </div>
                            <strong>&#8369;<?= number_format($itemTotal, 2) ?></strong>
                        </div>
                    <?php endforeach; ?>
                    
                    <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top">
                        <h5 class="mb-0">Total:</h5>
                        <h4 class="text-success mb-0">&#8369;<?= number_format($cartTotal, 2) ?></h4>
                    </div>
                </div>
            </div>
        </div>

        <!-- Payment & Checkout (Right) -->
        <div class="col-lg-8">
            <form id="checkoutForm" method="POST" action="../processes/process_checkout.php" novalidate>
                <!-- Account Balance -->
                <div class="card mb-3">
                    <div class="card-body">
                        <h6 class="card-title mb-3">Account Balance</h6>    
                        <p class="fs-5 text-success mb-3"><strong>&#8369;<?= number_format($accountBalance, 2) ?></strong></p>
                        <small class="text-muted d-block mb-3">Available for payment</small>
                        
                        <!-- Top-up Section -->
                        <button type="button" class="btn btn-outline-success btn-sm" data-bs-toggle="collapse" data-bs-target="#topupForm">
                            <i class="bi bi-plus-circle"></i> Top Up Balance
                        </button>
                        
                        <div class="collapse mt-3" id="topupForm">
                            <form id="topupForm" action="../processes/process_topup.php" method="POST" class="border-top pt-3">
                                <div class="mb-3">
                                    <label for="topupAmount" class="form-label">Amount to Top Up (₱)</label>
                                    <input type="number" class="form-control" id="topupAmount" name="topup_amount" min="1" step="0.01" placeholder="Enter amount" required>
                                    <small class="text-muted">Enter the amount you want to add to your balance</small>
                                </div>
                                <button type="submit" class="btn btn-success btn-sm w-100">Submit for Approval</button>
                            </form>
                            <div id="topupStatus" class="mt-3 d-none">
                                <div class="alert alert-info" role="alert">
                                    <small><strong>Pending Admin Approval</strong><br>Amount: <span id="statusAmount">₱0.00</span><br>Your request is waiting for admin approval.</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Payment Method Selection -->
                <div class="card mb-3">
                    <div class="card-header bg-light">
                        <h6 class="mb-0">Select Payment Method</h6>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <!-- Wallet Option -->
                            <div class="col-6">
                                <div class="form-check">
                                    <input class="form-check-input payment-method" type="radio" name="payment_method" id="wallet" value="wallet" checked required>
                                    <label class="form-check-label" for="wallet">
                                        <strong>School Wallet</strong>
                                        <br>
                                        <small class="text-muted">Use balance</small>
                                    </label>
                                </div>
                            </div>

                            <!-- Cash Option -->
                            <div class="col-6">
                                <div class="form-check">
                                    <input class="form-check-input payment-method" type="radio" name="payment_method" id="cash" value="cash" required>
                                    <label class="form-check-label" for="cash">
                                        <strong>Cash</strong>
                                        <br>
                                        <small class="text-muted">At pickup</small>
                                    </label>
                                </div>
                            </div>

                            <!-- GCash Option -->
                            <div class="col-6">
                                <div class="form-check">
                                    <input class="form-check-input payment-method" type="radio" name="payment_method" id="gcash" value="gcash" required disabled>
                                    <label class="form-check-label text-muted" for="gcash">
                                        <strong>GCash</strong>
                                        <br>
                                        <small>Coming soon</small>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Wallet Warning -->
                <div id="walletWarning" class="alert alert-warning d-none" role="alert">
                    <small>
                        <strong>Insufficient Balance!</strong> Your account balance is not enough for this order. 
                        Please choose another payment method.
                    </small>
                </div>

                <!-- Pickup Time -->
                <div class="card mb-3">
                    <div class="card-header bg-light">
                        <h6 class="mb-0">Pickup Time</h6>
                    </div>
                    <div class="card-body">
                        <input type="time" class="form-control" name="pickup_time" required>
                        <small class="text-muted d-block mt-2">When would you like to pick up your order?</small>
                    </div>
                </div>

                <!-- Terms & Order Total -->
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="mb-3">
                            <strong>Order Total:</strong>
                            <h5 class="text-success">&#8369;<?= number_format($cartTotal, 2) ?></h5>
                        </div>

                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="agree" name="agree" required>
                            <label class="form-check-label" for="agree">
                                <small>I agree to the terms and conditions</small>
                            </label>
                        </div>

                        <button type="submit" class="btn btn-success w-100 btn-lg" id="checkoutBtn">
                            <i class="bi bi-check-circle"></i> Complete Order
                        </button>
                    </div>
                </div>

                <a href="orders.php" class="btn btn-outline-secondary w-100">Back to Cart</a>
            </form>
        </div>
    </div>
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const walletRadio = document.getElementById('wallet');
    const walletWarning = document.getElementById('walletWarning');
    const checkoutBtn = document.getElementById('checkoutBtn');
    const cardRadio = document.getElementById('card');
    const checkoutForm = document.getElementById('checkoutForm');
    const accountBalance = <?= json_encode($accountBalance) ?>;
    const cartTotal = <?= json_encode($cartTotal) ?>;

    // Check wallet balance and show warning
    function updateWalletStatus() {
        if (walletRadio.checked) {
            if (accountBalance < cartTotal) {
                walletWarning.classList.remove('d-none');
                checkoutBtn.disabled = true;
            } else {
                walletWarning.classList.add('d-none');
                checkoutBtn.disabled = false;
            }
        }
    }

    // Handle payment method changes
    document.querySelectorAll('.payment-method').forEach(radio => {
        radio.addEventListener('change', function() {
            if (cardRadio.checked) {
                checkoutBtn.disabled = true;
                checkoutBtn.textContent = 'Coming Soon';
            } else {
                checkoutBtn.disabled = false;
                checkoutBtn.innerHTML = '<i class="bi bi-check-circle"></i> Complete Order';
            }
            updateWalletStatus();
        });
    });

    // Form submission
    checkoutForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        if (!this.checkValidity()) {
            e.stopPropagation();
            this.classList.add('was-validated');
            return;
        }

        // Disable button to prevent double submission
        checkoutBtn.disabled = true;
        checkoutBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Processing...';

        // Submit form
        this.submit();
    });

    // Top-up form handling
    const topupForm = document.getElementById('topupForm');
    if (topupForm) {
        topupForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            if (!this.checkValidity()) {
                e.stopPropagation();
                this.classList.add('was-validated');
                return;
            }

            const amount = document.getElementById('topupAmount').value;
            const statusDiv = document.getElementById('topupStatus');
            const statusAmount = document.getElementById('statusAmount');
            
            // Show pending status
            statusAmount.textContent = '₱' + parseFloat(amount).toFixed(2);
            this.style.display = 'none';
            statusDiv.classList.remove('d-none');
            
            // Submit the form
            setTimeout(() => {
                this.submit();
            }, 1000);
        });
    }

    // Initial check
    updateWalletStatus();
});
</script>

<?php include('../includes/footer.php'); ?>
