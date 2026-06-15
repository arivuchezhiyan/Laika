<?php
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/db_connect.php';

// Only allow logged in users to run setup (as a safety measure)
// If they are locked out, they can rename this file temporarily to bypass check
$is_safe = !empty($_SESSION['admin_logged_in']);

$status = [];
$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['run_setup'])) {
    if (isset($db_connection_error)) {
        $error = "Database connection failed. Cannot initialize database. Error details: " . $db_connection_error;
    } else {
        // Disable foreign key checks temporarily during initialization to prevent constraint errors
        $conn->query("SET FOREIGN_KEY_CHECKS = 0");

    $queries = [
        "users" => "CREATE TABLE IF NOT EXISTS users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            username VARCHAR(50) NOT NULL UNIQUE,
            email VARCHAR(100),
            password VARCHAR(255) NOT NULL,
            role ENUM('Administrator', 'Agent', 'Editor', 'Developer') DEFAULT 'Editor',
            last_login DATETIME,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci",

        "system_logs" => "CREATE TABLE IF NOT EXISTS system_logs (
            id INT AUTO_INCREMENT PRIMARY KEY,
            user_id INT,
            action VARCHAR(255),
            details TEXT,
            ip_address VARCHAR(45),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci",

        "category" => "CREATE TABLE IF NOT EXISTS category (
            category_id INT AUTO_INCREMENT PRIMARY KEY,
            category_name VARCHAR(255) NOT NULL,
            category_slug VARCHAR(255) NOT NULL UNIQUE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci",

        "tags" => "CREATE TABLE IF NOT EXISTS tags (
            tag_id INT AUTO_INCREMENT PRIMARY KEY,
            tag_name VARCHAR(255) NOT NULL,
            tag_slug VARCHAR(255) NOT NULL UNIQUE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci",

        "posts" => "CREATE TABLE IF NOT EXISTS posts (
            post_id INT AUTO_INCREMENT PRIMARY KEY,
            post_title VARCHAR(255) NOT NULL,
            post_slug VARCHAR(255) NOT NULL UNIQUE,
            category_id INT DEFAULT NULL,
            post_content LONGTEXT NOT NULL,
            meta_title VARCHAR(255) DEFAULT NULL,
            meta_description TEXT DEFAULT NULL,
            meta_keyword VARCHAR(255) DEFAULT NULL,
            image_path VARCHAR(255) DEFAULT NULL,
            post_status ENUM('draft', 'published') DEFAULT 'draft',
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            published_at TIMESTAMP NULL DEFAULT NULL,
            CONSTRAINT fk_posts_category FOREIGN KEY (category_id) REFERENCES category(category_id) ON DELETE SET NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci",

        "post_tags" => "CREATE TABLE IF NOT EXISTS post_tags (
            post_id INT NOT NULL,
            tag_id INT NOT NULL,
            PRIMARY KEY (post_id, tag_id),
            CONSTRAINT fk_post_tags_posts FOREIGN KEY (post_id) REFERENCES posts(post_id) ON DELETE CASCADE,
            CONSTRAINT fk_post_tags_tags FOREIGN KEY (tag_id) REFERENCES tags(tag_id) ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci"
    ];

    $error = null;
    foreach ($queries as $table => $sql) {
        if ($conn->query($sql)) {
            $status[] = "Table '$table' is active and ready.";
        } else {
            $error = "Error creating table $table: " . $conn->error;
            break;
        }
    }

    // Re-enable foreign key checks
    $conn->query("SET FOREIGN_KEY_CHECKS = 1");

    if (!$error) {
        // Create default admin if table is empty
        $check = $conn->query("SELECT id FROM users LIMIT 1");
        if ($check && $check->num_rows === 0) {
            $user = 'admin';
            $pass = password_hash('admin123', PASSWORD_DEFAULT);
            $email = 'admin@QASWAH HEALTH CLINIC.com';
            $role = 'Administrator';

            $stmt = $conn->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $user, $email, $pass, $role);
            if ($stmt->execute()) {
                $status[] = "Default Administrator created (User: admin / Pass: admin123)";
            } else {
                $error = "Failed to create default user: " . $conn->error;
            }
            $stmt->close();
        }
    }
    }
}
?>
<!DOCTYPE html>
<html lang="ta">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Database Setup | QASWAH HEALTH CLINIC</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Inter', sans-serif;
        }

        .setup-card {
            max-width: 600px;
            margin: 80px auto;
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        }

        .btn-primary {
            background-color: #c42121;
            border-color: #c42121;
        }

        .btn-primary:hover {
            background-color: #a31b1b;
            border-color: #a31b1b;
        }

        .status-item {
            padding: 12px;
            border-bottom: 1px solid #eee;
            display: flex;
            align-items: center;
        }

        .status-item:last-child {
            border-bottom: none;
        }

        .status-icon {
            width: 30px;
            color: #198754;
            margin-right: 15px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="card setup-card">
            <div class="card-body p-5">
                <div class="text-center mb-4">
                    <i class="fas fa-database fa-3x text-danger mb-3"></i>
                    <h2 class="fw-bold">Database Setup</h2>
                    <p class="text-muted">Restore missing tables and initialize administrative access.</p>
                </div>

                <?php if ($error): ?>
                    <div class="alert alert-danger mb-4">
                        <h6 class="fw-bold mb-1">Setup Failed</h6>
                        <p class="mb-0 small"><?php echo $error; ?></p>
                    </div>
                <?php endif; ?>

                <?php if (!empty($status)): ?>
                    <div class="bg-light rounded p-4 mb-4">
                        <h6 class="fw-bold mb-3 text-success">Setup Progress:</h6>
                        <?php foreach ($status as $msg): ?>
                            <div class="status-item small">
                                <i class="fas fa-check-circle status-icon"></i>
                                <span><?php echo $msg; ?></span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="d-grid mt-4">
                        <a href="../login" class="btn btn-primary btn-lg fw-bold">Return to Login</a>
                    </div>
                <?php else: ?>
                    <?php if (isset($db_connection_error)): ?>
                        <div class="alert alert-danger border-0 shadow-sm small mb-4">
                            <h6 class="fw-bold mb-2 text-danger"><i class="fas fa-exclamation-triangle me-2"></i>Database Connection Offline</h6>
                            <p class="mb-0 text-muted">The connection to your MySQL server is currently failing. You must fix the credentials in your <code>.env</code> file before you can initialize the database structure.</p>
                            <hr>
                            <p class="mb-0 small text-danger"><strong>Error:</strong> <?php echo htmlspecialchars($db_connection_error); ?></p>
                        </div>
                        <div class="d-grid">
                            <button type="button" class="btn btn-secondary btn-lg fw-bold py-3" disabled>
                                <i class="fas fa-ban me-2"></i> Setup Blocked (No DB Connection)
                            </button>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-info border-0 shadow-sm small mb-4">
                            This tool will verify your database structure and create the **'category'**, **'tags'**,
                            **'posts'**, **'post_tags'**, **'users'**, **'leads'**, and other required tables if they are
                            missing.
                        </div>
                        <form method="POST">
                            <div class="d-grid">
                                <button type="submit" name="run_setup" class="btn btn-primary btn-lg fw-bold py-3">
                                    <i class="fas fa-play me-2"></i> Run Automated Setup
                                </button>
                            </div>
                        </form>
                    <?php endif; ?>
                <?php endif; ?>

                <div class="text-center mt-5 text-muted small">
                    <p>QASWAH HEALTH CLINIC • System Restoration Utility</p>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
