<?php
    $pageTitle = "Sample Terms & Conditions - ArcherInnov Canteen";
    include('../includes/initial.php');
?>

<main class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h2 class="mb-3">Sample Terms & Conditions</h2>
                    <p class="text-muted">This sample is provided for reference only. Replace with your official policy.</p>
                    <ol class="mb-4">
                        <li><strong>Order Accuracy:</strong> Confirm item names, quantities, and pickup time before submitting.</li>
                        <li><strong>Payment:</strong> Wallet payments deduct upon admin approval; cash is paid at pickup.</li>
                        <li><strong>Cancellations:</strong> Contact staff promptly; late cancellations may be charged.</li>
                        <li><strong>Pickup Window:</strong> Orders not collected within 30 minutes may be voided.</li>
                        <li><strong>Allergies:</strong> Notify staff of dietary restrictions before ordering.</li>
                    </ol>
                    <a href="checkout.php" class="btn btn-outline-success">Back to Checkout</a>
                </div>
            </div>
        </div>
    </div>
</main>

<?php include('../includes/footer.php'); ?>
