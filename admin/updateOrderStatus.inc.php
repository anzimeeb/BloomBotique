<?php
require_once 'dba.inc.php'; // Include the database connection

// Check if the request is valid
if (isset($_POST['order_id']) && isset($_POST['order_status'])) {
    $orderId = intval($_POST['order_id']);
    $orderStatus = $_POST['order_status']; // The status is a string, not an integer

    // Prepare the SQL statement to update the order status
    $sql = "UPDATE orders SET order_status = ? WHERE order_id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("si", $orderStatus, $orderId);
        if ($stmt->execute()) {
            echo "Order status updated successfully";
        } else {
            echo "Error updating order status";
        }
    } else {
        echo "Failed to prepare the statement";
    }
} else {
    echo "Invalid request";
}
?>
