<?php
require_once 'header.php';
require_once '../connection.php';
require_once 'functionsPages.inc.php';


if (isset($_SESSION['customerEmail'])) {
    $userEmail = $_SESSION['customerEmail'];
    $userId = getUserIdFromSession($conn, $userEmail);
    getCartFromDatabase($conn, $userId);
}

// Check if cart exists in cookies
if (isset($_COOKIE['cart'])) {
    $cart = json_decode($_COOKIE['cart'], true);
} else {
    $cart = [];
}

// Move cart data from cookie to the database if user is logged in
if (isset($_COOKIE['cart']) && isset($_SESSION['customerEmail'])) {
    saveCartToDatabase($conn, $userId);
}

// Default quantity (can be dynamically set from database/session)
$minQuantity = 1;
$maxQuantity = 10;

// Check if there's a cart cookie
if (isset($_COOKIE['cart'])) {
    // Decode the cart data from the cookie (assumes JSON encoding)
    $cart = json_decode($_COOKIE['cart'], true);

}

$finalTotal = 0;
$itemCount = 0;
$discountValue = 0;
$discountPercent = 0; // Will store the percent value (e.g., 10 for 10%)

foreach ($cart as $product) {
    $quantity = isset($product['quantity']) ? (int) $product['quantity'] : 1;
    $price = isset($product['price']) ? (float) $product['price'] : 0;
    $itemSubtotal = $quantity * $price;
    $finalTotal += $itemSubtotal;
    $itemCount += $quantity;

    // Optional: If each product has its own discount %
    if (isset($product['discount']) && $product['discount'] > 0) {
        $discountPercent = (float) $product['discount']; // Only uses the last one if multiple exist
    }
}

// You can also override this with a global discount (from cookie or DB)
if (isset($_COOKIE['discount'])) {
    $discountPercent = (float) $_COOKIE['discount']; // example from cookie
}

// Calculate discount value from percentage
if ($discountPercent > 0) {
    $discountValue = $finalTotal * ($discountPercent / 100);
}

$shipping = 150;
$totalAfterDiscount = $finalTotal - $discountValue;
$grandTotal = $totalAfterDiscount + $shipping;

?>

<!-- BANNER IMAGE -->
<div class="banner2">
    <img src="../images/banner2.jpg" alt="BLOOM BOUTIQUE">
    <h1 class="banner-title">YOUR CART</h1>
</div>

