<?php
require_once 'header.php';
require_once 'side-bar.php';
require_once 'secure/db_connect.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id === 0) {
    header('Location: users');
    exit;
}

// Fetch user
$stmt = $conn->prepare("SELECT username, email, role FROM users WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
if (!$user) {
    die("User not found.");
}
$stmt->close();

// Protect Developer Accounts
if ($user['role'] === 'Developer' && $_SESSION['role'] !== 'Developer') {
    echo "<div class='main-content'><div class='container-fluid'><div class='alert alert-danger'>Access Denied: You cannot edit a Developer account.</div></div></div>";
    echo "</body></html>";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $role = $_POST['role'];
    $password = $_POST['password'];
    
    // Prevent non-developer from creating/assigning 'Developer' role
    if ($role === 'Developer' && $_SESSION['role'] !== 'Developer') {
        $error = "Access Denied: You cannot assign the Developer role.";
    } else {
        // Update logic
        $sql = "UPDATE users SET email = ?, role = ?";
        $types = "ss";
        $params = [$email, $role];
        
        if (!empty($password)) {
            $sql .= ", password = ?";
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $types .= "s";
            $params[] = $hash;
        }
        
        $sql .= " WHERE id = ?";
        $types .= "i";
        $params[] = $id;
        
        $update = $conn->prepare($sql);
        $update->bind_param($types, ...$params);
        
        if ($update->execute()) {
            $success = "User updated successfully.";
            // Refresh data
            $user['email'] = $email;
            $user['role'] = $role;
        } else {
            $error = "Failed to update user.";
        }
        $update->close();
    }
}
?>

<main class="main-content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="d-flex align-items-center mb-4">
                    <a href="users" class="btn btn-outline-secondary me-3"><i class="fas fa-arrow-left"></i></a>
                    <h3 class="fw-bold mb-0">Edit User: <?php echo htmlspecialchars($user['username']); ?></h3>
                </div>

                <?php if (isset($success)): ?>
                    <div class="alert alert-success"><?php echo $success; ?></div>
                <?php endif; ?>
                <?php if (isset($error)): ?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php endif; ?>

                <div class="card">
                    <div class="card-body">
                        <form method="POST">
                            <div class="mb-3">
                                <label class="form-label">Username</label>
                                <input type="text" class="form-control" value="<?php echo htmlspecialchars($user['username']); ?>" disabled>
                                <div class="form-text">Username cannot be changed.</div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Email Address</label>
                                <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($user['email']); ?>">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">New Password</label>
                                <input type="password" name="password" class="form-control" placeholder="Leave blank to keep current password">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Role</label>
                                <select name="role" class="form-select">
                                    <option value="Administrator" <?php echo $user['role'] === 'Administrator' ? 'selected' : ''; ?>>Administrator</option>
                                    <?php if ($_SESSION['role'] === 'Developer'): ?>
                                    <option value="Developer" <?php echo $user['role'] === 'Developer' ? 'selected' : ''; ?>>Developer</option>
                                    <?php endif; ?>
                                    <option value="Agent" <?php echo $user['role'] === 'Agent' ? 'selected' : ''; ?>>Agent</option>
                                    <option value="Editor" <?php echo $user['role'] === 'Editor' ? 'selected' : ''; ?>>Editor</option>
                                </select>
                            </div>
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary">Save Changes</button>
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
