<?php
require_once __DIR__ . '/secure/auth.php';
require_once __DIR__ . '/secure/db_connect.php';
require_once __DIR__ . '/secure/functions.php';
require_login();

// Sync session with latest database data
if (empty($db_connection_error)) {
    sync_user_session($conn);
}

// user details from session
$current_user = $_SESSION['username'] ?? 'Admin';
$current_role = $_SESSION['role'] ?? 'Administrator';

// Specific branding override for 'sanjay' user as requested
$display_name = ($current_user === 'sanjay') ? 'Laika Pet Clinic' : $current_user;
$display_role = ($current_user === 'sanjay') ? 'Primary Admin' : $current_role;
$display_initial = ($current_user === 'sanjay') ? 'L' : strtoupper(substr($current_user, 0, 1));
?>
<!DOCTYPE html>
<html lang="ta">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Laika Pet Clinic</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Bootstrap -->
    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/css/admin.css">
</head>
<body>

<!-- Mobile Toggle -->
<header class="main-header">
    <div class="header-left d-flex align-items-center">
        <button class="toggle-sidebar" id="sidebarToggle">
            <i class="fas fa-bars"></i>
        </button>
        <h2>Dashboard</h2>
    </div>
    
    <div class="header-right">
        <div class="user-profile dropdown">
            <div class="text-end me-2 d-none d-sm-block">
                <div class="fw-bold"><?php echo htmlspecialchars($display_name); ?></div>
                <div class="text-muted small"><?php echo htmlspecialchars($display_role); ?></div>
            </div>
            <div class="user-avatar">
                <?php echo htmlspecialchars($display_initial); ?>
            </div>
        </div>
    </div>
</header>
