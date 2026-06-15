<?php
require_once 'header.php';
require_once 'side-bar.php';
require_once 'secure/db_connect.php';

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
        $error = "Invalid request.";
    } else {
        $current_password = $_POST['current_password'];
        $new_password = $_POST['new_password'];
        $confirm_password = $_POST['confirm_password'];

        if (empty($current_password) || empty($new_password) || empty($confirm_password)) {
            $error = "All fields are required.";
        } elseif ($new_password !== $confirm_password) {
            $error = "New passwords do not match.";
        } elseif (strlen($new_password) < 8) {
            $error = "New password must be at least 8 characters.";
        } else {
            // Verify current password
            $user_id = $_SESSION['user_id'];
            $stmt = $conn->prepare("SELECT password FROM users WHERE id = ?");
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($row = $result->fetch_assoc()) {
                if (password_verify($current_password, $row['password'])) {
                    // Update password
                    $new_hash = password_hash($new_password, PASSWORD_DEFAULT);
                    $update = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
                    $update->bind_param("si", $new_hash, $user_id);
                    if ($update->execute()) {
                        $success = "Password updated successfully.";
                        log_action($conn, $user_id, "Password Changed", "User updated their own password.");
                    } else {
                        $error = "Failed to update password.";
                    }
                    $update->close();
                } else {
                    $error = "Current password is incorrect.";
                }
            }
            $stmt->close();
        }
    }
}

// Fetch current user details
$user_id = $_SESSION['user_id'];
$user_stmt = $conn->prepare("SELECT username, email, role FROM users WHERE id = ?");
$user_stmt->bind_param("i", $user_id);
$user_stmt->execute();
$user_data = $user_stmt->get_result()->fetch_assoc();
$user_stmt->close();
?>

<main class="main-content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="mb-4">
                    <h3 class="fw-bold mb-1">My Profile</h3>
                    <p class="text-muted small">Manage your account settings and security</p>
                </div>

                <?php if ($success): ?>
                    <div class="alert alert-success border-0 shadow-sm"><?php echo $success; ?></div>
                <?php endif; ?>
                <?php if ($error): ?>
                    <div class="alert alert-danger border-0 shadow-sm"><?php echo $error; ?></div>
                <?php endif; ?>

                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-4">
                            <div class="bg-soft-primary rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 60px; height: 60px;">
                                <i class="fas fa-user text-primary fs-4"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold mb-0"><?php echo htmlspecialchars($user_data['username']); ?></h5>
                                <span class="badge bg-soft-primary text-primary small rounded-pill"><?php echo htmlspecialchars($user_data['role']); ?></span>
                            </div>
                        </div>
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="small text-muted mb-1">Email Address</label>
                                <div class="fw-bold"><?php echo htmlspecialchars($user_data['email'] ?: 'Not set'); ?></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-bottom-0 pt-4 px-4">
                        <h5 class="fw-bold mb-0">Change Password</h5>
                    </div>
                    <div class="card-body p-4">
                        <form method="POST">
                            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars(csrf_token()); ?>">
                            
                            <div class="mb-3">
                                <label class="form-label small fw-bold">Current Password</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0"><i class="fas fa-lock text-muted"></i></span>
                                    <input type="password" name="current_password" class="form-control bg-light border-0" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label small fw-bold">New Password</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0"><i class="fas fa-key text-muted"></i></span>
                                    <input type="password" name="new_password" class="form-control bg-light border-0" required>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label small fw-bold">Confirm New Password</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0"><i class="fas fa-check-circle text-muted"></i></span>
                                    <input type="password" name="confirm_password" class="form-control bg-light border-0" required>
                                </div>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary py-2 fw-bold">Update Password</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<style>
.bg-soft-primary { background: rgba(13, 110, 253, 0.1); }
.text-primary { color: #0d6efd !important; }
</style>

</body>
</html>
