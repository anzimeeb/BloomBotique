<?php
// Include database connection
include '../admin/dba.inc.php';

// Check if the updateProduct button was clicked
if (isset($_POST['updateProduct'])) {
    // Collect and sanitize input data
    $productId = mysqli_real_escape_string($conn, $_POST['product_id']); // Match 'product_id'
    $productName = mysqli_real_escape_string($conn, $_POST['productName']); // Match 'productName'
    $productDescription = mysqli_real_escape_string($conn, $_POST['productDescription']); // Match 'productDescription'
    $productPrice = mysqli_real_escape_string($conn, $_POST['productPrice']); // Match 'productPrice'
    $productCategory = mysqli_real_escape_string($conn, $_POST['productCategory']); // Match 'productCategory'
    $productColor = mysqli_real_escape_string($conn, $_POST['productColor']); // Match 'productColor'
    $productBestseller = mysqli_real_escape_string($conn, $_POST['productBestseller']); // Checkbox for bestseller, match 'productBestseller'
    $productDiscount = mysqli_real_escape_string($conn, $_POST['productDiscount']); // Match 'productDiscount'
    $productStatus = mysqli_real_escape_string($conn, $_POST['productStatus']); // Match 'productStatus'
    $productStock = mysqli_real_escape_string($conn, $_POST['productStock']); // Match 'productStock'

    // Handle file upload
    $productImage = $_FILES['product_image']['name']; // Match 'product_image' in the form
    $tempImage = $_FILES['product_image']['tmp_name']; // Match 'product_image' in the form
    $uploadDir = "../uploads/"; // Directory to save uploaded images
    $uploadFile = $uploadDir . basename($productImage);

    // Build the SQL query
    if (!empty($productImage)) {
        // If a new image is uploaded, update all fields including the image
        if (move_uploaded_file($tempImage, $uploadFile)) {
            $query = "UPDATE products SET 
                product_name = '$productName',
                product_description = '$productDescription',
                product_price = '$productPrice',
                product_category = '$productCategory',
                product_color = '$productColor',
                product_bestseller = '$productBestseller',
                product_discount = '$productDiscount',
                product_status = '$productStatus',
                product_stock = '$productStock',
                product_image = '$productImage'
                WHERE product_id = '$productId'";
        } else {
            echo "Error uploading the image.";
            exit;
        }
    } else {
        // If no new image is uploaded, update other fields only
        $query = "UPDATE products SET 
            product_name = '$productName',
            product_description = '$productDescription',
            product_price = '$productPrice',
            product_category = '$productCategory',
            product_color = '$productColor',
            product_bestseller = '$productBestseller',
            product_discount = '$productDiscount',
            product_status = '$productStatus',
            product_stock = '$productStock'
            WHERE product_id = '$productId'";
    }

    // Execute the query
    if (mysqli_query($conn, $query)) {
        // Redirect with success message
        header("Location: product.php?message=success");
        exit;
    } else {
        echo "Error updating product: " . mysqli_error($conn);
    }
} else {
    // Redirect back if accessed directly
    header("Location: product.php");
    exit;
}

?>
