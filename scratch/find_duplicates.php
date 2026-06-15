<?php
$files = glob(__DIR__ . '/../assets/img/gallery/img-*.jpeg');
$hashes = [];
$duplicates = [];

foreach ($files as $f) {
    $hash = md5_file($f);
    if (isset($hashes[$hash])) {
        $duplicates[] = [
            'original' => basename($hashes[$hash]),
            'duplicate' => basename($f)
        ];
    } else {
        $hashes[$hash] = $f;
    }
}

if (empty($duplicates)) {
    echo "No duplicate files found by MD5 hash.\n";
} else {
    echo "Duplicate files found:\n";
    foreach ($duplicates as $d) {
        echo "{$d['duplicate']} is a duplicate of {$d['original']}\n";
    }
}
?>
