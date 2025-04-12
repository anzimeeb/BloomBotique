<?php
// Default quantity (can be dynamically set from database/session)
$initialQuantity = 1; 
$minQuantity = 1; // Minimum allowed quantity
$maxQuantity = 10; // Maximum allowed quantity (optional)
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quantity Selector</title>
    <style>
        .quantity-selector {
            display: flex;
            align-items: center;
            border: 2px solid #333;
            border-radius: 50px;
            width: 150px;
            height: 45px;
            overflow: hidden;
            font-family: Arial, sans-serif;
        }
        
        .quantity-button {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100%;
            cursor: pointer;
            user-select: none;
            font-size: 20px;
            color: #333;
            transition: background-color 0.2s;
        }
        
        .quantity-button:hover {
            background-color: #f0f0f0;
        }
        
        .quantity-display {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100%;
            font-size: 18px;
            font-weight: bold;
            border-left: 1px solid #333;
            border-right: 1px solid #333;
        }
        
        .disabled {
            opacity: 0.3;
            cursor: not-allowed;
        }
    </style>
</head>
<body>

<!-- Quantity Selector UI Component -->
<div class="quantity-selector">
    <div class="quantity-button minus" id="decrement">−</div>
    <div class="quantity-display" id="quantity"><?php echo $initialQuantity; ?></div>
    <div class="quantity-button plus" id="increment">+</div>
</div>

<form id="quantity-form" method="post" action="process_order.php">
    <input type="hidden" id="quantity-input" name="quantity" value="<?php echo $initialQuantity; ?>">
    <!-- Other form fields would go here -->
</form>

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

</body>
</html>