<?php
require_once 'dba.inc.php'; // Include the database connection

// Check if the request is valid
if (isset($_POST['orderId']) && isset($_POST['orderStatus'])) {
    $orderId = intval($_POST['orderId']);
    $orderStatus = $_POST['orderStatus']; // The status is a string, not an integer

    // Prepare the SQL statement to update the order status
    $sql = "UPDATE orders SET orderStatus = ? WHERE orderId = ?";
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
