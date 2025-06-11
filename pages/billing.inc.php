<?php
session_start();
require_once '../connection.php';
require_once 'functionsPages.inc.php';
require_once '../account/PHPMailer-6.9.2/src/PHPMailer.php';
require_once '../account/PHPMailer-6.9.2/src/Exception.php';
require_once '../account/PHPMailer-6.9.2/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

date_default_timezone_set('Asia/Manila');
ini_set('display_errors', 1);
error_reporting(E_ALL);

// 🧾 Place Order
if (isset($_POST['placedorder']) && isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];
    $orderId = placeOrder($conn, $userId, $_POST);

    if (!$orderId) {
        die("Something went wrong placing the order.");
    }

    $_SESSION['last_order_id'] = $orderId;

    // 🧾 Fetch Order Info for Email
    $stmt = $conn->prepare("SELECT * FROM orders WHERE order_id = ?");
    $stmt->bind_param('i', $orderId);
    $stmt->execute();
    $order = $stmt->get_result()->fetch_assoc();

    $stmt = $conn->prepare("SELECT oi.*, p.product_name, p.product_image FROM order_items oi JOIN products p ON oi.product_id = p.product_id WHERE oi.order_id = ?");
    $stmt->bind_param('i', $orderId);
    $stmt->execute();
    $items = $stmt->get_result();

    $createdDate = new DateTime($order['created_at']);
    $deliveryDate = $createdDate->modify('+7 days')->format('F j, Y');

    // 🖼️ Build Email UI (HTML body)
    ob_start();
    ?>
    <h2 style="color:#da2a69;">New Order Placed!</h2>
    <p>Order #: <strong><?= str_pad($orderId, 10, '0', STR_PAD_LEFT); ?></strong></p>
    <p>Placed On: <?= $order['created_at']; ?></p>
    <p>Payment Method: <?= htmlspecialchars($order['payment_method']); ?></p>
    <p>Estimated Delivery: <strong><?= $deliveryDate; ?></strong></p>

    <hr>

    <h3>Order Summary:</h3>
    <table cellpadding="10" cellspacing="0" width="100%">
        <thead>
            <tr style="background:#f8f8f8;">
                <th>Product</th>
                <th>Qty</th>
                <th>Price</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $total = 0;
            while ($row = $items->fetch_assoc()):
                $price = $row['price'];
                $discount = $row['discount'];
                $discountedPrice = $price - ($price * $discount / 100);
                $itemTotal = $discountedPrice * $row['quantity'];
                $total += $itemTotal;
                ?>
                <tr>
                    <td><?= $row['product_name']; ?></td>
                    <td><?= $row['quantity']; ?></td>
                    <td>₱<?= number_format($discountedPrice, 2); ?></td>
                    <td>₱<?= number_format($itemTotal, 2); ?></td>
                </tr>
            <?php endwhile; ?>
            <tr>
                <td colspan="3">Shipping</td>
                <td>₱150.00</td>
            </tr>
            <tr>
                <td colspan="3"><strong>Total</strong></td>
                <td><strong>₱<?= number_format($total + 150, 2); ?></strong></td>
            </tr>
        </tbody>
    </table>
    <p style="margin-top:20px;">Bloom Boutique ❤</p>
    <?php
    $emailBody = ob_get_clean();

    // 📧 Send Email ONLY to You
    $mail = new PHPMailer(true);
    try {
        //try this on your own
    } catch (Exception $e) {
        echo "Mailer Error: {$mail->ErrorInfo}";
    }

    header("Location: placedOrder.php?order_id=" . $orderId);
    exit();
}

header("Location: billing.php");
exit();
