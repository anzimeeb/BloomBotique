<?php
// Include database connection
include '../admin/dba.inc.php';

// Check if the updateProduct button was clicked
if (isset($_POST['updateProduct'])) {
    // Collect and sanitize input data
    $productId = mysqli_real_escape_string($conn, $_POST['productId']);
    $productName = mysqli_real_escape_string($conn, $_POST['productName']);
    $productDescription = mysqli_real_escape_string($conn, $_POST['productDescription']);
    $productPrice = mysqli_real_escape_string($conn, $_POST['productPrice']);
    $productCategory = mysqli_real_escape_string($conn, $_POST['productCategory']);

    // Handle file upload
    $productImage = $_FILES['productImage']['name']; // Original file name
    $tempImage = $_FILES['productImage']['tmp_name']; // Temporary file name
    $uploadDir = "../uploads/"; // Directory to save uploaded images
    $uploadFile = $uploadDir . basename($productImage);

    // Build the SQL query
    if (!empty($productImage)) {
        // If a new image is uploaded, update all fields including the image
        if (move_uploaded_file($tempImage, $uploadFile)) {
            $query = "UPDATE productinfo SET 
                productName = '$productName',
                productDescription = '$productDescription',
                productPrice = '$productPrice',
                productCategory = '$productCategory',
                productImage = '$productImage'
                WHERE productId = '$productId'";
        } else {
            echo "Error uploading the image.";
            exit;
        }
    } else {
        // If no new image is uploaded, update other fields only
        $query = "UPDATE productinfo SET 
            productName = '$productName',
            productDescription = '$productDescription',
            productPrice = '$productPrice',
            productCategory = '$productCategory'
            WHERE productId = '$productId'";
    }

    // Execute the query
    if (mysqli_query($conn, $query)) {
        // Redirect with success message
        header("Location:product.php?message=success");
        exit;
    } else {
        echo "Error updating product: " . mysqli_error($conn);
    }
} else {
    // Redirect back if accessed directly
    header("Location:product.php");
    exit;
}
?>
