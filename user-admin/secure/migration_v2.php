<?php
require_once __DIR__ . '/../../includes/db.php';

$queries = [
    "CREATE TABLE IF NOT EXISTS videos (
        id INT AUTO_INCREMENT PRIMARY KEY,
        title VARCHAR(255) NOT NULL,
        video_url VARCHAR(255) NOT NULL,
        label VARCHAR(100),
        status ENUM('active', 'inactive') DEFAULT 'active',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )",
    "CREATE TABLE IF NOT EXISTS testimonials (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        designation VARCHAR(255),
        content TEXT NOT NULL,
        rating INT DEFAULT 5,
        image_path VARCHAR(255),
        status ENUM('active', 'inactive') DEFAULT 'active',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )"
];

foreach ($queries as $sql) {
    if ($conn->query($sql)) {
        echo "Successfully executed query.\n";
    } else {
        echo "Error: " . $conn->error . "\n";
    }
}
?>
