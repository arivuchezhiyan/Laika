<?php
$files = glob(__DIR__ . '/../assets/img/gallery/img-*.jpeg');
$hashes = [];

foreach ($files as $f) {
    $img = imagecreatefromjpeg($f);
    if (!$img) continue;
    $thumb = imagecreatetruecolor(8, 8);
    imagecopyresampled($thumb, $img, 0, 0, 0, 0, 8, 8, imagesx($img), imagesy($img));
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
    $hashes[basename($f)] = $hash;
}

$checked = [];
foreach ($hashes as $f1 => $h1) {
    foreach ($hashes as $f2 => $h2) {
        if ($f1 === $f2) continue;
        $pair = [$f1, $f2];
        sort($pair);
        $pairKey = implode(',', $pair);
        if (in_array($pairKey, $checked)) continue;
        $checked[] = $pairKey;
        
        $diff = 0;
        for ($i = 0; $i < 128; $i += 2) {
            $v1 = hexdec(substr($h1, $i, 2));
            $v2 = hexdec(substr($h2, $i, 2));
            $diff += abs($v1 - $v2);
        }
        $avg = $diff / 64;
        if ($avg < 35) {
            echo "$f1 and $f2: avg diff = $avg\n";
        }
    }
}
?>
