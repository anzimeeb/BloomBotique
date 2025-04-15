<?php
session_start();
require_once '../connection.php';  // Include your DB connection

// Decode the incoming JSON data
$data = json_decode(file_get_contents('php://input'), true);  // Decode the JSON into an associative array

// Debugging the incoming data
file_put_contents('php://stderr', print_r($data, true));  // Log incoming data for debugging

if (isset($_SESSION['user_id']) && isset($data['productId']) && isset($data['message'])) {
    $userId = $_SESSION['user_id'];
    $cartId = $data['productId'];  // Get the cartId from the JSON data
    $message = $data['message'];

    // Update the message in the cart
    $updateQuery = "UPDATE cart SET message = ? WHERE user_id = ? AND id = ?";
    $updateStmt = $conn->prepare($updateQuery);
    $updateStmt->bind_param('sii', $message, $userId, $cartId);

    if ($updateStmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to update message']);
    }
} else {
    // Log the failed conditions for debugging
    $errorMessage = [];
    if (!isset($_SESSION['user_id'])) {
        $errorMessage[] = 'User not logged in';
    }
    if (!isset($data['productId'])) {
        $errorMessage[] = 'Cart ID missing';
    }
    if (!isset($data['message'])) {
        $errorMessage[] = 'Message missing';
    }
    echo json_encode(['success' => false, 'message' => 'Invalid request', 'details' => $errorMessage]);
}
?>
