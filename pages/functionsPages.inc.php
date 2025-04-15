<?php

function addToCart($conn, $userId, $productId, $customFlowerId = null, $quantity, $message = null)
{
    // Check if the product already exists in the cart for the user
    if ($customFlowerId === null) {
        $query = "SELECT * FROM cart WHERE user_id = ? AND product_id = ? AND custom_flower_id IS NULL";
    } else {
        $query = "SELECT * FROM cart WHERE user_id = ? AND product_id = ? AND custom_flower_id = ?";
    }

    $stmt = $conn->prepare($query);
    if ($stmt === false) {
        die('Error in preparing statement: ' . $conn->error);
    }

    // Bind the parameters for the query
    if ($customFlowerId === null) {
        $stmt->bind_param('ii', $userId, $productId);
    } else {
        $stmt->bind_param('iii', $userId, $productId, $customFlowerId);
    }

    // Execute the statement
    $stmt->execute();
    $result = $stmt->get_result();

    // If the product already exists, update the quantity and message
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $newQuantity = $row['quantity'] + $quantity;
        $updateQuery = "UPDATE cart SET quantity = ? WHERE id = ?";
        $updateStmt = $conn->prepare($updateQuery);
        $updateStmt->bind_param('ii', $newQuantity, $row['id']);
        $updateStmt->execute();
    } else {
        // If the product doesn't exist, insert a new row into the cart
        $insertQuery = "INSERT INTO cart (user_id, product_id, custom_flower_id, quantity, message) VALUES (?, ?, ?, ?, ?)";
        $insertStmt = $conn->prepare($insertQuery);
        $insertStmt->bind_param('iiiis', $userId, $productId, $customFlowerId, $quantity, $message);
        $insertStmt->execute();
    }
}

function getCartData($conn, $userId)
{
    // Query to fetch cart items along with product details from the products table
    $query = "
        SELECT c.id as cart_id, c.user_id, c.product_id, c.quantity, c.message, p.product_name, p.product_price, p.product_image, p.product_discount
        FROM cart c 
        JOIN products p ON c.product_id = p.product_id 
        WHERE c.user_id = ?";

    // Prepare and execute the query
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    $cart = [];
    while ($row = $result->fetch_assoc()) {
        $cart[] = $row;  // Store each cart item along with product details
    }

    return $cart;  // Return the cart data
}

function getUserIdFromSession($conn, $email)
{
    // Check if customerEmail exists in the session
    if (isset($_SESSION['customerEmail'])) {
        // Query the database to get the user ID corresponding to the email
        $query = "SELECT id FROM customerinfo WHERE customerEmail = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('s', $email);  // Bind the email parameter to the query
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if a user was found
        if ($result->num_rows > 0) {
            // Fetch the user ID
            $user = $result->fetch_assoc();
            $userId = $user['id'];

            // Store the user ID in the session for easier access later
            $_SESSION['user_id'] = $userId;

            return $userId;  // Return the user ID
        } else {
            return null;  // User not found
        }
    } else {
        return null;  // No customerEmail in session
    }
}

function saveCartToDatabase($conn, $userId)
{
    // Check if the cart exists in the cookie and the user is logged in
    if (isset($_COOKIE['cart']) && isset($userId)) {
        // Decode the cart from the cookie
        $cart = json_decode($_COOKIE['cart'], true);

        // Loop through the cart items
        foreach ($cart as $product) {
            $productId = $product['id'];
            $customFlowerId = isset($product['custom_flower_id']) ? $product['custom_flower_id'] : null;
            $quantity = $product['quantity'];
            $message = $product['message'];

            // Call the addToCart function to insert the data into the database
            addToCart($conn, $userId, $productId, $customFlowerId, $quantity, $message);
        }

        // Clear the cart cookie after saving to the database (optional)
        setcookie('cart', '', time() - 3600, '/'); // Expire the cookie

        return "Your cart has been saved to the database.";
    } else {
        return "No cart data found or user is not logged in.";
    }
}

