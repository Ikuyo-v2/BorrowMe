<?php
require_once __DIR__ . '/database.php';
try {
    $conn = db();
    $res = $conn->query('SHOW TABLES');
    echo 'Connected. Tables:<br>';
    while ($row = $res->fetch_row()) {
        echo htmlspecialchars($row[0]) . '<br>';
    }
} catch (Throwable $e) {
    // This should not reveal details to users; check the PHP error log for full message
    echo 'Connection test failed. Check PHP error log.';
}