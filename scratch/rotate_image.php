<?php
$source_file = __DIR__ . '/../assets/img/gallery/img-23.jpeg';
if (file_exists($source_file)) {
    $source = imagecreatefromjpeg($source_file);
    if ($source) {
        // Rotate 90 degrees counter-clockwise = 270 degrees clockwise in PHP
        $rotate = imagerotate($source, 270, 0);
        if ($rotate) {
            imagejpeg($rotate, $source_file, 95);
            imagedestroy($rotate);
            echo "Image img-23.jpeg rotated successfully by 90 degrees counter-clockwise.\n";
        } else {
            echo "Failed to rotate image.\n";
        }
        imagedestroy($source);
    } else {
        echo "Failed to load image.\n";
    }
} else {
    echo "Source file does not exist.\n";
}
?>
