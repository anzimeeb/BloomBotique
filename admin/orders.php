<?php
include_once 'nav-admin.php';
require_once 'dba.inc.php';

// Set the number of rows per page
$rowsPerPage = 10;

// Get the current page from the query string, default to 1
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$page = max($page, 1); // Ensure the page is at least 1

// Calculate the offset for the SQL query
$offset = ($page - 1) * $rowsPerPage;

// Fetch the total number of rows
$sqlCount = "SELECT COUNT(*) AS total FROM orders";
$resultCount = $conn->query($sqlCount);
$rowCount = $resultCount->fetch_assoc();
$totalRows = $rowCount['total'];

// Calculate the total number of pages
$totalPages = ceil($totalRows / $rowsPerPage);

// Fetch rows for the current page
$sql = "SELECT orderId, customerId, cartId, totalPrice, paymentMethod, orderDate, pickupTime, orderStatus, deliveryAddress 
        FROM orders 
        LIMIT $rowsPerPage OFFSET $offset";
        
$result = $conn->query($sql);

$sql1 = "SELECT c.customerEmail
         FROM orders o
         JOIN customerinfo c ON o.customerId = c.customerId";

$result1 = $conn->query($sql1);

?>

<div class="header-admin">
    <h1 id="title">Order</h1>
</div>

<div class="table">
    <div class="bgTable">
        <div class="table-container">
            <table class="product-table">
                <thead>
                    <tr>
                        <th class="table-header">Order ID</th>
                        <th class="table-header">Customer</th>
                        <th class="table-header">Product</th>
                        <th class="table-header">Pick Up Time</th>
                        <th class="table-header">Total Cost</th>
                        <th class="table-header">Order Status</th>
                        <th class="table-header">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result && $result->num_rows > 0): ?>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr class="table-row">
                                <td class="table-cell"><?php echo $row['orderId']; ?></td>
                                <td class="table-cell"><?php echo $row['customerId']; ?></td>
                                <td class="table-cell"><?php echo $row['cartId']; ?></td>
                                <td class="table-cell"><?php echo $row['pickupTime']; ?></td>
                                <td class="table-cell">
                                    <span class="order-status-text"><?php echo $row['orderStatus']; ?></span>
                                </td>
                                <td class="table-cell"><?php echo $row['totalPrice']; ?></td>
                               <td class="table-cell">
                                    <button class="done-btn" 
                                            data-order-id="<?php echo $row['orderId']; ?>" 
                                            <?php echo $row['orderStatus'] == "completed" ? 'disabled' : ''; ?>>
                                        Completed
                                    </button>
                                    
                                    <button class="processing-btn" 
                                            data-order-id="<?php echo $row['orderId']; ?>" 
                                            <?php echo $row['orderStatus'] == "processing" ? 'disabled' : ''; ?>>
                                        Processing
                                    </button>
                                    
                                    <button class="cancel-btn" 
                                            data-order-id="<?php echo $row['orderId']; ?>" 
                                            <?php echo $row['orderStatus'] == "cancelled" ? 'disabled' : ''; ?>>
                                        Cancelled
                                    </button>
                                
                                    <button class="pending-btn" 
                                            data-order-id="<?php echo $row['orderId']; ?>" 
                                            <?php echo $row['orderStatus'] == "pending" ? 'disabled' : ''; ?>>
                                        Pending
                                    </button>
                                </td>

                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr class="table-row">
                            <td class="table-cell" colspan="7">No orders found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>

            <!-- Pagination Controls -->
            <div class="pagination-container">
                <?php if ($page > 1): ?>
                    <a href="?page=<?php echo $page - 1; ?>" class="pagination-btn prev-btn">Previous</a>
                <?php else: ?>
                    <span class="pagination-btn prev-btn disabled">Previous</span>
                <?php endif; ?>

                <div class="pagination-numbers">
                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <a href="?page=<?php echo $i; ?>" class="pagination-number <?php echo $i == $page ? 'active' : ''; ?>">
                            <?php echo str_pad($i, 2, "0", STR_PAD_LEFT); ?>
                        </a>
                    <?php endfor; ?>
                </div>

                <?php if ($page < $totalPages): ?>
                    <a href="?page=<?php echo $page + 1; ?>" class="pagination-btn next-btn">Next</a>
                <?php else: ?>
                    <span class="pagination-btn next-btn disabled">Next</span>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script>
// JavaScript to handle the "Done" and "Cancelled" button click
document.querySelectorAll('.done-btn').forEach(function(button) {
    button.addEventListener('click', function() {
        var orderId = this.getAttribute('data-order-id');
        updateOrderStatus(orderId, 2); // Update to "Done"
    });
});

document.querySelectorAll('.cancel-btn').forEach(function(button) {
    button.addEventListener('click', function() {
        var orderId = this.getAttribute('data-order-id');
        updateOrderStatus(orderId, 3); // Update to "Cancelled"
    });
});

function updateOrderStatus(orderId, newStatus) {
    // Send AJAX request to update the order status
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'updateOrderStatus.inc.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            // Successfully updated, disable the button and update the status text
            if (newStatus === 2) {
                document.querySelector(`[data-order-id="${orderId}"].done-btn`).disabled = true;
                document.querySelector(`[data-order-id="${orderId}"].cancel-btn`).disabled = false;
            } else if (newStatus === 3) {
                document.querySelector(`[data-order-id="${orderId}"].done-btn`).disabled = false;
                document.querySelector(`[data-order-id="${orderId}"].cancel-btn`).disabled = true;
            }

            // Update the status text
            var statusText = '';
            switch (newStatus) {
                case 1: statusText = 'Processing'; break;
                case 2: statusText = 'Done'; break;
                case 3: statusText = 'Cancelled'; break;
            }
            document.querySelector(`[data-order-id="${orderId}"]`).closest('tr').querySelector('.order-status-text').textContent = statusText;
        }
    };
    xhr.send('orderId=' + orderId + '&orderStatus=' + newStatus);
}

    document.querySelectorAll('.done-btn, .processing-btn, .cancel-btn, .pending-btn').forEach(button => {
        button.addEventListener('click', function () {
            var orderId = this.getAttribute('data-order-id');
            var newStatus = '';

            // Determine new status based on button clicked
            if (this.classList.contains('done-btn')) {
                newStatus = 'completed';
            } else if (this.classList.contains('processing-btn')) {
                newStatus = 'processing';
            } else if (this.classList.contains('cancel-btn')) {
                newStatus = 'cancelled';
            } else if (this.classList.contains('pending-btn')) {
                newStatus = 'pending';
            }

            // Send the AJAX request to update the status
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'updateOrderStatus.inc.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    alert(xhr.responseText); // Show the response message
                    location.reload(); // Reload the page to reflect the updated status
                }
            };
            xhr.send('orderId=' + orderId + '&orderStatus=' + newStatus);
        });
    });
</script>
