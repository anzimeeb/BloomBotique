<?php
include_once 'nav-admin.php';
require_once 'dba.inc.php';

// Pagination and Search Setup
$itemsPerPage = 8;
$currentPage = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$offset = ($currentPage - 1) * $itemsPerPage;

$searchLike = "%$search%";
$searchId = is_numeric($search) ? (int) $search : 0;

// Count total orders (with optional search)
$countQuery = "
    SELECT COUNT(*) FROM orders 
    WHERE order_id = ? 
       OR firstname LIKE ? 
       OR lastname LIKE ? 
       OR email LIKE ?
";
$stmtCount = $conn->prepare($countQuery);
$stmtCount->bind_param('isss', $searchId, $searchLike, $searchLike, $searchLike);
$stmtCount->execute();
$stmtCount->bind_result($totalOrders);
$stmtCount->fetch();
$stmtCount->close();

$totalPages = ceil($totalOrders / $itemsPerPage);

// Fetch orders with search and pagination
$query = "
    SELECT * FROM orders 
    WHERE order_id = ? 
       OR firstname LIKE ? 
       OR lastname LIKE ? 
       OR email LIKE ?
    ORDER BY created_at DESC 
    LIMIT ? OFFSET ?
";
$stmt = $conn->prepare($query);
$stmt->bind_param('isssii', $searchId, $searchLike, $searchLike, $searchLike, $itemsPerPage, $offset);
$stmt->execute();
$result = $stmt->get_result();

$orders = [];
while ($row = $result->fetch_assoc()) {
    $orders[] = $row;
}






$orderItemsByOrderId = [];

$orderIds = array_column($orders, 'order_id');

if (count($orderIds) > 0) {
    $inClause = implode(',', array_fill(0, count($orderIds), '?'));
    $types = str_repeat('i', count($orderIds));

    // Fetch order_items
    $stmt = $conn->prepare("SELECT * FROM order_items WHERE order_id IN ($inClause)");
    $stmt->bind_param($types, ...$orderIds);
    $stmt->execute();
    $resultItems = $stmt->get_result();

    $rawItems = [];
    $productIds = [];
    $customFlowerIds = [];

    while ($item = $resultItems->fetch_assoc()) {
        $rawItems[] = $item;

        if ($item['product_id']) {
            $productIds[] = $item['product_id'];
        }
        if ($item['custom_flower_id']) {
            $customFlowerIds[] = $item['custom_flower_id'];
        }
    }

    // Fetch full product details, keyed by product_id
    $products = [];
    if (!empty($productIds)) {
        $in = implode(',', array_fill(0, count($productIds), '?'));
        $stmtProd = $conn->prepare("SELECT * FROM products WHERE product_id IN ($in)");
        $stmtProd->bind_param(str_repeat('i', count($productIds)), ...$productIds);
        $stmtProd->execute();
        $res = $stmtProd->get_result();
        while ($row = $res->fetch_assoc()) {
            $products[$row['product_id']] = $row; // store full row
        }
    }

    // Fetch full custom flower details, keyed by id
    $customFlowers = [];
    if (!empty($customFlowerIds)) {
        $in = implode(',', array_fill(0, count($customFlowerIds), '?'));
        $stmtCustom = $conn->prepare("SELECT * FROM customflowers WHERE id IN ($in)");
        $stmtCustom->bind_param(str_repeat('i', count($customFlowerIds)), ...$customFlowerIds);
        $stmtCustom->execute();
        $res = $stmtCustom->get_result();
        while ($row = $res->fetch_assoc()) {
            $customFlowers[$row['id']] = $row; // store full row
        }
    }

    // Organize items under each order_id and merge product/custom flower info
    $orderItemsByOrderId = [];

    foreach ($rawItems as $item) {
        if ($item['product_id'] && isset($products[$item['product_id']])) {
            // Merge product details into item
            $item = array_merge($item, $products[$item['product_id']]);
        } elseif ($item['custom_flower_id'] && isset($customFlowers[$item['custom_flower_id']])) {
            // Merge custom flower details into item
            $item = array_merge($item, $customFlowers[$item['custom_flower_id']]);
            // Optionally mark it as custom
            $item['is_custom'] = true;
        } else {
            $item['product_name'] = 'Unknown';
        }

        $orderItemsByOrderId[$item['order_id']][] = $item;
    }
}

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
</head>

