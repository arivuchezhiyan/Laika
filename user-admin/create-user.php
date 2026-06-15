<?php
require_once 'header.php';
require_once 'side-bar.php';
require_once 'secure/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if table exists
    $table_check = $conn->query("SHOW TABLES LIKE 'users'");
    if ($table_check->num_rows === 0) {
        $error = "Critical Error: The User Management system is not yet set up. <a href='secure/setup_database' class='alert-link'>Click here to run the Setup Tool</a>.";
    } elseif (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
        $error = "Invalid request.";
    } else {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $allowed_roles = ['Administrator', 'Agent', 'Editor'];
    $role = in_array($_POST['role'] ?? '', $allowed_roles, true) ? $_POST['role'] : 'Editor';
    
    if (!preg_match('/^[A-Za-z0-9_.-]{3,50}$/', $username)) {
        $error = "Username must be 3-50 characters and contain only letters, numbers, dot, underscore, or hyphen.";
    } elseif (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Please enter a valid email address.";
    } elseif (empty($username) || empty($password)) {
        $error = "Username and Password are required.";
    } elseif (strlen($password) < 8) {
        $error = "Password must be at least 8 characters.";
    } else {
        // Check if username exists
        $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();
        
        if ($stmt->num_rows > 0) {
            $error = "Username already exists.";
        } else {
            // Insert
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $insert = $conn->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)");
            $insert->bind_param("ssss", $username, $email, $hash, $role);
            
            if ($insert->execute()) {
                $success = "User created successfully.";
            } else {
                $error = "Database error: " . $conn->error;
            }
            $insert->close();
        }
        $stmt->close();
    }
    }
}
?>

<main class="main-content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="d-flex align-items-center mb-4">
                    <a href="users" class="btn btn-outline-secondary me-3"><i class="fas fa-arrow-left"></i></a>
                    <h3 class="fw-bold mb-0">Create New User</h3>
                </div>

                <?php if (isset($error)): ?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php endif; ?>
                <?php if (isset($success)): ?>
                    <div class="alert alert-success">
                        <?php echo $success; ?> 
                        <a href="users" class="alert-link">Return to list</a>
                    </div>
                <?php endif; ?>

                <div class="card">
                    <div class="card-body">
                        <form method="POST">
                            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars(csrf_token(), ENT_QUOTES, 'UTF-8'); ?>">
                            <div class="mb-3">
                                <label class="form-label">Username</label>
                                <input type="text" name="username" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Email Address</label>
                                <input type="email" name="email" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Password</label>
                                <input type="password" name="password" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Role</label>
                                <select name="role" class="form-select">
                                    <option value="Administrator">Administrator</option>
                                    <option value="Agent">Agent</option>
                                    <option value="Editor">Editor</option>
                                </select>
                            </div>
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary">Create User</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
</body>
</html>
