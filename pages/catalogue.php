<?php
require_once '../connection.php';
require_once 'header.php';

// Start with a base query
$sql = "SELECT * FROM products";

// Check if form was submitted
if (isset($_GET['options']) && !empty($_GET['options'])) {
    // Initialize filter arrays
    $occasion_filters = [];
    $color_filters = [];
    $availability_filters = [];

    // Process selected options
    foreach ($_GET['options'] as $option) {
        // Check if "All" is selected
        if ($option == "All") {
            // If "All" is selected, don't apply occasion filters
            $occasion_filters = [];
            break;
        }

        // Sort options into categories
        if (in_array($option, ["Wedding", "Graduation", "Birthday", "Burial"])) {
            $occasion_filters[] = $option;
        } elseif (in_array($option, ["Mixed", "White", "Red", "Blue", "Green", "Pink"])) {
            $color_filters[] = $option;
        } elseif (in_array($option, ["In Stock", "Out of Stock"])) {
            $availability_filters[] = $option;
        }
    }

    // Build the WHERE clause
    $where_clauses = [];

    // Add occasion filters
    if (!empty($occasion_filters)) {
        $occasion_list = "'" . implode("','", $occasion_filters) . "'";
        $where_clauses[] = "product_category IN ($occasion_list)";
    }

    // Add color filters
    if (!empty($color_filters)) {
        $color_list = "'" . implode("','", $color_filters) . "'";
        $where_clauses[] = "product_color IN ($color_list)";
    }

    if (!empty($availability_filters)) {
        $in_stock_selected = in_array("In Stock", $availability_filters);
        $out_of_stock_selected = in_array("Out of Stock", $availability_filters);

        if ($in_stock_selected && !$out_of_stock_selected) {
            // Only "In Stock" checkbox is checked
            // Ensure the product_stock is a number greater than 0
            $where_clauses[] = "(product_status LIKE 'In Stock')";
        } elseif (!$in_stock_selected && $out_of_stock_selected) {
            // Only "Out of Stock" checkbox is checked
            // Include products with stock = 0 or stock = NULL
            $where_clauses[] = "(product_status LIKE 'Out of Stock')";
        }
        // If both or none are selected, we don't apply stock filter
    }

    // Add WHERE clause to the SQL query if filters are applied
    if (!empty($where_clauses)) {
        $sql .= " WHERE " . implode(" AND ", $where_clauses);
    }
}

// Execute the query
$all_product = $conn->query($sql);

