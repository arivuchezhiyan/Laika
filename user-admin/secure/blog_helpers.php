<?php
/**
 * Blog Helpers for AB Eye Institute
 * Provides helper functions for blog posts, images, and URL generation.
 */

/**
 * Resolves the display path for a blog image.
 * 
 * @param string $path The stored path in the database.
 * @return string The web-accessible path relative to the site root.
 */
function resolve_blog_image_path($path) {
    if (empty($path)) {
        return 'assets/images/blog/blog1.png';
    }
    // If the path is already full (contains assets/), return as is
    if (strpos($path, 'assets/') === 0) {
        return $path;
    }
    // Otherwise, assume it's in assets/images/blog/
    return 'assets/images/blog/' . ltrim($path, '/');
}

/**
 * Handles uploading a blog featured image.
 * 
 * @param array $file The $_FILES entry for the image.
 * @return array [string|null $path, string|null $error]
 */
function handle_blog_image_upload($file) {
    if (empty($file['name']) || $file['error'] !== UPLOAD_ERR_OK) {
        return [null, null]; // No file uploaded or upload error
    }

    $allowed_exts = ['jpg', 'jpeg', 'png', 'webp'];
    $file_ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

    if (!in_array($file_ext, $allowed_exts)) {
        return [null, "Invalid image format. Allowed: JPG, PNG, WEBP."];
    }

    // Limit file size (5MB)
    if ($file['size'] > 5 * 1024 * 1024) {
        return [null, "Image size too large. Max 5MB allowed."];
    }

    // Create unique filename
    $filename = uniqid('blog_', true) . '.' . $file_ext;
    
    // Target directory (relative to index.php)
    // Note: This script runs from user-admin/ creating/editing blogs.
    // The images should be stored in root/assets/images/blog/
    $target_dir = __DIR__ . '/../../assets/images/blog/';
    
    // Create directory if it doesn't exist
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0755, true);
    }

    $target_path = $target_dir . $filename;

    if (move_uploaded_file($file['tmp_name'], $target_path)) {
        return ['assets/images/blog/' . $filename, null];
    } else {
        return [null, "Failed to move uploaded file."];
    }
}

/**
 * Generates a unique URL slug for a post.
 * 
 * @param mysqli $conn The database connection.
 * @param string $title The post title.
 * @param string $table The table name.
 * @param string $column The slug column name.
 * @param int|null $exclude_id ID to exclude (for updates).
 * @return string The unique slug.
 */
function build_slug($conn, $title, $table, $column, $exclude_id = null) {
    $slug = strtolower(preg_replace('/[^A-Za-z0-9-]+/', '-', $title));
    $slug = trim($slug, '-');
    $original_slug = $slug;
    
    $i = 1;
    while (true) {
        $sql = "SELECT count(*) as count FROM $table WHERE $column = ?";
        
        // Define primary key column name based on table (heuristic)
        $id_col = ($table === 'posts') ? 'post_id' : (($table === 'category') ? 'category_id' : (($table === 'jobs') ? 'job_id' : 'id'));
        
        if ($exclude_id !== null) {
            $sql .= " AND $id_col != ?";
            $stmt = $conn->prepare($sql);
            if ($stmt === false) {
                error_log("Prepare failed: " . $conn->error);
                return $original_slug . '-' . time(); // Fallback to unique slug
            }
            $stmt->bind_param("si", $slug, $exclude_id);
        } else {
            $stmt = $conn->prepare($sql);
            if ($stmt === false) {
                error_log("Prepare failed: " . $conn->error);
                return $original_slug . '-' . time(); // Fallback to unique slug
            }
            $stmt->bind_param("s", $slug);
        }
        
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result === false) {
             return $original_slug . '-' . time();
        }
        $row = $result->fetch_assoc();
        
        if ($row['count'] == 0) {
            return $slug;
        }
        
        $slug = $original_slug . '-' . ($i++);
    }
}

/**
 * Normalizes a category ID for database entry.
 * 
 * @param mysqli $conn The database connection.
 * @param mixed $id The category ID.
 * @return int|null
 */
function normalize_category_id($conn, $id) {
    $id = intval($id);
    if ($id <= 0) return null;
    return $id;
}

/**
 * Transforms a standard YouTube URL into an embed URL.
 * Supports: youtube.com/watch?v=ID, youtu.be/ID, youtube.com/embed/ID
 * 
 * @param string $url The YouTube URL.
 * @return string The embeddable URL.
 */
function get_youtube_embed_url($url) {
    if (empty($url)) return '';

    // If it's a full iframe tag, extract the src
    if (preg_match('/<iframe.*?src=["\'](.*?)["\']/', $url, $matches)) {
        $url = $matches[1];
    }

    // If it's already an embed URL, return it
    if (strpos($url, 'youtube.com/embed/') !== false) {
        return $url;
    }
    
    $video_id = '';
    
    if (preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?|shorts)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $url, $matches)) {
        $video_id = $matches[1];
    }
    
    if ($video_id) {
        return 'https://www.youtube.com/embed/' . $video_id;
    }
    
    return $url; // Return original if no ID found
}
