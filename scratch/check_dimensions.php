<?php
$files = glob('../assets/img/banner/*.*');
if (empty($files)) {
    $files = glob('assets/img/banner/*.*');
}
foreach ($files as $file) {
    if (in_array(pathinfo($file, PATHINFO_EXTENSION), ['png', 'jpg', 'jpeg', 'gif', 'webp'])) {
        $size = getimagesize($file);
        if ($size) {
            echo basename($file) . ": " . $size[0] . "x" . $size[1] . " (" . $size['mime'] . ")\n";
        }
    }
}
