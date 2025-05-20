<?php
require_once 'header.php';
require_once '../connection.php';

// Redirect to cart if no items in session cart or user not logged in
if (!isset($_SESSION['customerEmail']) || !isset($_SESSION['user_id'])) {
    header("Location: ../cart.php");
    exit();
}

// Optional: check cart table directly to ensure it's not empty
$userId = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT COUNT(*) FROM cart WHERE user_id = ?");
$stmt->bind_param('i', $userId);
$stmt->execute();
$stmt->bind_result($cartCount);
$stmt->fetch();
$stmt->close();

if ($cartCount === 0) {
    header("Location: cart.php");
    exit();
}
?>

<!-- BANNER IMAGE -->
<div class="banner2">
    <img src="../images/banner2.jpg" alt="BLOOM BOUTIQUE">
    <h1 class="banner-title">BILLING</h1>
</div>

<!-- BILLING -->
<form action="billing.inc.php" method="POST">
    <section class="billing-main"><!-- main -->
        <div class="billing-container" id="billing-form1"><!-- left side -->
            <h3>Billing Details</h3>
            <div id="billing-info">
                <div class="bill-input-grp">
                    <label for="firstname">First Name</label>
                    <input type="text" name="firstname" required>
                </div>
                <br>

                <div class="bill-input-grp">
                    <label for="lastname">Last Name</label>
                    <input type="text" name="lastname">
                </div>
            </div>

            <div>
                <label class="billing-label">Street Address</label>
                <input type="text" name="streetadd" required>
                <br>

                <label class="billing-label">City</label>
                <input type="text" name="city" required>
                <br>

                <label class="billing-label">State</label>
                <input type="text" name="state" required>
                <br>

                <label class="billing-label">Zip Code</label>
                <input type="text" name="zipcode" required>
                <br>

                <label class="billing-label">Phone</label>
                <input type="text" name="bill-phone" required>
                <br>

                <label class="billing-label">Email</label>
                <input type="text" name="bill-email" required>
                <br>

                <label class="billing-label">Mode of Payment</label>
                <div class="payment-options">
                    <div class="form-check payment-card">
                        <input class="form-check-input" type="radio" name="paymentMethod" id="cod" checked value="cod">
                        <label class="form-check-label" for="cod">
                            Cash on Delivery
                        </label>
                    </div>
                </div>
            </div>
        </div><!-- end left side -->

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

                if (isset($_SESSION['customerEmail'])) {
                    $userId = $_SESSION['user_id'];
                    $query = "SELECT c.*, p.* 
                              FROM cart c 
                              JOIN products p ON c.product_id = p.product_id 
                              WHERE c.user_id = ?";
                    $stmt = $conn->prepare($query);
                    $stmt->bind_param('i', $userId);
                    $stmt->execute();
                    $result = $stmt->get_result();

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
                    <?php }
                } ?>

                <hr class="gray">

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

                <!-- HIDDEN TOTAL FIELD TO SEND TO BACKEND -->
                <input type="hidden" name="total" value="<?= $finalTotal + $shipping; ?>">
                <input type="hidden" name="discount_amount" value="<?= $totalDiscountValue; ?>">

                <br>

                <!-- Proceed to checkout (Payment) -->
                <div class="cart-proceed">
                    <button type="submit" name="placedorder" class="cart-proceed-button">
                        Place Order
                    </button>
                </div>
            </div>
        </div>
    </section>
</form>

<?php include_once 'footer.php'; ?>