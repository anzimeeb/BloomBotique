<?php
include_once 'nav-admin.php';
require_once 'dba.inc.php';

// Fetch orders from the database
function getOrders($conn) {
    $query = "SELECT * FROM orders";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $result = $stmt->get_result();

    $orders = [];
    while ($row = $result->fetch_assoc()) {
        $orders[] = $row;
    }

    return $orders;
}

// Handle order status change (optional, for admin to update)
if (isset($_POST['updateOrderStatus']) && isset($_POST['order_id'])) {
    $orderId = $_POST['order_id'];
    $orderStatus = $_POST['order_status'];

    $query = "UPDATE orders SET order_status = ? WHERE order_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('si', $orderStatus, $orderId);
    if ($stmt->execute()) {
        header("Location: order.php?message=Order status updated successfully.");
        exit;
    } else {
        echo "Error updating order status.";
    }
}

$orders = getOrders($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders</title>
    <link rel="icon" href="../img/icon/coffeLogo.png" type="image/png" media="(prefers-color-scheme: light)">
    <link rel="icon" href="../img/icon/whiteLogo.png" type="image/png" media="(prefers-color-scheme: dark)">
    <link rel="stylesheet" href="../css/admin.css">
    <link rel="shortcut icon" href="">
</head>


<div class="orders-container">
        <div class="orders-header">
            <h1>Orders</h1>
        </div>

        <table class="orders-table">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Total Amount</th>
                    <th>Payment Method</th>
                    <th>Shipping Fee</th>
                    <th>Order Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $order): ?>
                <tr>
                    <td><?= htmlspecialchars($order['order_id']) ?></td>
                    <td><?= htmlspecialchars($order['firstname']) ?></td>
                    <td><?= htmlspecialchars($order['lastname']) ?></td>
                    <td><?= htmlspecialchars($order['email']) ?></td>
                    <td>₱<?= number_format($order['total_amount'], 2) ?></td>
                    <td><?= htmlspecialchars($order['payment_method']) ?></td>
                    <td>₱<?= number_format($order['shipping_fee'], 2) ?></td>
                    <td>
                        <?php
                        $statusClass = '';
                        $status = strtolower($order['order_status']);
                        
                        if ($status == 'delivered' || $status == 'accepted') {
                            $statusClass = 'status-done';
                        } elseif ($status == 'cancelled') {
                            $statusClass = 'status-cancelled';
                        } elseif ($status == 'pending' || $status == 'processing' || $status == 'shipped') {
                            $statusClass = 'status-processing';
                        }
                        ?>
                        <span class="status-badge <?= $statusClass ?>"><?= htmlspecialchars($order['order_status']) ?></span>
                    </td>
                    <td class="action-cell">
                        <form method="POST" action="order.php">
                            <input type="hidden" name="order_id" value="<?= htmlspecialchars($order['order_id']) ?>">
                            <select name="order_status" class="status-dropdown">
                                <option value="Pending" <?= $order['order_status'] == 'Pending' ? 'selected' : '' ?>>Pending</option>
                                <option value="Accepted" <?= $order['order_status'] == 'Accepted' ? 'selected' : '' ?>>Accepted</option>
                                <option value="Shipped" <?= $order['order_status'] == 'Shipped' ? 'selected' : '' ?>>Shipped</option>
                                <option value="Delivered" <?= $order['order_status'] == 'Delivered' ? 'selected' : '' ?>>Delivered</option>
                                <option value="Cancelled" <?= $order['order_status'] == 'Cancelled' ? 'selected' : '' ?>>Cancelled</option>
                            </select>
                            <button type="submit" name="updateOrderStatus" class="update-btn">Update Status</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
        </tbody>
    </table>
</div>
