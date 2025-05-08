<?php
include_once 'nav-admin.php';
require_once 'dba.inc.php';

// Handle Edit Button (fetch product details)
if (isset($_GET['editId'])) {
    $editId = intval($_GET['editId']);
    $sql = "SELECT * FROM products WHERE product_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $editId);
    $stmt->execute();
    $editResult = $stmt->get_result();
    $editProduct = $editResult->fetch_assoc();
    $stmt->close();
}
?>


<div class="page-header">
    <div class="header-title">
        <h1>Product</h1>
    </div>
    <button class="addProductBtn" onclick="openPopup()">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-plus"
            viewBox="0 0 16 16">
            <path
                d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4" />
        </svg>
        Add New Product
    </button>
    <form method="GET" class="search-form">
        <input type="text" name="search" placeholder="Search products..."
            value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>">
        <button type="submit" class='edit-btn'>Search</button>
    </form>
</div>

<!-- Add New Product Popup -->
<div class="popup" id="popUp">
    <div class="popup-content">
        <div class="popup-header">
            <h2>Add New Product</h2>
            <button class="close-popup close-button" onclick="closePopup()">×</button>
        </div>
        <form method="POST" action="product.inc.php" enctype="multipart/form-data">


            <div class="form-row">
                <div class="form-column">
                    <div class="form-group">
                        <label>Name:</label>
                        <input type="text" name="product_name" required class="form-control" placeholder="Input here">
                    </div>

                    <div class="form-group">
                        <label>Description:</label>
                        <textarea name="product_description" required class="form-control"
                            placeholder="Input here"></textarea>
                    </div>

                    <div class="form-group">
                        <label>Price:</label>
                        <input type="number" name="product_price" step="0.01" required class="form-control"
                            placeholder="Input here">
                    </div>

                    <div class="form-group">
                        <label>Category:</label>
                        <input type="text" name="product_category" required class="form-control"
                            placeholder="Input here">
                    </div>

                    <div class="form-group">
                        <label>Color:</label>
                        <input type="text" name="product_color" class="form-control" placeholder="Input here">
                    </div>
                </div>

                <div class="form-column">
                    <div class="form-group">
                        <label>Discount (%):</label>
                        <input type="number" name="product_discount" step="0.01" min="0" max="100" class="form-control"
                            placeholder="Input here">
                    </div>

                    <div class="form-group">
                        <label>Bestseller:</label>
                        <select name="product_bestseller" class="form-control">
                            <option value="0">No</option>
                            <option value="1">Yes</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Stock Quantity:</label>
                        <input type="number" name="product_stock" min="0" required class="form-control"
                            placeholder="Input here">
                    </div>

                    <div class="form-group">
                        <label>Status:</label>
                        <select name="productStatus" class="form-control">
                            <option value="Available">Available</option>
                            <option value="Out of Stock">Out of Stock</option>
                            <option value="Discontinued">Discontinued</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Image:</label>
                        <input type="file" name="product_image" id="productImage" class="form-control">
                    </div>
                </div>
            </div>

            <button type="submit" name="submitProduct" class="submit-button">Add New Product</button>
        </form>
    </div>
</div>


<!-- Edit Product Popup -->
<?php if (isset($editProduct)): ?>
    <div class="popup" id="editPopup" style="display: flex;">
        <div class="popup-content">
            <div class="popup-header">
                <h2>Edit Product</h2>
                <button class="close-popup close-button" onclick="closeEditPopup()">×</button>
            </div>
            <form method="POST" action="updateProduct.inc.php" enctype="multipart/form-data">
                <input type="hidden" name="product_id" value="<?php echo $editProduct['product_id']; ?>">

                <div class="form-row">
                    <div class="form-column">
                        <div class="form-group">
                            <label>Name:</label>
                            <input type="text" name="productName"
                                value="<?php echo htmlspecialchars($editProduct['product_name']); ?>" class="form-control"
                                required>
                        </div>

                        <div class="form-group">
                            <label>Description:</label>
                            <textarea name="productDescription" class="form-control"
                                required><?php echo htmlspecialchars($editProduct['product_description']); ?></textarea>
                        </div>

                        <div class="form-group">
                            <label>Price:</label>
                            <input type="number" name="productPrice" step="0.01"
                                value="<?php echo $editProduct['product_price']; ?>" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label>Category:</label>
                            <input type="text" name="productCategory"
                                value="<?php echo $editProduct['product_category']; ?>" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label>Color:</label>
                            <input type="text" name="productColor" value="<?php echo $editProduct['product_color']; ?>"
                                class="form-control">
                        </div>
                    </div>

                    <div class="form-column">
                        <div class="form-group">
                            <label>Discount (%):</label>
                            <input type="number" name="productDiscount" step="0.01" min="0" max="100"
                                value="<?php echo $editProduct['product_discount']; ?>" class="form-control">
                        </div>

                        <div class="form-group">
                            <label>Bestseller:</label>
                            <select name="productBestseller" class="form-control">
                                <option value="0" <?php echo ($editProduct['product_bestseller'] == 0) ? 'selected' : ''; ?>>
                                    No</option>
                                <option value="1" <?php echo ($editProduct['product_bestseller'] == 1) ? 'selected' : ''; ?>>
                                    Yes</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Stock Quantity:</label>
                            <input type="number" name="productStock" min="0"
                                value="<?php echo $editProduct['product_stock']; ?>" class="form-control">
                        </div>

                        <div class="form-group">
                            <label>Status:</label>
                            <select name="productStatus" class="form-control">
                                <option value="Available" <?php echo ($editProduct['product_status'] == 'Available') ? 'selected' : ''; ?>>Available</option>
                                <option value="Out of Stock" <?php echo ($editProduct['product_status'] == 'Out of Stock') ? 'selected' : ''; ?>>Out of Stock</option>
                                <option value="Discontinued" <?php echo ($editProduct['product_status'] == 'Discontinued') ? 'selected' : ''; ?>>Discontinued</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Image:</label>
                            <?php if (!empty($editProduct['product_image'])): ?>
                                <!-- Display current image -->
                                <img src="../uploads/<?php echo $editProduct['product_image']; ?>" alt="Product Image"
                                    style="max-width: 100px; max-height: 100px; margin-bottom: 10px; display: block;">
                            <?php endif; ?>
                            <input type="file" name="product_image" id="productImage" class="form-control">
                        </div>
                    </div>
                </div>

                <button type="submit" name="updateProduct" class="submit-button">Update Product</button>
            </form>
        </div>
    </div>
