<?php
session_start();
require_once '../connection.php';  // Include your DB connection

// Decode the incoming JSON data
$data = json_decode(file_get_contents('php://input'), true);  // Decode the JSON into an associative array

if (isset($_SESSION['user_id']) && isset($data['cartId']) && isset($data['action'])) {
    $userId = $_SESSION['user_id'];
    $cartId = $data['cartId'];  // Get the cartId from the JSON data
    $action = $data['action'];

    // Get the current quantity based on cart_id
    $query = "SELECT quantity FROM cart WHERE user_id = ? AND id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('ii', $userId, $cartId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $currentQuantity = $row['quantity'];

        // Update quantity based on action
        if ($action == 'increase') {
            $newQuantity = min($currentQuantity + 1, 10);  // Limit max quantity to 10
        } else if ($action == 'decrease') {
            $newQuantity = max($currentQuantity - 1, 1);  // Limit min quantity to 1
        }

        // Update the quantity in the cart
        $updateQuery = "UPDATE cart SET quantity = ? WHERE user_id = ? AND id = ?";
        $updateStmt = $conn->prepare($updateQuery);
        $updateStmt->bind_param('iii', $newQuantity, $userId, $cartId);

        if ($updateStmt->execute()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to update quantity']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Product not found in cart']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
}
?>
