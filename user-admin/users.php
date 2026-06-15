<?php
require_once 'header.php';
require_once 'side-bar.php';
require_once 'secure/db_connect.php';

// Handle Delete Action
if (isset($_POST['delete_id'])) {
    $delete_id = intval($_POST['delete_id']);
    
    // Check permission
    $can_delete = true;
    $target_res = $conn->query("SELECT role FROM users WHERE id = $delete_id");
    if ($target_res && $target_row = $target_res->fetch_assoc()) {
        if ($target_row['role'] === 'Developer' && $_SESSION['role'] !== 'Developer') {
            $can_delete = false;
            $error_msg = "Access Denied: You cannot delete a Developer account.";
        }
    }

    // Prevent self-delete
    if ($delete_id == $_SESSION['user_id']) {
        $can_delete = false;
        $error_msg = "You cannot delete yourself.";
    }

    if ($can_delete) {
        $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
        $stmt->bind_param("i", $delete_id);
        if ($stmt->execute()) {
            $success_msg = "User deleted successfully.";
            log_action($conn, $_SESSION['user_id'], "User Deleted", "Deleted user ID: $delete_id");
        } else {
            $error_msg = "Failed to delete user.";
        }
        $stmt->close();
    }
}

// Fetch users
$users = [];
$table_exists = $conn->query("SHOW TABLES LIKE 'users'")->num_rows > 0;

if ($table_exists) {
    $result = $conn->query("SELECT id, username, email, role, last_login, created_at FROM users ORDER BY created_at DESC");
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $users[] = $row;
        }
    }
}
?>

<main class="main-content">
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="fw-bold">User Management</h3>
            <a href="create-user" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i> Add New User
            </a>
        </div>

        <?php if (!$table_exists): ?>
            <div class="alert alert-warning shadow-sm border-0 d-flex align-items-center">
                <i class="fas fa-database fs-4 me-3"></i>
                <div class="flex-grow-1">
                    <h6 class="mb-0 fw-bold">Database Setup Required</h6>
                    <p class="mb-0 small">The User Management table is missing. Please run the <a href="secure/setup_database" class="alert-link fw-bold">Automated Setup Tool</a> to restore it.</p>
                </div>
            </div>
        <?php endif; ?>

        <?php if (isset($success_msg)): ?>
            <div class="alert alert-success"><?php echo $success_msg; ?></div>
        <?php endif; ?>
        <?php if (isset($error_msg)): ?>
            <div class="alert alert-danger"><?php echo $error_msg; ?></div>
        <?php endif; ?>

        <div class="card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th>User</th>
                                <th>Role</th>
                                <th>Status/Last Login</th>
                                <th>Joined</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($users as $user): ?>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="user-avatar me-3" style="width: 35px; height: 35px; font-size: 0.9rem;">
                                            <?php echo strtoupper(substr($user['username'], 0, 1)); ?>
                                        </div>
                                        <div>
                                            <div class="fw-bold"><?php echo htmlspecialchars($user['username']); ?></div>
                                            <div class="small text-muted"><?php echo htmlspecialchars($user['email']); ?></div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge <?php echo $user['role'] === 'Administrator' ? 'badge-warning' : 'badge-success'; ?>">
                                        <?php echo htmlspecialchars($user['role']); ?>
                                    </span>
                                </td>
                                <td>
                                    <?php if ($user['last_login']): ?>
                                        <span class="text-muted small"><i class="far fa-clock me-1"></i> <?php echo date('M d, Y H:i', strtotime($user['last_login'])); ?></span>
                                    <?php else: ?>
                                        <span class="text-muted small">Never</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <span class="text-muted small"><?php echo date('M d, Y', strtotime($user['created_at'])); ?></span>
                                </td>
                                <td class="text-end">
                                    <div class="d-flex justify-content-end gap-2">
                                        <?php 
                                        $is_target_dev = ($user['role'] === 'Developer');
                                        $i_am_dev = ($_SESSION['role'] === 'Developer');
                                        
                                        // Edit Button
                                        if (!$is_target_dev || $i_am_dev): 
                                        ?>
                                            <a href="edit-user?id=<?php echo $user['id']; ?>" class="btn btn-sm btn-primary shadow-sm" title="Edit User">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        <?php endif; ?>

                                        <?php 
                                        // Delete Button (Only if not self, and target is not protected)
                                        if ($user['id'] != $_SESSION['user_id'] && (!$is_target_dev || $i_am_dev)): 
                                        ?>
                                            <form method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this user? This action cannot be undone.');">
                                                <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
                                                <input type="hidden" name="delete_id" value="<?php echo $user['id']; ?>">
                                                <button type="submit" class="btn btn-sm btn-danger shadow-sm" title="Delete User">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
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
    </div>
</main>
</body>
</html>
