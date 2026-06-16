<?php
require_once 'user-admin/secure/db_connect.php';
if (isset($conn) && !$conn->connect_error) {
    $res = $conn->query("SELECT post_id, post_title, post_slug, image_path, post_status FROM posts");
    if ($res) {
        while ($row = $res->fetch_assoc()) {
            echo "ID: " . $row['post_id'] . "\n";
            echo "Title: " . $row['post_title'] . "\n";
            echo "Slug: " . $row['post_slug'] . "\n";
            echo "Image Path: " . $row['image_path'] . "\n";
            echo "Status: " . $row['post_status'] . "\n";
            echo "---------------------------------\n";
        }
    } else {
        echo "Error: " . $conn->error . "\n";
    }
}
