<!-- Sidebar -->
<aside class="sidebar" id="sidebar">
    <div class="sidebar-header">
            <img src="../assets/img/logo/logo.png" alt="Laika Pet Clinic" style="height: 50px; width: auto;">
    </div>
    
    <div class="sidebar-menu">
        <ul class="nav flex-column">
            <!-- Dashboard -->
            <li class="nav-item">
                <a href="dashboard" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'dashboard.php' ? 'active' : ''; ?>">
                    <i class="fas fa-th-large"></i> Dashboard
                </a>
            </li>

            <!-- Blog Management Section -->
            <li class="sidebar-section-header">Blog Manager</li>
            <li class="nav-item">
                <a href="my-blogs" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'my-blogs.php' ? 'active' : ''; ?>">
                    <i class="fas fa-layer-group"></i> My Blogs
                </a>
            </li>
            <li class="nav-item">
                <a href="create-blog" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'create-blog.php' ? 'active' : ''; ?>">
                    <i class="fas fa-edit"></i> Create New Blog
                </a>
            </li>


            <!-- Account Section -->
            <li class="sidebar-section-header">Account</li>
            <li class="nav-item">
                <a href="profile" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'profile.php' ? 'active' : ''; ?>">
                    <i class="fas fa-user-circle"></i> My Profile
                </a>
            </li>
            
            <?php if (isset($_SESSION['role']) && ($_SESSION['role'] === 'Administrator' || $_SESSION['role'] === 'Developer')): ?>
            <li class="nav-item">
                <a href="users" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'users.php' ? 'active' : ''; ?>">
                    <i class="fas fa-users"></i> All Users
                </a>
            </li>
            <li class="nav-item">
                <a href="create-user" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'create-user.php' ? 'active' : ''; ?>">
                    <i class="fas fa-user-plus"></i> Add New User
                </a>
            </li>
            <?php endif; ?>
        </ul>
    </div>
    
    <div class="sidebar-footer">

        <a href="logout" class="nav-link text-danger">
            <i class="fas fa-sign-out-alt"></i> Logout
        </a>
    </div>
</aside>

<!-- Overlay for mobile -->
<div class="sidebar-overlay" id="sidebarOverlay"></div>

<script>
    // Simple toggle script
    document.getElementById('sidebarToggle').addEventListener('click', function() {
        document.getElementById('sidebar').classList.toggle('active');
        document.getElementById('sidebarOverlay').classList.toggle('active');
    });

    document.getElementById('sidebarOverlay').addEventListener('click', function() {
        document.getElementById('sidebar').classList.remove('active');
        this.classList.remove('active');
    });
</script>

<style>
    /* Overlay styles for mobile */
    .sidebar-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.5);
        z-index: 999;
    }
    .sidebar-overlay.active {
        display: block;
    }
    /* Ensure logo fits */
    .sidebar-brand img {
        max-width: 100%;
    }
</style>
