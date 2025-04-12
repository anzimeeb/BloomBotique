<?php
session_start();

if (!isset($_SESSION['employeeUsername'])) {
    header("location:admin-login.php");
    exit();
}

require_once 'dba.inc.php';

if (isset($_POST["submitProduct"])) {

    // Get all form values
    $productName = $_POST["product_name"];
    $productDescription = $_POST["product_description"];
    $productPrice = $_POST["product_price"];
    $productCategory = $_POST["product_category"];
    $productColor = $_POST["product_color"];
    $productDiscount = $_POST["product_discount"];
    $productBestseller = $_POST["product_bestseller"];
    $productStock = $_POST["product_stock"];
    $productStatus = $_POST["product_status"];

    $targetDir = "../images/products/";
    $file = $_FILES['product_image'];
    $fileName = basename($file['name']);
    $fileTmpName = $file['tmp_name'];
    $fileSize = $file['size'];
    $fileError = $file['error'];
    $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

    $allowed = array('jpg', 'jpeg', 'png');

    $productImagePath = null;

    if (!empty($fileName)) {
        if (in_array($fileExt, $allowed)) {
            if ($fileError === 0) {
                if ($fileSize < 1000000) {
                    $uniqueName = uniqid('prod_', true) . '.' . $fileExt;
                    $productImagePath = $targetDir . $uniqueName;

                    if (!move_uploaded_file($fileTmpName, $productImagePath)) {
                        echo "❌ Failed to upload image.";
                        exit();
                    }
                } else {
                    echo "❌ Your file is too big!";
                    exit();
                }
            } else {
                echo "❌ Error uploading file!";
                exit();
            }
        } else {
            echo "❌ Invalid file type!";
            exit();
        }
    }

    // Insert into products table
    $stmt = $conn->prepare("
        INSERT INTO products 
        (product_name, product_description, product_price, product_discount, product_category, product_color, product_bestseller, product_stock, product_status, product_image)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
    ");

    $stmt->bind_param(
        "ssddssiiis",
        $productName,
        $productDescription,
        $productPrice,
        $productDiscount,
        $productCategory,
        $productColor,
        $productBestseller,
        $productStock,
        $productStatus,
        $productImagePath
    );

    if ($stmt->execute()) {
        header("Location: product.php?success=1");
        exit();
    } else {
        echo "❌ Failed to save product. Error: " . $stmt->error;
        exit();
    }

} else {
    header("location:admin-login.php?error=unauthorized");
    exit();
}