function getCartFromDatabase($conn, $userId)
{
    // Query to retrieve cart items for the logged-in user
    $query = "SELECT * FROM cart WHERE user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $userId);  // Bind the user ID to the query
    $stmt->execute();
    $result = $stmt->get_result();

    // Store each cart item in an array
    $cart = [];
    while ($row = $result->fetch_assoc()) {
        $cart[] = $row;
    }

    return $cart;  // Return the cart data
}

function updateCartMessagesFromCookies($conn, $userId) {
    foreach ($_COOKIE as $key => $value) {
        if (strpos($key, 'message_') === 0) {
            $productId = str_replace('message_', '', $key);
            $message = $value;

            $query = "UPDATE cart SET message = ? WHERE user_id = ? AND product_id = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param('sii', $message, $userId, $productId);
            $stmt->execute();
        }
    }
}

function placeOrder($conn, $userId, $postData) {
    // Start transaction
    $conn->begin_transaction();

    try {
        // Insert into orders
        $stmt = $conn->prepare("INSERT INTO orders 
            (user_id, firstname, lastname, street_address, city, state, zipcode, phone, email, payment_method, total_amount, discount_amount) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        if (!$stmt) {
            throw new Exception("Prepare failed for order insert: " . $conn->error);
        }

        $stmt->bind_param(
            'isssssssssdd',
            $userId,
            $postData['firstname'],
            $postData['lastname'],
            $postData['streetadd'],
            $postData['city'],
            $postData['state'],
            $postData['zipcode'],
            $postData['bill-phone'],
            $postData['bill-email'],
            $postData['paymentMethod'],
            $postData['total'],
            $postData['discount_amount']
        );

        if (!$stmt->execute()) {
            throw new Exception("Execute failed for order insert: " . $stmt->error);
        }

        $orderId = $stmt->insert_id;
        $stmt->close();

        // Fetch cart items
        $query = "SELECT c.*, p.* FROM cart c JOIN products p ON c.product_id = p.product_id WHERE c.user_id = ?";
        $stmt = $conn->prepare($query);
        if (!$stmt) {
            throw new Exception("Prepare failed for cart query: " . $conn->error);
        }

        $stmt->bind_param('i', $userId);
        if (!$stmt->execute()) {
            throw new Exception("Execute failed for cart query: " . $stmt->error);
        }

        $result = $stmt->get_result();

        // Insert order items
        while ($row = $result->fetch_assoc()) {
            $quantity = (int)$row['quantity'];
            $price = (float)$row['product_price'];
            $discount = (float)$row['product_discount'];
            $message = $row['message'] ?? null;

            $itemStmt = $conn->prepare("INSERT INTO order_items 
                (order_id, product_id, quantity, price, discount, message) 
                VALUES (?, ?, ?, ?, ?, ?)");
            if (!$itemStmt) {
                throw new Exception("Prepare failed for order items: " . $conn->error);
            }

            $itemStmt->bind_param(
                'iiidds',
                $orderId,
                $row['product_id'],
                $quantity,
                $price,
                $discount,
                $message
            );

            if (!$itemStmt->execute()) {
                throw new Exception("Execute failed for order item insert: " . $itemStmt->error);
            }

            $itemStmt->close();
        }

        $stmt->close();

        // Clear the cart
        $clearCart = $conn->prepare("DELETE FROM cart WHERE user_id = ?");
        if (!$clearCart) {
            throw new Exception("Prepare failed for cart clear: " . $conn->error);
        }

        $clearCart->bind_param('i', $userId);
        if (!$clearCart->execute()) {
            throw new Exception("Execute failed for cart clear: " . $clearCart->error);
        }
        $clearCart->close();

        // Commit transaction
        $conn->commit();

        session_start();
        $_SESSION["last_order_id"] = $orderId;
        header("Location: placedOrder.php?order_id=" . $orderId);
        exit();
    } catch (Exception $e) {
        // Rollback on failure
        $conn->rollback();

        // Optional: log this error somewhere
        error_log("Order placement error: " . $e->getMessage());

        // ❌ Redirect to error page or show a user-friendly message
        header("Location: error.php?message=" . urlencode("Something went wrong while placing your order."));
        exit();
    }
}


?>