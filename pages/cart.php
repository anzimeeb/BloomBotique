<?php
    require_once 'header.php';
?>

<?php
    // Default quantity (can be dynamically set from database/session)
    $initialQuantity = 1; 
    $minQuantity = 1; // Minimum allowed quantity
    $maxQuantity = 10; // Maximum allowed quantity
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
    <link rel="icon" href="images/logob.png">
    <link rel="stylesheet" href="../style.css">
</head>

<!-- BANNER IMAGE  -->
<div class="banner2">
    <img src="../images/banner2.jpg" alt="BLOOM BOUTIQUE">
    <h1 class="banner-title">YOUR CART</h1>
</div>

<!-- CART -->
<div class="main-cart"><!-- MAIN -->
<div class="cart-main" id="cart-main-container"><!-- left side -->
    <div class="cart-title"><!-- cart title -->
        <p>Product</p>

        <div class="right-title">
            <p>Price</p>
            <p>Quantity</p>
            <p>Sub Total</p>
        </div>
    </div><!-- end cart title -->


    <div class="cart-items"><!-- cart items -->
        <div class="x-name"><!-- image and name -->
        <div class="x-image"><!-- remove and image -->
            <button class="remove-item"><img src="../images/cart-delete.png" alt=""></button>
            <img src="../images/catalogue/earths_embrace.png" alt="Product Image">
        </div><!-- end remove and image -->

        <div class="name-categ"><!-- name and category -->
            <p class="cart-product-name">Earth's Embrace</p>
            <p class="cart-category">Wedding</p>
        </div><!-- endname and category -->
        </div><!-- end image and name -->

        <div class="price-quan"><!-- price, quantity, sub-total -->
            <p class="cart-price">₱750.00</p>

        <div class="quantity-selector">
            <div class="quantity-button minus" id="decrement">−</div>
            <div class="quantity-display" id="quantity"><?php echo $initialQuantity; ?></div>
            <div class="quantity-button plus" id="increment">+</div>
        </div>

        <form id="quantity-form" method="post" action="process_order.php">
            <input type="hidden" id="quantity-input" name="quantity" value="<?php echo $initialQuantity; ?>">
            <!-- Other form fields would go here -->
        </form>

            <p class="cart-sub-total">₱750.00</p>
        </div><!-- end price, quantity, sub-total -->
    </div><!-- end cart items -->

    <div class="cart-items"><!-- cart items -->
        <div class="x-name"><!-- image and name -->
        <div class="x-image"><!-- remove and image -->
            <button class="remove-item"><img src="../images/cart-delete.png" alt=""></button>
            <img src="../images/catalogue/lavender_love.png" alt="Product Image">
        </div><!-- end remove and image -->

        <div class="name-categ"><!-- name and category -->
            <p class="cart-product-name">Lavender Love</p>
            <p class="cart-category">Burial</p>
        </div><!-- endname and category -->
        </div><!-- end image and name -->

        <div class="price-quan"><!-- price, quantity, sub-total -->
            <p class="cart-price">₱750.00</p>

        <div class="quantity-selector">
            <div class="quantity-button minus" id="decrement">−</div>
            <div class="quantity-display" id="quantity"><?php echo $initialQuantity; ?></div>
            <div class="quantity-button plus" id="increment">+</div>
        </div>

        <form id="quantity-form" method="post" action="process_order.php">
            <input type="hidden" id="quantity-input" name="quantity" value="<?php echo $initialQuantity; ?>">
            <!-- Other form fields would go here -->
        </form>

            <p class="cart-sub-total">₱750.00</p>
        </div><!-- end price, quantity, sub-total -->
    </div><!-- end cart items -->

    <div class="cart-items"><!-- cart items -->
        <div class="x-name"><!-- image and name -->
        <div class="x-image"><!-- remove and image -->
            <button class="remove-item"><img src="../images/cart-delete.png" alt=""></button>
            <img src="../images/catalogue/celestial_bloom.png" alt="Product Image">
        </div><!-- end remove and image -->

        <div class="name-categ"><!-- name and category -->
            <p class="cart-product-name">Celestial Bloom</p>
            <p class="cart-category">Graduation</p>
        </div><!-- endname and category -->
        </div><!-- end image and name -->

        <div class="price-quan"><!-- price, quantity, sub-total -->
            <p class="cart-price">₱750.00</p>

        <div class="quantity-selector">
            <div class="quantity-button minus" id="decrement">−</div>
            <div class="quantity-display" id="quantity"><?php echo $initialQuantity; ?></div>
            <div class="quantity-button plus" id="increment">+</div>
        </div>

        <form id="quantity-form" method="post" action="process_order.php">
            <input type="hidden" id="quantity-input" name="quantity" value="<?php echo $initialQuantity; ?>">
            <!-- Other form fields would go here -->
        </form>

            <p class="cart-sub-total">₱750.00</p>
        </div><!-- end price, quantity, sub-total -->
    </div><!-- end cart items -->

    <div class="cart-items"><!-- cart items -->
        <div class="x-name"><!-- image and name -->
        <div class="x-image"><!-- remove and image -->
            <button class="remove-item"><img src="../images/cart-delete.png" alt=""></button>
            <img src="../images/catalogue/sweet_serenade.png" alt="Product Image">
        </div><!-- end remove and image -->

        <div class="name-categ"><!-- name and category -->
            <p class="cart-product-name">Sweet Serenade</p>
            <p class="cart-category">Birthday</p>
        </div><!-- endname and category -->
        </div><!-- end image and name -->

        <div class="price-quan"><!-- price, quantity, sub-total -->
            <p class="cart-price">₱750.00</p>

        <div class="quantity-selector">
            <div class="quantity-button minus" id="decrement">−</div>
            <div class="quantity-display" id="quantity"><?php echo $initialQuantity; ?></div>
            <div class="quantity-button plus" id="increment">+</div>
        </div>

        <form id="quantity-form" method="post" action="process_order.php">
            <input type="hidden" id="quantity-input" name="quantity" value="<?php echo $initialQuantity; ?>">
            <!-- Other form fields would go here -->
        </form>

            <p class="cart-sub-total">₱750.00</p>
        </div><!-- end price, quantity, sub-total -->
    </div><!-- end cart items -->

    <div class="clear-all"><button>Clear Shopping Cart</button></div>