<?php endif; ?>


<!-- Product Table -->
<div class="table">
    <div class="bgTable">
        <div class="table-container">
            <table class="product-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>ID</th>
                        <th>Description</th>
                        <th>Price</th>
                        <th>Discount</th>
                        <th>Category</th>
                        <th>Color</th>
                        <th>Stock</th>
                        <th>Bestseller</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $rowsPerPage = 9;
                    $currentPage = isset($_GET['page']) ? (int) $_GET['page'] : 1;
                    $offset = ($currentPage - 1) * $rowsPerPage;

                    $search = isset($_GET['search']) ? trim($_GET['search']) : '';
                    $searchLike = "%$search%";
                    $searchId = is_numeric($search) ? (int) $search : 0;

                    // Count total products (with optional search)
                    $sqlCount = "
            SELECT COUNT(*) AS total FROM products 
            WHERE product_id = ? 
               OR product_name LIKE ? 
               OR product_description LIKE ? 
               OR product_category LIKE ?
        ";
                    $stmtCount = $conn->prepare($sqlCount);
                    $stmtCount->bind_param('isss', $searchId, $searchLike, $searchLike, $searchLike);
                    $stmtCount->execute();
                    $resultCount = $stmtCount->get_result();
                    $totalRows = $resultCount->fetch_assoc()['total'];
                    $totalPages = ceil($totalRows / $rowsPerPage);

                    // Fetch products with pagination and search
                    $sql = "
            SELECT * FROM products 
            WHERE product_id = ? 
               OR product_name LIKE ? 
               OR product_description LIKE ? 
               OR product_category LIKE ?
            LIMIT ? OFFSET ?
        ";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param('isssii', $searchId, $searchLike, $searchLike, $searchLike, $rowsPerPage, $offset);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['product_name']) . "</td>";
                        echo "<td>" . $row['product_id'] . "</td>";
                        echo "<td class='description-cell'>" . htmlspecialchars($row['product_description']) . "</td>";
                        echo "<td>₱" . number_format($row['product_price'], 2) . "</td>";
                        echo "<td>" . $row['product_discount'] . "%</td>";
                        echo "<td>" . $row['product_category'] . "</td>";
                        echo "<td>" . $row['product_color'] . "</td>";
                        echo "<td>" . $row['product_stock'] . "</td>";
                        echo "<td>" . ($row['product_bestseller'] ? 'Yes' : 'No') . "</td>";
                        echo "<td>" . $row['product_status'] . "</td>";
                        echo "<td class='action-cell'>
                    <div class='action-buttons'>
                        <form method='GET' action='' class='action-form'>
                            <input type='hidden' name='editId' value='" . $row['product_id'] . "'>
                            <button class='edit-btn'>Edit</button>
                        </form>
                        <form method='POST' action='deleteProduct.inc.php' class='action-form' onsubmit='return confirm(\"Delete this product?\");'>
                            <input type='hidden' name='product_id' value='" . htmlspecialchars($row['product_id'], ENT_QUOTES) . "'>
                            <button type='submit' name='deleteProd' class='delete-btn'>Delete</button>
                        </form>
                    </div>
                </td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
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
        </div>
    </div>
</div>

</div>
</div>
</body>

</html>

<script>
    function openPopup() {
        document.getElementById('popUp').style.display = 'flex';
    }

    function closePopup() {
        document.getElementById('popUp').style.display = 'none';
    }

    function closeEditPopup() {
        window.location.href = '<?php echo basename($_SERVER['PHP_SELF']); ?>';
    }

    document.addEventListener("DOMContentLoaded", function () {
        const descriptionCells = document.querySelectorAll(".description-cell");
        descriptionCells.forEach(cell => {
            const fullText = cell.innerText.trim();
            const words = fullText.split(" ");
            if (words.length > 5) {
                const short = words.slice(0, 5).join(" ") + "...";
                cell.innerHTML = `<span title="${fullText}">${short}</span>`;
            }
        });
    });
</script>