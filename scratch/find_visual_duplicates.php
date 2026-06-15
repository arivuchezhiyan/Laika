<?php
$files = glob(__DIR__ . '/../assets/img/gallery/img-*.jpeg');
$hashes = [];
$duplicates = [];

foreach ($files as $f) {
    $img = imagecreatefromjpeg($f);
    if (!$img) continue;
    
    // Resize to 8x8
    $thumb = imagecreatetruecolor(8, 8);
    imagecopyresampled($thumb, $img, 0, 0, 0, 0, 8, 8, imagesx($img), imagesy($img));
    
    // Grayscale and hash
    $hash = '';
    for ($y = 0; $y < 8; $y++) {
        for ($x = 0; $x < 8; $x++) {
            $rgb = imagecolorat($thumb, $x, $y);
            $r = ($rgb >> 16) & 0xFF;
            $g = ($rgb >> 8) & 0xFF;
            $b = $rgb & 0xFF;
            $gray = round(($r + $g + $b) / 3);
            $hash .= str_pad(dechex($gray), 2, '0', STR_PAD_LEFT);
        }
    }
    
    imagedestroy($img);
    imagedestroy($thumb);
    
    // Find visual match
    $matched = false;
    foreach ($hashes as $prev_f => $prev_hash) {
        // Compute difference
        $diff = 0;
        for ($i = 0; $i < 128; $i += 2) {
            $v1 = hexdec(substr($hash, $i, 2));
            $v2 = hexdec(substr($prev_hash, $i, 2));
            $diff += abs($v1 - $v2);
        }
        
        // If average difference per pixel is very low, they are visual duplicates
        if ($diff < 64 * 8) {
            $duplicates[] = [
                'original' => basename($prev_f),
                'duplicate' => basename($f)
            ];
            $matched = true;
            break;
        }
    }
    
    if (!$matched) {
        $hashes[$f] = $hash;
    }
}

if (empty($duplicates)) {
    echo "No visual duplicates found.\n";
} else {
    echo "Visual duplicates found:\n";
    foreach ($duplicates as $d) {
        echo "{$d['duplicate']} is a visual duplicate of {$d['original']}\n";
    }
}
?>
