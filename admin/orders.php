<?php
include_once 'nav-admin.php';
require_once 'dba.inc.php';

// Pagination and Search Setup
$itemsPerPage = 10;
$currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$offset = ($currentPage - 1) * $itemsPerPage;

$searchLike = "%$search%";
$searchId = is_numeric($search) ? (int)$search : 0;

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
            <input type="text" class="search" name="search" placeholder="Search orders..." value="<?= htmlspecialchars($search) ?>">
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
                <th>Payment Method</th>
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
                    <span class="status-badge <?= $statusClass ?>"><?= htmlspecialchars($order['order_status']) ?></span>
                </td>
                <td class="action-cell">
                    <form method="POST" action="updateOrderStatus.inc.php">
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

    <!-- Pagination -->
    <div class="pagination-container">
        <a class="pagination-btn prev-btn <?= $currentPage == 1 ? 'disabled' : '' ?>" href="<?= $currentPage > 1 ? '?page=' . ($currentPage - 1) . '&search=' . urlencode($search) : '#' ?>">Previous</a>

        <div class="pagination-numbers">
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <a class="pagination-number <?= $i == $currentPage ? 'active' : '' ?>" href="?page=<?= $i ?>&search=<?= urlencode($search) ?>">
                    <?= str_pad($i, 2, '0', STR_PAD_LEFT) ?>
                </a>
            <?php endfor; ?>
        </div>

        <a class="pagination-btn next-btn <?= $currentPage == $totalPages ? 'disabled' : '' ?>" href="<?= $currentPage < $totalPages ? '?page=' . ($currentPage + 1) . '&search=' . urlencode($search) : '#' ?>">Next</a>
    </div>
</div>
