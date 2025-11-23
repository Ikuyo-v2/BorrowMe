<?php
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$host = '127.0.0.1';
$user = 'root';
$pass = '';
$db   = 'borrowme';
$port = 3306;
$charset = 'utf8mb4';

try {
    $conn = new mysqli($host, $user, $pass, $db, $port);
    $conn->set_charset($charset);
} catch (mysqli_sql_exception $e) {
    error_log('DB connect error: ' . $e->getMessage());
    http_response_code(500);
    exit('Database connection error.');
}


function db(): mysqli {
    global $conn;
    return $conn;
}
?>