</div><!-- end left side -->



<!-- ORDER SUMMARY -->
<div class="cart-order-summary"><!-- right side -->
    <div class="cart-summary-container"><!-- summary container -->
        <div class="cart-order-name">
            <h4>Order Summary</h4>
        </div>
        <hr class="gray">

        <div class="cart-summary-details">
            <p>Items</p>
            <p class="items2">4</p>
        </div>

        <div class="cart-summary-details">
            <p>Sub Total</p>
            <p class="items2">$3,000</p>
        </div>

        <div class="cart-summary-details">
            <p>Shipping</p>
            <p class="items2">$150</p>
        </div>
        <hr class="gray">

        <div class="cart-summary-details">
            <p>Total</p>
            <p class="items2">$3,150</p>
        </div>

        <br>
        
        <form action="billing.php" method="POST">
        <div class="cart-proceed">
            <button type="submit" name="cart-proceed-payment" class="cart-proceed-button">Proceed to Payment</button>
        </div>
        </form>
        <br>
    </div><!-- end summary container -->
</div><!-- end right side -->
<!-- END ORDER SUMMARY -->

</div><!-- END MAIN -->

<script>
            document.addEventListener('DOMContentLoaded', function() {
                const decrementBtn = document.getElementById('decrement');
                const incrementBtn = document.getElementById('increment');
                const quantityDisplay = document.getElementById('quantity');
                const quantityInput = document.getElementById('quantity-input');
                
                const minQuantity = <?php echo $minQuantity; ?>;
                const maxQuantity = <?php echo $maxQuantity; ?>;
                let currentQuantity = <?php echo $initialQuantity; ?>;
                
                // Initial state check for min/max limits
                updateButtonStates();
                
                // Decrement button handler
                decrementBtn.addEventListener('click', function() {
                    if (currentQuantity > minQuantity) {
                        currentQuantity--;
                        updateQuantity();
                    }
                });
                
                // Increment button handler
                incrementBtn.addEventListener('click', function() {
                    if (currentQuantity < maxQuantity) {
                        currentQuantity++;
                        updateQuantity();
                    }
                });
                
                // Update quantity display and hidden form input
                function updateQuantity() {
                    quantityDisplay.textContent = currentQuantity;
                    quantityInput.value = currentQuantity;
                    updateButtonStates();
                    
                    // Optional: Make an AJAX call to update cart without page refresh
                    // updateCartAjax(currentQuantity);
                }
                
                // Update button states based on current quantity
                function updateButtonStates() {
                    // Disable decrement if at minimum
                    if (currentQuantity <= minQuantity) {
                        decrementBtn.classList.add('disabled');
                    } else {
                        decrementBtn.classList.remove('disabled');
                    }
                    
                    // Disable increment if at maximum
                    if (currentQuantity >= maxQuantity) {
                        incrementBtn.classList.add('disabled');
                    } else {
                        incrementBtn.classList.remove('disabled');
                    }
                }
                
                // Optional: AJAX function to update cart in real-time
                function updateCartAjax(quantity) {
                    // Example AJAX call using fetch API
                    fetch('update_cart.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: 'product_id=<?php echo isset($product_id) ? $product_id : ""; ?>&quantity=' + quantity
                    })
                    .then(response => response.json())
                    .then(data => {
                        // Handle response - update price, subtotal, etc.
                        console.log('Cart updated:', data);
                    })
                    .catch(error => {
                        console.error('Error updating cart:', error);
                    });
                }
            });
        </script>

<?php include_once'footer.php';?>

