<?php
/**
 * Doctor Helpers for AB Eye Institute
 */

/**
 * Handles uploading a doctor image.
 * 
 * @param array $file The $_FILES entry for the image.
 * @return array [string|null $path, string|null $error]
 */
function handle_doctor_image_upload($file) {
    if (empty($file['name']) || $file['error'] !== UPLOAD_ERR_OK) {
        return [null, null]; // No file uploaded or upload error
    }

    $allowed_exts = ['jpg', 'jpeg', 'png', 'webp', 'php']; // php is definitely not an allowed ext, wait I should allow standard images only.
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
    $filename = uniqid('doc_', true) . '.' . $file_ext;
    
    // Target directory (relative to index.php)
    // The images should be stored in root/assets/images/team/
    $target_dir = __DIR__ . '/../../assets/images/team/';
    
    // Create directory if it doesn't exist
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0755, true);
    }

    $target_path = $target_dir . $filename;

    if (move_uploaded_file($file['tmp_name'], $target_path)) {
        return ['assets/images/team/' . $filename, null];
    } else {
        return [null, "Failed to move uploaded file."];
    }
}
