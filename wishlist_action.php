<?php
session_start();
require_once 'database.php';

if (!isset($_SESSION['user_name'])) {
    http_response_code(403);
    echo json_encode(['error' => 'Not logged in']);
    exit();
}

$conn = db();

$user_table = preg_replace('[^a-zA-Z0-9_]', '_', $_SESSION['user_name']);

$table_check_query = "SHOW TABLES LIKE '" . $conn->real_escape_string($user_table) . "'";
$result = $conn->query($table_check_query);

if ($result->num_rows === 0) {
    $create_table_query = "CREATE TABLE `$user_table` (
        id INT AUTO_INCREMENT PRIMARY KEY,
        book_id INT NOT NULL,
        quantity INT NOT NULL DEFAULT 1,
        date_added TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
    $conn->query($create_table_query);
}

$action = $_POST['action'] ?? '';

if ($action === 'update') {
    $book_id = isset($_POST['book_id']) ? (int)$_POST['book_id'] : 0;
    $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;

    if ($book_id <= 0 || $quantity <= 0) {
        http_response_code(400);
        echo json_encode(['error' => 'Invalid parameters']);
        exit();
    }

    // Update quantity if entry exists
    $update_query = "UPDATE `$user_table` SET quantity = ? WHERE book_id = ?";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param("ii", $quantity, $book_id);
    $stmt->execute();

    if ($stmt->affected_rows === 0) {
        // Insert new if no rows updated
        $insert_query = "INSERT INTO `$user_table` (book_id, quantity) VALUES (?, ?)";
        $stmt = $conn->prepare($insert_query);
        $stmt->bind_param("ii", $book_id, $quantity);
        $stmt->execute();
    }

    echo json_encode(['success' => true]);
    exit();

} elseif ($action === 'remove') {
    $book_id = isset($_POST['book_id']) ? (int)$_POST['book_id'] : 0;

    if ($book_id <= 0) {
        http_response_code(400);
        echo json_encode(['error' => 'Invalid parameters']);
        exit();
    }

    $delete_query = "DELETE FROM `$user_table` WHERE book_id = ?";
    $stmt = $conn->prepare($delete_query);
    $stmt->bind_param("i", $book_id);
    $stmt->execute();

    echo json_encode(['success' => true]);
    exit();

} else {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid action']);
    exit();
}
?>
