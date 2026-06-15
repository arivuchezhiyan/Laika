<?php
$files = glob(__DIR__ . '/../assets/img/gallery/img-*.jpeg');
foreach($files as $f) {
    $name = basename($f);
    $size = getimagesize($f);
    $width = $size[0];
    $height = $size[1];
    $orientation = "None";
    
    // Read EXIF
    if (function_exists('exif_read_data')) {
        $exif = @exif_read_data($f);
        if (isset($exif['Orientation'])) {
            $orientation = $exif['Orientation'];
        }
    }
    echo "$name: size={$width}x{$height}, orientation=$orientation\n";
}
?>
