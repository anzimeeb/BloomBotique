<?php
session_start();  // Start the session
require_once '../connection.php';  // Include the database connection
require_once 'functionsPages.inc.php';

// Get the raw POST data
$data = json_decode(file_get_contents('php://input'), true);  // Decode the JSON into an associative array

if (isset($_SESSION['user_id']) && isset($data['cartId'])) {
    $userId = $_SESSION['user_id'];
    $cartId = (int) $data['cartId'];  // Ensure cartId is treated as an integer

    // Prepare the query to delete the product from the cart in the database
    $query = "DELETE FROM cart WHERE user_id = ? AND id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('ii', $userId, $cartId);  // Bind the userId and cartId

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);  // Return success message
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to remove product']);
    }
} else {
    // If either user_id or cartId is missing
    echo json_encode(['success' => false, 'message' => 'User not logged in or cart ID missing']);
}
?>