// Handle query errors
if (!$all_product) {
    echo "Error: " . $conn->error;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Catalogue</title>
    <link rel="icon" href="../images/logob.png">
    <link rel="stylesheet" href="../style.css?v=3">
    <script>
        // Function to handle checkbox changes and submit the form
        function autoSubmitForm() {
            document.getElementById('filterForm').submit();
        }
    </script>
</head>

<body>
    <!-- BANNER IMAGE -->
    <div class="banner2">
        <img src="../images/banner2.jpg" alt="BLOOM BOUTIQUE">
        <h1 class="banner-title">CATALOGUE</h1>
    </div>

    <!-- CHECKBOX OPTIONS -->
    <div class="catalogue-main"><!-- main div -->
        <div class="filter-options"><!-- filter div -->
            <h3>Filter Options</h3>
            <form id="filterForm" method="GET" action="">
                <div class="checkbox-container">
                    <h4>By Occasions</h4>
                    <label><input type="checkbox" name="options[]" value="All" <?php if (isset($_GET['options']) && in_array('All', $_GET['options']))
                        echo 'checked'; ?>
                            onchange="autoSubmitForm()">All</label>
                    <label><input type="checkbox" name="options[]" value="Wedding" <?php if (isset($_GET['options']) && in_array('Wedding', $_GET['options']))
                        echo 'checked'; ?>
                            onchange="autoSubmitForm()">Wedding</label>
                    <label><input type="checkbox" name="options[]" value="Graduation" <?php if (isset($_GET['options']) && in_array('Graduation', $_GET['options']))
                        echo 'checked'; ?>
                            onchange="autoSubmitForm()">Graduation</label>
                    <label><input type="checkbox" name="options[]" value="Birthday" <?php if (isset($_GET['options']) && in_array('Birthday', $_GET['options']))
                        echo 'checked'; ?>
                            onchange="autoSubmitForm()">Birthday</label>
                    <label><input type="checkbox" name="options[]" value="Burial" <?php if (isset($_GET['options']) && in_array('Burial', $_GET['options']))
                        echo 'checked'; ?>
                            onchange="autoSubmitForm()">Burial</label>
                </div>
                <hr>

                <div class="checkbox-container">
                    <h4>By Color</h4>
                    <label><input type="checkbox" name="options[]" value="Mixed" <?php if (isset($_GET['options']) && in_array('Mixed', $_GET['options']))
                        echo 'checked'; ?>
                            onchange="autoSubmitForm()">Mixed</label>
                    <label><input type="checkbox" name="options[]" value="White" <?php if (isset($_GET['options']) && in_array('White', $_GET['options']))
                        echo 'checked'; ?>
                            onchange="autoSubmitForm()">White</label>
                    <label><input type="checkbox" name="options[]" value="Red" <?php if (isset($_GET['options']) && in_array('Red', $_GET['options']))
                        echo 'checked'; ?>
                            onchange="autoSubmitForm()">Red</label>
                    <label><input type="checkbox" name="options[]" value="Blue" <?php if (isset($_GET['options']) && in_array('Blue', $_GET['options']))
                        echo 'checked'; ?>
                            onchange="autoSubmitForm()">Blue</label>
                    <label><input type="checkbox" name="options[]" value="Green" <?php if (isset($_GET['options']) && in_array('Green', $_GET['options']))
                        echo 'checked'; ?>
                            onchange="autoSubmitForm()">Green</label>
                    <label><input type="checkbox" name="options[]" value="Pink" <?php if (isset($_GET['options']) && in_array('Pink', $_GET['options']))
                        echo 'checked'; ?>
                            onchange="autoSubmitForm()">Pink</label>
                </div>
                <hr>

                <div class="checkbox-container">
                    <h4>Availability</h4>
                    <label><input type="checkbox" name="options[]" value="Available" <?php if (isset($_GET['options']) && in_array('Available', $_GET['options']))
                        echo 'checked'; ?> onchange="autoSubmitForm()">In
                        Stock</label>
                    <label><input type="checkbox" name="options[]" value="Out of Stock" <?php if (isset($_GET['options']) && in_array('Out of Stock', $_GET['options']))
                        echo 'checked'; ?>
                            onchange="autoSubmitForm()">Out of Stock</label>
                    <br />
                </div>
            </form>
            <a href="customize.php" class="customize-your-own-link">Customize Your Own</a>
        </div><!-- end filter div -->

        <div class="showcasing">
            <!-- Display selected filters -->
            <!-- <?php
            if (isset($_GET['options']) && !empty($_GET['options'])) {
                $selected_options = implode(", ", $_GET['options']);
                echo "<div class='selected-filters'><p>Filters applied: <strong>$selected_options</strong></p>";
                echo "<a href='" . $_SERVER['PHP_SELF'] . "' class='clear-filters'>Clear All Filters</a></div>";
            }
            ?> -->

            <?php
            if (isset($_GET['options']) && !empty($_GET['options'])) {
                echo "<div class='active-filter-container'>";
                echo "<span class='filter-label'>Active filter:</span>";
                echo "<div class='filter-tags'>";

                // Define category arrays for proper labeling
                $occasion_filters = ['All', 'Wedding', 'Graduation', 'Birthday', 'Burial'];
                $color_filters = ['Mixed', 'White', 'Red', 'Blue', 'Green'];
                $availability_filters = ['In Stock', 'Out of Stock'];

                foreach ($_GET['options'] as $option) {
                    $class = 'occasion-tag'; // Default class
                    $prefix = '';

                    if (in_array($option, $occasion_filters)) {
                        $class = 'occasion-tag';
                        $prefix = 'Occasion: ';
                    } elseif (in_array($option, $color_filters)) {
                        $class = 'color-tag';
                        $prefix = 'Color: ';
                    } elseif (in_array($option, $availability_filters)) {
                        $class = 'availability-tag';
                    }

                    echo "<div class='filter-tag $class'>";
                    if ($prefix)
                        echo "<span class='tag-category'>$prefix</span>";
                    echo "<span class='tag-value'>$option</span>";
                    echo "<button class='remove-tag' onclick='removeFilter(\"$option\")'>×</button>";
                    echo "</div>";
                }

                echo "</div>";
                echo "<a href='" . $_SERVER['PHP_SELF'] . "' class='catclear-all'>Clear All</a>";
                echo "</div>";
            }
            ?>

            <script>
                function removeFilter(optionToRemove) {
                    // Get current URL and parameters
                    let url = new URL(window.location.href);
                    let params = new URLSearchParams(url.search);

                    // Get current options
                    let options = params.getAll('options[]');

                    // Remove the specific option
                    let filteredOptions = options.filter(option => option !== optionToRemove);

                    // Clear all options
                    params.delete('options[]');

                    // Add back the remaining options
                    filteredOptions.forEach(option => {
                        params.append('options[]', option);
                    });

                    // Update URL and reload
                    url.search = params.toString();
                    window.location.href = url.toString();
                }
            </script>

            <div class="show-products"><!-- products div -->
                <div class="catalogue-container">
                    <?php
                    if ($all_product && $all_product->num_rows > 0) {
                        while ($row = mysqli_fetch_assoc($all_product)) {
                            $old_price = $row["product_price"];
                            $discount = $row["product_discount"];
                            $new_price = $old_price - ($old_price * ($discount / 100));
                            ?>
                            <a href="catalogue_product.php?product_id=<?= $row['product_id']; ?>">
                                <div class="catalogue-card">
                                    <div class="cat-image">
                                        <img src="<?= $row['product_image']; ?>" alt="Product Image">
                                    </div>
                                    <div class="cat-rating">
                                        <p class="cat-category"><?php echo $row["product_category"]; ?></p>
                                        <div class="rating-cat">
                                            <img src="../images/star.png" alt="Star" width="15">
                                            <span>★</span> <!-- Placeholder, replace with actual rating if needed -->
                                        </div>
                                    </div>
                                    <p class="cat-product-name"><?php echo $row["product_name"]; ?></p>
                                    <p class="cat-new-price">
                                        $<?php echo number_format($new_price, 2); ?>
                                        <?php if ($discount > 0): ?>
                                            <span
                                                class="cat-old-price"><del>$<?php echo number_format($old_price, 2); ?></del></span>
                                        <?php endif; ?>
                                    </p>
                                </div>
                            </a>
                            <?php
                        }
                    } else {
                        echo "<p class='no-products'>No products match your selected filters.</p>";
                    }
                    ?>
                </div>
            </div><!-- end products div -->


        </div>
    </div><!-- end main div -->

    <?php include_once 'footer.php'; ?>
</body>

</html>