<?php
require_once 'dba.inc.php';
session_start();

// Check if the request method is POST and the ID is set
if (isset($_POST['deleteProd'])) {
    $productId = intval($_POST['productId']); // Sanitize input
    
    try {
        // Prepare the SQL statement
        $sql = "DELETE FROM productinfo WHERE productId = ?";
        $stmt = $conn->prepare($sql);

        $stmt->bind_param("i", $productId);
        if ($stmt->execute()) {
            // Redirect back to the product page with a success message
            header("Location: product.php?message=ProductDeletedSuccessfully");
        } else {
            throw new Exception("Failed to delete product: " . $stmt->error);
        }
        
        $stmt->close();
    } catch (Exception $e) {
        // Handle exceptions and redirect with an error message
        header("Location: product.php?error=" . urlencode($e->getMessage()));
    }
} else {
    // Redirect if the request is invalid
    header("Location: product.php?error=InvalidRequest");
}
exit;
?>
