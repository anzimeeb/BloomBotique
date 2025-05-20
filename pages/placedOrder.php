<?php
require_once 'header.php';
require_once '../connection.php';

// Redirect if no order session
if (!isset($_SESSION['last_order_id'])) {
    header("Location: billing.php");
    exit;
}

// unset($_SESSION['last_order_id']); // Remove after showing

$orderId = $_SESSION['last_order_id'];

// Get order details
$stmt = $conn->prepare("SELECT * FROM orders WHERE order_id = ?");
$stmt->bind_param('i', $orderId);
$stmt->execute();
$order = $stmt->get_result()->fetch_assoc();

// Get order items
$stmt = $conn->prepare("
    SELECT 
        oi.*, 
        p.product_name AS product_name, 
        p.product_image AS product_image,
        cf.size AS custom_size, 
        cf.custom_image AS custom_image
    FROM order_items oi 
    LEFT JOIN products p ON oi.product_id = p.product_id 
    LEFT JOIN customflowers cf ON oi.custom_flower_id = cf.id 
    WHERE oi.order_id = ?
");

$stmt->bind_param('i', $orderId);
$stmt->execute();
$items = $stmt->get_result();

// Estimate delivery date
$createdDate = new DateTime($order['created_at']);
$deliveryDate = $createdDate->modify('+7 days')->format('m/d/y');
?>

<!-- BANNER IMAGE -->
<div class="banner2">
    <img src="../images/banner2.jpg" alt="BLOOM BOUTIQUE">
    <h1 class="banner-title">ORDER SUBMITTED</h1>
</div>


<div class="oc">
    <div class="confirm-complete">
        <img src="../images/ordercomplete_check.png" alt="">
        <p><strong>Your Order is Submitted!</strong></p>
        <p>Thank you, your order has been received.</p>
    </div>

    <div class="group-order-completed">
        <div class="column-order">
            <label id="ordercomplete" for="order-dits">Order details</label>
            <strong>#<?= str_pad($orderId, 10, '0', STR_PAD_LEFT); ?></strong>
        </div>
        <hr class="vertical-divider">

        <div class="column-order">
            <label id="ordercomplete" for="payment-meth">Payment Method</label>
            <strong><?= htmlspecialchars($order['payment_method']); ?></strong>
        </div>
        <hr class="vertical-divider">

        <div class="column-order">
            <label id="ordercomplete" for="transid">Placed On</label>
            <p class="get-details"><?= $order['created_at']; ?></p>
        </div>
        <hr class="vertical-divider">

        <div class="column-order">
            <label id="ordercomplete" for="estimated">Estimated Delivery Date</label>
            <strong><?= $deliveryDate; ?></strong>
        </div>
    </div>

    <div class="order-details-box">
        <h4>Order details</h4>
        <table class="order-table full-width">
            <thead>
                <tr>
                    <th>Products</th>
                    <th>Sub Total</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $total = 0;
                while ($row = $items->fetch_assoc()):
                    $price = $row['price'];
                    $discount = $row['discount'];
                    $hasDiscount = $discount > 0;
                    $discountedPrice = $price - ($price * $discount / 100);
                    $itemTotal = $discountedPrice * $row['quantity'];
                    $total += $itemTotal;

                    // Determine type
                    $isCustom = $row['custom_flower_id'] !== null;

                    // Info based on type
                    $productName = $isCustom ? "Customized Flower" : $row['product_name'];
                    $productImage = $isCustom ? "custom_flowers/" . $row['custom_image'] : $row['product_image'];
                    $message = !empty($row['message']) ? "Card: ". $row['message'] : 'No card provided';
                    ?>
                    <tr>
                        <td class="product-detail">
                            <img src="../images/<?= htmlspecialchars($productImage); ?>"
                                alt="<?= htmlspecialchars($productName); ?>">
                            <div>
                                <p class="product-name"><?= htmlspecialchars($productName); ?></p>
                                <small>Quantity: <?= $row['quantity']; ?></small>
                                <p class="cat-new-price">
                                    ₱<?= number_format($discountedPrice, 2); ?>
                                    <?php if ($hasDiscount): ?>
                                        <span class="cat-old-price">
                                            <del>₱<?= number_format($price, 2); ?></del>
                                        </span>
                                    <?php endif; ?>
                                </p>
                                <small><?= $message; ?></small>
                            </div>
                        </td>
                        <td>₱<?= number_format($itemTotal, 2); ?></td>
                    </tr>
                <?php endwhile; ?>

                <tr>
                    <td>Shipping</td>
                    <td>₱150.00</td>
                </tr>
                <tr class="order-total-row">
                    <td><strong>Total</strong></td>
                    <td><strong>₱<?= number_format($total + 150, 2); ?></strong></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<?php require_once 'footer.php'; ?>