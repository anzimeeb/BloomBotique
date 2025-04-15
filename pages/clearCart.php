<?php
session_start();
require_once '../connection.php';  // Include your DB connection

if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];

    // Prepare query to delete all items from the user's cart
    $query = "DELETE FROM cart WHERE user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $userId);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to clear the cart']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
}
?>