<!-- CART -->
<div class="main-cart">
    <div class="cart-main" id="cart-main-container">
        <div class="cart-title">
            <p>Product</p>
            <div class="right-title">
                <p>Price</p>
                <p>Quantity</p>
                <p>Sub Total</p>
            </div>
        </div>

        <?php
        if (isset($_SESSION['user_id'])):
            $userId = $_SESSION['user_id'];  // Get the user ID from the session
            $cart = getCartData($conn, $userId);
            ?>
            <!-- Display the cart items -->
            <?php if (!empty($cart)): ?>
                <?php foreach ($cart as $product):
                    $isCustom = !empty($product['custom_flower_id']);
                    ?>
                    <div class="name-categ">
                        <div class="cart-items">
                            <div class="x-name">
                                <div class="x-image">
                                    <button class="remove-item" onclick="removeFromCart(<?= $product['cart_id']; ?>)">
                                        <img src="../images/cart-delete.png" alt="">
                                    </button>

                                    <?php if ($isCustom): ?>
                                        <img src="../images/custom_flowers/<?= $product['custom_image']; ?>" alt="Custom Flower Image">
                                    <?php else: ?>
                                        <img src="<?= htmlspecialchars($product['product_image']); ?>" alt="Product Image">
                                    <?php endif; ?>

                                </div>
                                <div class="name-categ">
                                    <p class="cart-product-name">
                                        <?= $isCustom ? 'Custom Flower Arrangement' : htmlspecialchars($product['product_name']); ?>
                                    </p>
                                </div>
                            </div>
                            <div class="price-quan">
                                <?php
                                $quantity = isset($product['quantity']) ? (int) $product['quantity'] : 1;
                                $price = isset($product['product_price']) ? (float) $product['product_price'] : 0.00;
                                $discount = isset($product['product_discount']) ? (float) $product['product_discount'] : 0;
                                $hasDiscount = $discount > 0;

                                $discountedPrice = $hasDiscount ? $price - ($price * ($discount / 100)) : $price;
                                $subtotal = $discountedPrice * $quantity;
                                ?>

                                <!-- New Discounted Price Display -->
                                <p class="cat-new-price">
                                    <?php if (!empty($product['custom_flower_id'])): ?>
                                        ₱<?= number_format($product['price'], 2); ?>
                                    <?php else: ?>
                                        ₱<?= number_format($discountedPrice, 2); ?>
                                        <?php if ($hasDiscount): ?>
                                            <span class="cat-old-price">
                                                <del>₱<?= number_format($price, 2); ?></del>
                                            </span>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </p>

                                <!-- Quantity controls -->
                                <div class="quantity-selector">
                                    <div class="quantity-button minus"
                                        onclick="updateQuantity(<?= $product['cart_id'] ?>, 'decrease')">
                                        −
                                    </div>

                                    <div class="quantity-display" id="quantity">
                                        <?= $quantity; ?>
                                    </div>

                                    <div class="quantity-button plus"
                                        onclick="updateQuantity(<?= $product['cart_id'] ?>, 'increase')">+
                                    </div>
                                </div>

                                <!-- Subtotal -->
                                <p class="cart-sub-total">
                                    <?php if (!empty($product['custom_flower_id'])): ?>
                                        <?php $subtotal = $product['price'] * $quantity; ?>
                                        ₱<?= number_format($subtotal, 2); ?>
                                    <?php else: ?>
                                        ₱<?= number_format($subtotal, 2); ?>
                                    <?php endif; ?>
                                </p>
                            </div>
                        </div>
                        <?php $cartId = $product['cart_id']; ?>
                        <div class="message-tag" id="message-tag-<?= $cartId; ?>">
                            <p class="cart-product-message" id="message-text-<?= $cartId; ?>">
                                Card Message:
                                <?= htmlspecialchars($product['message']); ?>
                            </p>

                            <!-- Hidden input form -->
                            <div id="edit-form-<?= $cartId; ?>" class="editmessage" style="display: none;">
                                <textarea class="message-area"
                                    id="message-input-<?= $cartId; ?>"><?= isset($_COOKIE["message_{$cartId}"]) ? htmlspecialchars($_COOKIE["message_{$cartId}"]) : htmlspecialchars($product['message']); ?></textarea>
                                <button class="cart-edit" onclick="saveMessage(<?= $cartId; ?>)">Save</button>
                                <button class="cart-edit" onclick="cancelEdit(<?= $cartId; ?>)">Cancel</button>
                            </div>

                            <button onclick="editMessage(<?= $cartId; ?>)" class="cart-edit" id="editbutton">Edit Card
                                Message</button>
                        </div>
                    </div>
                <?php endforeach; ?>

                <div class="clear-all"><button onclick="clearCart()">Clear Shopping Cart</button></div>
            <?php else: ?>
                <div class="cart-empty">
                    <p>Your cart is currently empty.</p>
                    <br>
                    <img src="../images/emptyCart.png" alt="Empty Cart"
                        style="margin: 50px auto; width: auto; height: 200px; display: block;">
                    <br>
                    <a href="catalogue.php" class="clear-all">← Continue Shopping</a>
                </div>
            <?php endif; ?>

        <?php else: ?>
            <?php
            if (isset($_COOKIE['cart'])) {
                $cart = json_decode($_COOKIE['cart'], true);
            } else {
                $cart = [];
            }

            if (!empty($cart)): ?>
                <?php foreach ($cart as $productId => $product): ?>
                    <div class="name-categ">
                        <div class="cart-items">
                            <div class="x-name">
                                <div class="x-image">
                                    <button class="remove-item" onclick="removeFromCart(<?= $product['id'] ?>)">
                                        <img src="../images/cart-delete.png" alt="">
                                    </button>
                                    <img src="<?= htmlspecialchars($product['image']); ?>" alt="Product Image">
                                </div>
                                <div class="name-categ">
                                    <p class="cart-product-name"><?= htmlspecialchars($product['name']); ?></p>
                                </div>
                            </div>
                            <div class="price-quan">
                                <?php
                                $quantity = isset($product['quantity']) ? (int) $product['quantity'] : 1;
                                $price = isset($product['price']) ? (float) $product['price'] : 0.00;
                                $discount = isset($product['discount']) ? (float) $product['discount'] : 0;
                                $hasDiscount = $discount > 0;

                                $discountedPrice = $hasDiscount ? $price - ($price * ($discount / 100)) : $price;
                                $subtotal = $discountedPrice * $quantity;
                                ?>

                                <!-- New Discounted Price Display -->
                                <p class="cat-new-price">
                                    ₱<?= number_format($discountedPrice, 2); ?>
                                    <?php if ($hasDiscount): ?>
                                        <span class="cat-old-price">
                                            <del>₱<?= number_format($price, 2); ?></del>
                                        </span>
                                    <?php endif; ?>
                                </p>

                                <!-- Quantity controls -->
                                <div class="quantity-selector">
                                    <div class="quantity-button minus" onclick="updateQuantity(<?= $product['id'] ?>, 'decrease')">−
                                    </div>

                                    <div class="quantity-display" id="quantity">
                                        <?= $quantity; ?>
                                    </div>

                                    <div class="quantity-button plus" onclick="updateQuantity(<?= $product['id'] ?>, 'increase')">+
                                    </div>
                                </div>

                                <!-- Subtotal -->
                                <p class="cart-sub-total">
                                    ₱<?= number_format($subtotal, 2); ?>
                                </p>
                            </div>
                        </div>
                        <div class="message-tag" id="message-tag-<?= $product['id']; ?>">
                            <p class="cart-product-message" id="message-text-<?= $product['id']; ?>">
                                Card Message: <span id="message-display-<?= $product['id']; ?>">
                                    <?= isset($_COOKIE["message_{$product['id']}"]) ? htmlspecialchars($_COOKIE["message_{$product['id']}"]) : htmlspecialchars($product['message']); ?>
                                </span>
                            </p>

                            <!-- Hidden input form -->
                            <div id="edit-form-<?= $product['id']; ?>" style="display: none;">
                                <textarea class="message-area"
                                    id="message-input-<?= $product['id']; ?>"><?= isset($_COOKIE["message_{$product['id']}"]) ? htmlspecialchars($_COOKIE["message_{$product['id']}"]) : htmlspecialchars($product['message']); ?></textarea>
                                <button class="cart-edit" onclick="saveMessage(<?= $product['id']; ?>)">Save</button>
                                <button class="cart-edit" onclick="cancelEdit(<?= $product['id']; ?>)">Cancel</button>
                            </div>

                            <button class="cart-edit" id="editbutton" onclick="editMessage(<?= $product['id']; ?>)">Edit Card
                                Message</button>
                        </div>
                    </div>
                <?php endforeach; ?>
                <div class="clear-all"><button onclick="clearCart()">Clear Shopping Cart</button></div>
            <?php else: ?>
                <div class="cart-empty">
                    <p>Your cart is currently empty.</p>
                    <a href="catalogue.php" class="clear-all">← Continue Shopping</a>
                </div>
            <?php endif; ?>
        <?php endif; ?>

    </div>

    <!-- ORDER SUMMARY -->
    <div class="cart-order-summary">
        <div class="cart-summary-container">
            <div class="cart-order-name">
                <h4>Order Summary</h4>
            </div>
            <hr class="gray">

            <?php
            $finalTotalBeforeDiscount = 0;
            $finalTotal = 0;
            $itemCount = 0;
            $totalDiscountValue = 0;
            $shipping = 150;

            // Check if the user is logged in
            if (isset($_SESSION['customerEmail'])) {
                // If the user is logged in, get the cart from the database
                $userId = $_SESSION['user_id'];
                $query = "SELECT c.*, p.* 
                      FROM cart c 
                      JOIN products p ON c.product_id = p.product_id 
                      WHERE c.user_id = ? AND c.custom_flower_id IS NULL";
                $stmt = $conn->prepare($query);
                $stmt->bind_param('i', $userId);
                $stmt->execute();
                $result = $stmt->get_result();

                // Loop through the cart items
                while ($row = $result->fetch_assoc()) {
                    $quantity = (int) $row['quantity'];
                    $price = (float) $row['product_price'];
                    $discount = (float) $row['product_discount'];
                    $discountedPrice = $price - ($price * ($discount / 100));
                    $itemSubtotalBefore = $price * $quantity;
                    $itemSubtotalAfter = $discountedPrice * $quantity;
                    $itemDiscountValue = $itemSubtotalBefore - $itemSubtotalAfter;

                    $finalTotalBeforeDiscount += $itemSubtotalBefore;
                    $finalTotal += $itemSubtotalAfter;
                    $totalDiscountValue += $itemDiscountValue;
                    $itemCount += $quantity;
                    ?>

                    <div class="cart-summary-details">
                        <p><?= htmlspecialchars($row['product_name']); ?> × <?= $quantity; ?></p>
                        <p class="items2">₱<?= number_format($itemSubtotalAfter, 2); ?></p>
                    </div>

                <?php }
                // Fetch custom flower items
                $queryCustom = "SELECT c.*, cf.*
                                FROM cart c 
                                JOIN customflowers cf ON c.custom_flower_id = cf.id 
                                WHERE c.user_id = ? AND c.custom_flower_id IS NOT NULL";
                $stmtCustom = $conn->prepare($queryCustom);
                $stmtCustom->bind_param('i', $userId);
                $stmtCustom->execute();
                $resultCustom = $stmtCustom->get_result();

                while ($row = $resultCustom->fetch_assoc()) {
                    $quantity = (int) $row['quantity'];
                    $price = (float) $row['price'];
                    $itemSubtotal = $price * $quantity;

                    $finalTotalBeforeDiscount += $itemSubtotal;
                    $finalTotal += $itemSubtotal;
                    $itemCount += $quantity;
                    ?>

                    <div class="cart-summary-details">
                        <p> Custom Flower Arrangement × <?= $quantity; ?></p>
                        <p class="items2">₱<?= number_format($itemSubtotal, 2); ?></p>
                    </div>
                <?php } ?>

            <?php } else {
                // If the user is not logged in, get the cart data from the cookies
                if (isset($_COOKIE['cart'])) {
                    $cart = json_decode($_COOKIE['cart'], true);
                } else {
                    $cart = [];
                }

                // Loop through the cart items
                foreach ($cart as $productId => $product) {
                    $quantity = isset($product['quantity']) ? (int) $product['quantity'] : 1;
                    $price = isset($product['price']) ? (float) $product['price'] : 0;
                    $discount = isset($product['discount']) ? (float) $product['discount'] : 0;
                    $discountedPrice = $price - ($price * ($discount / 100));
                    $itemSubtotalBefore = $price * $quantity;
                    $itemSubtotalAfter = $discountedPrice * $quantity;
                    $itemDiscountValue = $itemSubtotalBefore - $itemSubtotalAfter;

                    $finalTotalBeforeDiscount += $itemSubtotalBefore;
                    $finalTotal += $itemSubtotalAfter;
                    $totalDiscountValue += $itemDiscountValue;
                    $itemCount += $quantity;
                    ?>

                    <div class="cart-summary-details">
                        <p><?= htmlspecialchars($product['name']); ?> × <?= $quantity; ?></p>
                        <p class="items2">₱<?= number_format($itemSubtotalAfter, 2); ?></p>
                    </div>

                <?php }
            }
            ?>

            <hr class="gray">

            <!-- Discount row -->
            <?php if ($totalDiscountValue > 0): ?>
                <div class="cart-summary-details">
                    <p>Discount</p>
                    <p class="items2">−₱<?= number_format($totalDiscountValue, 2); ?></p>
                </div>
            <?php endif; ?>

            <div class="cart-summary-details">
                <p>Items</p>
                <p class="items2"><?= $itemCount; ?></p>
            </div>

            <div class="cart-summary-details">
                <p>Sub Total</p>
                <p class="items2">₱<?= number_format($finalTotal, 2); ?></p>
            </div>

            <div class="cart-summary-details">
                <p>Shipping</p>
                <p class="items2">₱<?= number_format($shipping, 2); ?></p>
            </div>

            <hr class="gray">

            <div class="cart-summary-details">
                <p><strong>Total</strong></p>
                <p class="items2"><strong>₱<?= number_format($finalTotal + $shipping, 2); ?></strong></p>
            </div>
            <br>

            <!-- Proceed to checkout (Payment) -->
            <?php if (isset($_SESSION['customerEmail'])): ?>
                <!-- User is logged in: proceed with normal form -->
                <form action="billing.php" method="POST">
                    <div class="cart-proceed">
                        <button type="submit" name="cart-proceed-payment" class="cart-proceed-button">
                            Proceed to Payment
                        </button>
                    </div>
                </form>
            <?php else: ?>
                <!-- User not logged in: redirect to login with /tocart -->
                <a href="../account/login.php?redirect=tocart" class="cart-proceed-button" style="text-decoration: none;">
                    <div class="cart-proceed">
                        <button type="submit" class="cart-proceed-button">
                            Login to Checkout
                        </button>
                    </div>
                </a>
            <?php endif; ?>

        </div>
    </div>

