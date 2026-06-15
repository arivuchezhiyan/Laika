<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once 'secure/auth.php';
require_once 'secure/db_connect.php';

// Redirect if already logged in
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header('Location: dashboard');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
        $error = "Invalid request";
    } elseif (!empty($db_connection_error)) {
        $error = "Database Connection Failed: " . $db_connection_error;
    } else {
        $username = trim($_POST['username']);
        $password = $_POST['password'];

        // Using prepared statement to prevent SQL injection
        $stmt = $conn->prepare("SELECT id, username, email, password, role FROM users WHERE username = ?");
        if ($stmt) {
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($row = $result->fetch_assoc()) {
                // Verify password using password_verify
                if (password_verify($password, $row['password'])) {
                    session_regenerate_id(true);
                    $_SESSION['admin_logged_in'] = true;
                    $_SESSION['username'] = $row['username'];
                    $_SESSION['user_id'] = $row['id'];
                    $_SESSION['email'] = $row['email'];
                    $_SESSION['role'] = $row['role'];
                    
                    // Update last_login
                    $update_stmt = $conn->prepare("UPDATE users SET last_login = NOW() WHERE id = ?");
                    $update_stmt->bind_param("i", $row['id']);
                    $update_stmt->execute();
                    $update_stmt->close();
                    
                    header('Location: dashboard');
                    exit;
                } elseif ($password === $row['password']) {
                    // Fallback for migration
                    $newHash = password_hash($password, PASSWORD_DEFAULT);
                    $upd = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
                    $upd->bind_param("si", $newHash, $row['id']);
                    $upd->execute();

                    session_regenerate_id(true);
                    $_SESSION['admin_logged_in'] = true;
                    $_SESSION['username'] = $row['username'];
                    $_SESSION['user_id'] = $row['id'];
                    $_SESSION['email'] = $row['email'];
                    $_SESSION['role'] = $row['role'];

                    // Update last_login
                    $update_stmt = $conn->prepare("UPDATE users SET last_login = NOW() WHERE id = ?");
                    $update_stmt->bind_param("i", $row['id']);
                    $update_stmt->execute();
                    $update_stmt->close();

                    header('Location: dashboard');
                    exit;
                } else {
                    $error = "Invalid credentials";
                }
            } else {
                $error = "Invalid credentials";
            }
            $stmt->close();
        } else {
            $error = "Database error";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="ta">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Login - Laika Pet Clinic</title>
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  <!-- Custom CSS -->
  <link rel="stylesheet" href="assets/css/login.css">
  <!-- FontAwesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
  <div class="login-bg">
    <div class="login-card">
      <h4><i class="fas fa-user-shield me-2"></i> Laika Pet Clinic</h4>
      <?php if (!empty($db_connection_error)): ?>
        <div class="alert alert-danger">
            <i class="fas fa-exclamation-triangle me-1"></i> <strong>Database Connection Failed:</strong> <?php echo htmlspecialchars($db_connection_error); ?>
        </div>
      <?php elseif (isset($error)): ?>
        <div class="alert alert-danger">
            <i class="fas fa-exclamation-circle me-1"></i> <?php echo htmlspecialchars($error); ?>
        </div>
      <?php endif; ?>
      <form method="POST" action="">
        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars(csrf_token(), ENT_QUOTES, 'UTF-8'); ?>">
        <div class="form-group">
          <label for="username">Username</label>
          <input type="text" class="form-control" id="username" name="username" required autocomplete="username" placeholder="Enter username">
        </div>
        <div class="form-group">
          <label for="password">Password</label>
          <input type="password" class="form-control" id="password" name="password" required autocomplete="current-password" placeholder="Enter password">
        </div>
        <button type="submit" class="btn btn-primary" style="background: #ed1f31; border-color: #ed1f31;">
            Sign In <i class="fas fa-arrow-right ms-2"></i>
        </button>
      </form>
      <div style="text-align: center; margin-top: 1rem; font-size: 0.85rem; color: #6c757d;">
        &copy; <?php echo date('Y'); ?> Laika Pet Clinic. All rights reserved.
      </div>
    </div>
  </div>
</body>
</html>
