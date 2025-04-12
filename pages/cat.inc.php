<?php

    if (isset($_GET['catalogue_product.php'])) {
        $productId = $_GET['product_id'];
    
        // Query to fetch product details based on the product name
        $query = "SELECT * FROM product_catalogue WHERE product_id = '$productId'";
        $all_product = $conn->query($sql);
    
        if ($all_product && mysqli_num_rows($all_product) > 0) {
            $product = mysqli_fetch_assoc($all_product);
            // Extract product details
            $productImage = $product['product_image'];
            $productName = $product['product_name'];
            $productDescription = $product['product_description'];
            $productPrice = $product['new_price'];
        }
    }
?>