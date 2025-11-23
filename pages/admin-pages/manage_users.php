<?php
    session_start();
    $pageTitle = "User Management - ArcherInnov Canteen Pre-order System";
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
        <div><h1 class="text-center flex-grow-1 fw-bold text-success">User Management</h1></div>
        <div>
            <a href="create_user.php" class="btn btn-success">
                <i class="bi bi-plus-circle me-2"></i> Create User 
            </a>
            <button class="btn btn-outline-secondary" onclick="window.location.reload()">
                <i class="bi bi-arrow-clockwise me-1"></i> Refresh
            </button>
        </div>
    </div>

    <?php
        include ('../../config/db.php');
        // Fetch summary data
        $userCount = $conn->query("SELECT COUNT(*) as count FROM users")->fetch_assoc()['count'];
        $activeUsers = $conn->query("SELECT COUNT(*) as count FROM users WHERE status = 'active'")->fetch_assoc()['count']; 

        // Fetch users
        $sql = "SELECT * FROM users ORDER BY full_name ASC";
        $result = $conn->query($sql);
        $users = [];
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $users[] = $row;
            }
        }

        // group users by role
        $groupedUsers = [];
        foreach ($users as $user) {
            $role = $user['user_type'];
            if (!isset($groupedUsers[$role])) {
                $groupedUsers[$role] = [];
            }
            $groupedUsers[$role][] = $user;
        }

        $conn->close();
    ?>

    <!-- Summary Cards -->
    <div class="row g-3 mb-3 w-100">
        <div class="col-md-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-muted small">Active/Total Users</div>
                            <div class="fs-3 fw-bold" id="userCount"><?= htmlspecialchars($activeUsers)?>/<?= htmlspecialchars($userCount)?></div>
                        </div>
                        <i class="bi bi-people fs-1 text-success opacity-75"></i>
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
                        <input type="text" id="userFilter" class="form-control" placeholder="Search user name,...">
                    </div>
                    <div class="form-text">Tip: Try users name, email or role.</div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body">
                    <div class="text-muted small mb-1">Quick Links</div>
                    <div class="d-flex gap-2 flex-wrap">
                        <a href="dashboard.php" class="btn btn-outline-success btn-sm"><i class="bi bi-speedometer2 me-1"></i>Dashboard</a>
                        <a href="reports.php" class="btn btn-outline-success btn-sm"><i class="bi bi-bar-chart-line me-1"></i>View Reports</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br>

    <!-- Users Table -->
    <?php if(count($users) > 0): ?>
        <?php foreach ($groupedUsers as $role => $usersInRole): ?>
            <?php if (count($usersInRole) > 0): ?>
                <h4 class="text-success fw-bold mt-4 text-capitalize"><?= htmlspecialchars($role) ?>s</h4>
                <div class="card shadow-sm w-100 mb-4">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover align-middle user-table">
                                <thead  class="table-success text-center">
                                    <tr>
                                        <th scope="col">Full Name</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="usersTable" data-role="<?=$role?>">
                                    <?php foreach ($usersInRole as $user): ?>
                                        <tr id="user-<?=$user['user_id']?>" class="text-center">
                                            <td><?= htmlspecialchars($user['full_name']) ?></td>
                                            <td><?= htmlspecialchars($user['email']) ?></td>
                                            <td>
                                                <?php if ($user['status'] === 'active'): ?>
                                                    <span class="badge bg-success">Active</span>
                                                <?php else: ?>
                                                    <span class="badge bg-secondary">Inactive</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <a href="edit_user.php?id=<?= urlencode($user['user_id']) ?>" class="btn btn-sm btn-outline-success me-2">
                                                    <i class="bi bi-pencil-square me-1"></i> Edit
                                                </a>
                                                <?php if ($user['status'] === 'inactive' || $user['user_type'] === 'staff' || $user['user_type'] === 'admin'): ?>
                                                    <a href="delete_user.php?id=<?= urlencode($user['user_id']) ?>" class="btn btn-sm btn-outline-danger deleteUserBtn" data-id="<?=$user['user_id']?>" data-action="delete_user" title="Delete User">
                                                        <i class="bi bi-trash me-1"></i> Delete
                                                    </a>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="alert alert-info text-center" role="alert">
            No user data found. <a href="create_user.php" class="alert-link">Create a new user</a>.
        </div>
    <?php endif; ?>
    
</main>

<?php include('../../includes/closing.php'); ?>