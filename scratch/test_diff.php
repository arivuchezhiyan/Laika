<?php
$f1 = __DIR__ . '/../assets/img/gallery/img-13.jpeg';
$f2 = __DIR__ . '/../assets/img/gallery/img-19.jpeg';

function getHash($f) {
    $img = imagecreatefromjpeg($f);
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
    return $hash;
}

$h1 = getHash($f1);
$h2 = getHash($f2);

$diff = 0;
for ($i = 0; $i < 128; $i += 2) {
    $v1 = hexdec(substr($h1, $i, 2));
    $v2 = hexdec(substr($h2, $i, 2));
    $diff += abs($v1 - $v2);
}
echo "Diff: $diff, avg per pixel: " . ($diff / 64) . "\n";
?>
