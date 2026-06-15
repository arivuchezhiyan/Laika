<?php
require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$db_connection_error = null;
try {
    // Disable exceptions to handle errors manually if preferred, or use try-catch
    mysqli_report(MYSQLI_REPORT_OFF);
    
    $conn = @new mysqli($_ENV['DB_HOST'], $_ENV['DB_USER'], $_ENV['DB_PASS'], $_ENV['DB_NAME']);
    
    if ($conn->connect_error) {
        $db_connection_error = $conn->connect_error;
        // Show error for debugging
        echo "<div style='background: #fff5f5; color: #c53030; padding: 15px; border: 1px solid #feb2b2; margin: 10px; border-radius: 8px;'>";
        echo "<strong>Database Connection Failed:</strong> " . $db_connection_error;
        echo "</div>";
    } else {
        $conn->set_charset('utf8mb4');
    }
} catch (Exception $e) {
    $db_connection_error = $e->getMessage();
}
?>
