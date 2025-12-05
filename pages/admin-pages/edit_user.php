<?php
    session_start();
    $pageTitle = "Edit User - ArcherInnov Canteen Pre-order System";
    include('../../includes/sidebar.php');
    include('../../config/db.php');

    $user = null;
    $error = null;

    if (isset($_GET['id'])) {
        $userId = intval($_GET['id']);
        $stmt = $conn->prepare("SELECT user_id, username, full_name, email, user_type, status FROM users WHERE user_id = ?");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
        } else {
            $error = "User not found.";
        }
        $stmt->close();
    } else {
        $error = "Invalid request.";
    }

    // Close early if we already know there's an error to show.
    if ($error) {
        $conn->close();
    }
?>

<main class="admin-content container my-5 fullHeight d-flex flex-column align-items-center justify-content-start">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center w-100 mb-3">
        <div class="d-flex align-items-center gap-2">
            <a href="manage_users.php" class="btn btn-outline-success btn-sm shadow-sm">
                <i class="bi bi-arrow-left me-1"></i> Back
            </a>
        </div>
        <h1 class="text-center flex-grow-1 fw-bold text-success">Edit User</h1>
        <div></div>
    </div>

    <?php if ($error): ?>
        <div class="alert alert-danger w-100 text-center" role="alert">
            <?= htmlspecialchars($error) ?>
        </div>
    <?php else: ?>
        <?php
            // Ensure we do not drop uncommon roles by always including the existing one.
            $roleOptions = ['admin', 'staff', 'customer'];
            if (!in_array($user['user_type'], $roleOptions)) {
                array_unshift($roleOptions, $user['user_type']);
            }
        ?>
        <div class="card shadow-sm w-100" style="max-width: 700px;">
            <div class="card-body">
                <form class="needs-validation" id="editUserForm" method="POST" novalidate>
                    <input type="hidden" name="user_id" value="<?= htmlspecialchars($user['user_id']) ?>">
                    
                    <div class="mb-3">
                        <label for="full_name" class="form-label">Full Name</label>
                        <input type="text" class="form-control" id="full_name" name="full_name" value="<?= htmlspecialchars($user['full_name']) ?>" required pattern="^[A-Za-z' -]{2,} [A-Za-z' -]{2,}$">
                        <div class="invalid-feedback">Please enter the full name.</div>
                    </div>

                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username" value="<?= htmlspecialchars($user['username']) ?>" required pattern="^[A-Za-z][A-Za-z0-9_-]{2,14}$">
                        <div class="invalid-feedback">Please enter a username.</div>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required pattern="^[^\\s@]+@[^\\s@]+\\.[^\\s@]+$">
                        <div class="invalid-feedback">Please enter a valid email address.</div>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="user_type" class="form-label">User Role</label>
                            <select class="form-select" id="user_type" name="user_type" required>
                                <option value="" disabled>Select Role</option>
                                <?php foreach ($roleOptions as $role): ?>
                                    <option value="<?= htmlspecialchars($role) ?>" <?php if ($user['user_type'] === $role) echo 'selected'; ?>>
                                        <?= ucfirst(htmlspecialchars($role)) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback">Please select a user role.</div>
                        </div>
                        <div class="col-md-6">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select" id="status" name="status" required>
                                <option value="active" <?php if ($user['status'] === 'active') echo 'selected'; ?>>Active</option>
                                <option value="inactive" <?php if ($user['status'] === 'inactive') echo 'selected'; ?>>Inactive</option>
                            </select>
                            <div class="invalid-feedback">Please set the account status.</div>
                        </div>
                    </div>

                    <hr class="my-4">
                    <p class="text-muted small mb-3">Password (optional) — leave blank to keep the current password.</p>
                    <div class="mb-3">
                        <label for="new_password" class="form-label">New Password</label>
                        <input type="password" class="form-control" id="new_password" name="new_password" minlength="8" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\\d)(?=.*[\\W_]).+$">
                        <div class="invalid-feedback">Password must meet the requirements.</div>
                    </div>
                    <div class="mb-3">
                        <label for="confirm_new_password" class="form-label">Confirm New Password</label>
                        <input type="password" class="form-control" id="confirm_new_password" name="confirm_new_password" minlength="8" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\\d)(?=.*[\\W_]).+$">
                        <div class="invalid-feedback">Passwords must match.</div>
                    </div>

                    <div class="text-end mt-4">
                        <button type="submit" class="btn btn-danger px-4">
                            <i class="bi bi-save me-2"></i> Update User
                        </button>
                    </div>
                </form>
            </div>
        </div>
    <?php endif; ?>
</main>

<?php
    // Close the DB connection after the form has been rendered.
    $conn->close();
?>

<?php include('../../includes/closing.php'); ?>
