<?php
// router.php
// 1. Redirect .php URLs to extensionless URLs (301 Move Permanently)
$path = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
if (preg_match('/\.php$/i', $path) && is_file(__DIR__ . $path)) {
    $target = preg_replace('/\.php$/i', '', $path);
    $query = parse_url($_SERVER["REQUEST_URI"], PHP_URL_QUERY);
    if ($query) {
        $target .= '?' . $query;
    }
    header("Location: $target", true, 301);
    exit();
}

// 2. Blog Rule
if (preg_match('/^\/blog\/([a-zA-Z0-9-]+)$/', $path, $matches)) {
    $_GET['slug'] = $matches[1];
    require 'blog-details.php';
    return true;
}



// 3. Handle Clean URLs (Extensionless -> .php)
if (!file_exists(__DIR__ . $path)) {
    $php_file = __DIR__ . $path . '.php';
    if (file_exists($php_file)) {
        require $php_file;
        return true;
    }
}

// 4. Default: Serve static files or index.php
return false;
