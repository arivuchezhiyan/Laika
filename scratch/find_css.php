<?php
$content = file_get_contents('assets/css/main.css');
$lines = explode("\n", $content);
$found = false;
$count = 0;
foreach ($lines as $i => $line) {
    if (trim($line) === '.btn {') {
        $found = true;
        $count = 0;
    }
    if ($found) {
        echo ($i + 1) . ": " . trim($line) . "\n";
        $count++;
        if ($count > 30) {
            $found = false;
        }
    }
}
