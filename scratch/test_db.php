<?php
require_once 'user-admin/secure/db_connect.php';
if (isset($conn) && !$conn->connect_error) {
    echo "DB Connection SUCCESS\n";
    $res = $conn->query("SELECT COUNT(*) as cnt FROM posts");
    if ($res) {
        $row = $res->fetch_assoc();
        echo "Total posts in database: " . $row['cnt'] . "\n";
        
        $posts_res = $conn->query("SELECT p.*, c.category_name, c.category_slug FROM posts p LEFT JOIN category c ON p.category_id = c.category_id WHERE p.post_status = 'published' ORDER BY p.created_at DESC LIMIT 3");
        if ($posts_res) {
            while ($row = $posts_res->fetch_assoc()) {
                echo "Post: " . $row['post_title'] . " | Slug: " . $row['post_slug'] . "\n";
            }
        }
    } else {
        echo "Error querying posts: " . $conn->error . "\n";
    }
} else {
    echo "DB Connection FAILED\n";
    if (isset($db_connection_error)) {
        echo "Error details: " . $db_connection_error . "\n";
    }
}
