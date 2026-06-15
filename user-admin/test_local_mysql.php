<?php
/**
 * Local MySQL Connection Finder & Database Creator
 */

$credentials = [
    ['host' => '127.0.0.1', 'user' => 'root', 'pass' => ''],
    ['host' => '127.0.0.1', 'user' => 'root', 'pass' => 'root'],
    ['host' => '127.0.0.1', 'user' => 'root', 'pass' => 'admin'],
    ['host' => '127.0.0.1', 'user' => 'root', 'pass' => '123456'],
    ['host' => '127.0.0.1', 'user' => 'root', 'pass' => '12345678'],
    ['host' => '127.0.0.1', 'user' => 'root', 'pass' => 'password']
];

$success = false;
foreach ($credentials as $cred) {
    mysqli_report(MYSQLI_REPORT_OFF);
    $conn = @new mysqli($cred['host'], $cred['user'], $cred['pass']);
    if ($conn && !$conn->connect_error) {
        echo "CONNECT_SUCCESS:Host=" . $cred['host'] . "|User=" . $cred['user'] . "|Pass=" . $cred['pass'] . "\n";
        
        // Try creating the database u305588601_qaswah
        if ($conn->query("CREATE DATABASE IF NOT EXISTS u305588601_qaswah")) {
            echo "DATABASE_CREATED:u305588601_qaswah\n";
            $success = true;
        } else {
            echo "DATABASE_ERROR:" . $conn->error . "\n";
        }
        
        $conn->close();
        break;
    }
}

if (!$success) {
    echo "CONNECT_FAILURE:Could not connect to local MySQL with common credentials.\n";
}