</div>

<script>
    function getCookie(name) {
        const value = `; ${document.cookie}`;
        const parts = value.split(`; ${name}=`);
        if (parts.length === 2) {
            try {
                return decodeURIComponent(parts.pop().split(';').shift()); // decode safely
            } catch (e) {
                console.error("Error decoding cookie:", e);
                return null;
            }
        }
        return null;
    }

    function setCookie(name, value, days) {
        const d = new Date();
        d.setTime(d.getTime() + (days * 24 * 60 * 60 * 1000));
        const expires = "expires=" + d.toUTCString();
        document.cookie = `${name}=${encodeURIComponent(value)};${expires};path=/`;
    }

    function isLoggedIn() {
        return <?php echo isset($_SESSION['customerEmail']) ? 'true' : 'false'; ?>;
    }

    function removeFromCart(cartId) {
        // Check if the user is logged in
        if (isLoggedIn()) {
            // Send AJAX request to remove the product from the DB (logged-in user)
            fetch('removeFromCart.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ cartId: cartId })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        console.log("Product removed from cart (DB)");
                        location.reload(); // Reload to update the cart view
                    } else {
                        console.error("Error removing product from cart:", data.message);
                    }
                })
                .catch(error => console.error("Error:", error));
        } else {
            // Handle cookie-based cart removal for non-logged-in users
            let rawCart = getCookie('cart');
            if (!rawCart) return;

            try {
                let cartObject = JSON.parse(rawCart);
                let cartArray = Object.values(cartObject); // ✅ convert to array

                // remove by ID
                cartArray = cartArray.filter(product => parseInt(product.cartId || product.id) !== cartId);

                // Save it back as an object if needed
                let newCart = {};
                cartArray.forEach((item, index) => newCart[index] = item);

                setCookie('cart', JSON.stringify(newCart), 7);
                console.log("Removed product:", cartId);
                location.reload();
            } catch (e) {
                console.error("Error parsing cart JSON:", e, rawCart);
            }
        }
    }

    function updateQuantity(cartId, action) {
        // Check if the user is logged in
        if (isLoggedIn()) {
            // Send AJAX request to update the quantity in the DB (logged-in user)
            fetch('updateQuantity.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    cartId: cartId,  // Pass cartId instead of productId
                    action: action
                })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        console.log("Product quantity updated (DB)");
                        location.reload(); // Reload to update the cart view
                    } else {
                        console.error("Error updating quantity:", data.message);
                    }
                })
                .catch(error => console.error("Error:", error));
        } else {
            // Handle cookie-based quantity update for non-logged-in users
            let rawCart = getCookie('cart');
            if (!rawCart) return;

            try {
                let cartObject = JSON.parse(rawCart);
                let cartArray = Object.values(cartObject); // Convert to array

                // Find the item by cart_id
                const item = cartArray.find(product => parseInt(product.cart_id || product.id) === cartId);

                if (item) {
                    // Update quantity based on action ('increase' or 'decrease')
                    if (action === 'increase' && item.quantity < 10) {
                        item.quantity++;  // Increment quantity
                    } else if (action === 'decrease' && item.quantity > 1) {
                        item.quantity--;  // Decrement quantity
                    }

                    // Save the updated cart back to the cookie
                    let newCart = {};
                    cartArray.forEach((item, index) => newCart[index] = item);
                    setCookie('cart', JSON.stringify(newCart), 7);  // Save the updated cart in cookies
                    console.log("Updated quantity in cookie:", cartId);
                    location.reload();  // Reload to update the cart view
                }
            } catch (e) {
                console.error("Error parsing cart JSON:", e);
            }
        }
    }

    function clearCart() {
        // Check if the user is logged in
        if (isLoggedIn()) {
            // Send AJAX request to clear the cart in the DB (logged-in user)
            fetch('clearCart.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        console.log("Cart cleared (DB)");
                        location.reload(); // Reload to update the cart view
                    } else {
                        console.error("Error clearing cart:", data.message);
                    }
                })
                .catch(error => console.error("Error:", error));
        } else {
            // Handle cookie-based cart clearing
            setCookie('cart', JSON.stringify([]), 7);
            location.reload(); // Reload to update the cart view
        }
    }

    function updateMessage(productId, newMessage) {
        if (isLoggedIn()) {
            // Logged-in: update the message in the database
            fetch('updateMessage.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    productId: productId,
                    message: newMessage
                })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        console.log("Message updated in database.");
                        location.reload(); // or update the UI directly
                    } else {
                        console.error("Error updating message:", data.message);
                    }
                })
                .catch(error => console.error("Error:", error));
        } else {
            // Guest user: update message in cart cookie
            let rawCart = getCookie('cart');
            if (!rawCart) return;

            try {
                let cartObject = JSON.parse(rawCart);
                let cartArray = Object.values(cartObject);

                // Find the item by productId (or cart_id if you have that)
                const item = cartArray.find(product => parseInt(product.cart_id || product.id) === productId);

                if (item) {
                    item.message = newMessage;

                    // Save updated cart to cookie
                    let newCart = {};
                    cartArray.forEach((item, index) => newCart[index] = item);
                    setCookie('cart', JSON.stringify(newCart), 7); // 7 days expiry

                    console.log("Message updated in cookie for product:", productId);
                    location.reload();
                }
            } catch (e) {
                console.error("Error updating message in cookie:", e);
            }
        }

    }

    function editMessage(id) {
        document.getElementById(`edit-form-${id}`).style.display = 'block';
        document.getElementById(`editbutton`).style.display = 'none';
        document.getElementById(`message-text-${id}`).style.display = 'none';
    }

    function cancelEdit(id) {
        document.getElementById(`edit-form-${id}`).style.display = 'none';
        document.getElementById(`editbutton`).style.display = 'block';
        document.getElementById(`message-text-${id}`).style.display = 'block';
    }

    function saveMessage(productId) {
        const textarea = document.getElementById('message-input-' + productId);
        const message = textarea.value.trim();
        updateMessage(productId, message);
    }
</script>
<?php include_once 'footer.php'; ?>