<div class="orders-container">
    <div class="orders-header">
        <h1>Orders</h1>
        <form method="GET" class="search-form">
            <input type="text" class="search" name="search" placeholder="Search orders..."
                value="<?= htmlspecialchars($search) ?>">
            <button type="submit" class='edit-btn'>Search</button>
        </form>
    </div>

    <table class="orders-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Total Amount</th>
                <th>Payment</th>
                <th>Date</th>
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
                    <td><?= htmlspecialchars($order['created_at']) ?></td>
                    <td>
                        <?php
                        $statusClass = '';
                        $status = strtolower($order['order_status']);
                        if ($status == 'delivered' || $status == 'accepted') {
                            $statusClass = 'status-done';
                        } elseif ($status == 'cancelled') {
                            $statusClass = 'status-cancelled';
                        } elseif (in_array($status, ['pending', 'processing', 'shipped'])) {
                            $statusClass = 'status-processing';
                        }
                        ?>
                        <span class="status-badge <?= $statusClass ?>">
                            <?= htmlspecialchars($order['order_status']) ?>
                        </span>
                    </td>
                    <td class="action-cell">
                        <form method="POST" action="updateOrderStatus.inc.php">
                            <input type="hidden" name="order_id" value="<?= htmlspecialchars($order['order_id']) ?>">
                            <input type="hidden" name="email" value="<?= htmlspecialchars($order['email']) ?>">
                            <select name="order_status" class="status-dropdown" onchange="this.form.submit()">
                                <option value="Pending" <?= $order['order_status'] == 'Pending' ? 'selected' : '' ?>>Pending
                                </option>
                                <option value="Accepted" <?= $order['order_status'] == 'Accepted' ? 'selected' : '' ?>>Accepted
                                </option>
                                <option value="Shipped" <?= $order['order_status'] == 'Shipped' ? 'selected' : '' ?>>Shipped
                                </option>
                                <option value="Delivered" <?= $order['order_status'] == 'Delivered' ? 'selected' : '' ?>>
                                    Delivered</option>
                                <option value="Cancelled" <?= $order['order_status'] == 'Cancelled' ? 'selected' : '' ?>>
                                    Cancelled</option>
                            </select>
                        </form>
                        <button class="view-btn" onclick="openModal('modal-<?= $order['order_id'] ?>')">View</button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table> <!-- Close your table here -->

    <!-- Now output the modals OUTSIDE the table -->
    <?php foreach ($orders as $order): ?>
        <div id="modal-<?= $order['order_id'] ?>" class="modal" style="display:none;">
            <div class="modal-content">
                <span class="close" onclick="closeModal('modal-<?= $order['order_id'] ?>')">&times;</span>
                <h2>Order #<?= $order['order_id'] ?></h2>

                <?php if (!empty($orderItemsByOrderId[$order['order_id']])): ?>
                    <table class="modal-items-table">
                        <thead>
                            <tr>
                                <th>Item</th>
                                <th>Qty</th>
                                <th>Price</th>
                                <th>Discount</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $total = 0;
                            foreach ($orderItemsByOrderId[$order['order_id']] as $item):
                                $price = $item['price'];
                                $discountPercent = $item['discount']; // percent, e.g. 10 means 10%
                                $discountedPrice = $price - ($price * $discountPercent / 100);
                                $subtotal = $discountedPrice * $item['quantity'];
                                $total += $subtotal;
                                ?>
                                <tr>
                                    <td class="orderdetails">
                                        <?php if (!empty($item['is_custom'])): ?>
                                            <img class="orderimg"
                                                src="../images/custom_flowers/<?= htmlspecialchars($item['custom_image']); ?>" />
                                            <div class="orderdetailswimg">
                                                <p><?= htmlspecialchars('Customized Flower') ?></p>
                                                <small><?= $item['main_flower'] . " " . $item['fillers'] . " " . $item['wrapper'] . " " . $item['ribbon'] ?></small>
                                                <small>Card: <?= htmlspecialchars($item['message']) ?></small>
                                            </div>
                                        <?php else: ?>
                                            <img class="orderimg" src="<?= htmlspecialchars($item['product_image']); ?>" />
                                            <div class="orderdetailswimg">
                                                <?= htmlspecialchars($item['product_name'] ?? 'Unnamed Product') ?>
                                                <small>Card: <?= htmlspecialchars($item['message']) ?></small>
                                            </div>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= $item['quantity'] ?></td>
                                    <td>₱<?= number_format($price, 2) ?></td>
                                    <td><?= $discountPercent ?>%</td>
                                    <td>₱<?= number_format($subtotal, 2) ?></td>
                                </tr>
                            <?php endforeach; ?>
                            <tr>
                                <td colspan="4" style="text-align:right"><strong>Total:</strong></td>
                                <td><strong>₱<?= number_format($total, 2) ?></strong></td>
                            </tr>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p>No items found for this order.</p>
                <?php endif; ?>
            </div>
        </div>
    <?php endforeach; ?>


    </table>

    <!-- Pagination -->
    <div class="pagination-container">
        <a class="pagination-btn prev-btn <?= $currentPage == 1 ? 'disabled' : '' ?>"
            href="<?= $currentPage > 1 ? '?page=' . ($currentPage - 1) . '&search=' . urlencode($search) : '#' ?>">Previous</a>

        <div class="pagination-numbers">
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <a class="pagination-number <?= $i == $currentPage ? 'active' : '' ?>"
                    href="?page=<?= $i ?>&search=<?= urlencode($search) ?>">
                    <?= str_pad($i, 2, '0', STR_PAD_LEFT) ?>
                </a>
            <?php endfor; ?>
        </div>

        <a class="pagination-btn next-btn <?= $currentPage == $totalPages ? 'disabled' : '' ?>"
            href="<?= $currentPage < $totalPages ? '?page=' . ($currentPage + 1) . '&search=' . urlencode($search) : '#' ?>">Next</a>
    </div>

    <script>
        function openModal(id) {
            document.getElementById(id).style.display = 'block';
        }
        function closeModal(id) {
            document.getElementById(id).style.display = 'none';
        }
        window.onclick = function (event) {
            if (event.target.classList.contains('modal')) {
                event.target.style.display = "none";
            }
        }
    </script>

</div>