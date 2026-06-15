<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    $isHttps = !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off';
    session_set_cookie_params([
        'httponly' => true,
        'samesite' => 'Lax',
        'secure' => $isHttps,
    ]);
    session_start();
}

function require_login() {
    if (empty($_SESSION['admin_logged_in'])) {
        header('Location: login');
        exit;
    }
}

function csrf_token() {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }

    return $_SESSION['csrf_token'];
}

function verify_csrf_token($token) {
    return !empty($token) && !empty($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

/**
 * Syncs the current session data with the database to ensure
 * display names and roles are always up to date.
 */
function sync_user_session($conn) {
    if (!empty($_SESSION['user_id']) && $conn instanceof mysqli && empty($conn->connect_error)) {
        $id = $_SESSION['user_id'];
        $stmt = $conn->prepare("SELECT username, email, role FROM users WHERE id = ?");
        if ($stmt) {
            $stmt->bind_param("i", $id);
            if ($stmt->execute()) {
                $res = $stmt->get_result();
                if ($user = $res->fetch_assoc()) {
                    $_SESSION['username'] = $user['username'];
                    $_SESSION['role'] = $user['role'];
                    $_SESSION['email'] = $user['email'];
                }
            }
            $stmt->close();
        }
    }
}
?>
