<?php
require_once 'header.php';
require_once '../connection.php';

if (isset($_GET['product_id'])) {
    $product_id = intval($_GET['product_id']);

    // Fetch product details
    $stmt = $conn->prepare("SELECT * FROM products WHERE product_id = ?");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        die();
    }
}

if (isset($_POST['add_to_cart'])) {
    // Product details
    $productId = $_POST['product_id'];  // Make sure the product ID is included
    $productName = $_POST['product_name'];  // Product name
    $productPrice = $_POST['product_price'];
    $size = $_POST['size'];  // Product price
    $quantity = $_POST['quantity'];  // Quantity from the form
    $image = $_POST['product_image'];
    $discount = $_POST['product_discount'];
    $message = $_POST['message'];

    // Check if there's already a cart cookie
    if (isset($_COOKIE['cart'])) {
        // Get the existing cart cookie (decode it from JSON)
        $cart = json_decode($_COOKIE['cart'], true);
    } else {
        // If no cart cookie, initialize an empty cart
        $cart = [];
    }

    // Check if the product is already in the cart
    if (isset($cart[$productId])) {
        // If it is, update the quantity
        $cart[$productId]['quantity'] += $quantity;
    } else {
        // If not, add a new product to the cart
        $cart[$productId] = [
            'id' => $productId,
            'name' => $productName,
            'price' => $productPrice,
            'size' => $size,
            'image' => $image,
            'quantity' => $quantity,
            'discount' => $discount,
            'message' => $message,
        ];
    }

    // Save the updated cart back into the cookie (with a 1-week expiration)
    setcookie('cart', json_encode($cart), time() + 3600 * 24 * 7, '/');

    // Redirect to the cart page
    header("Location: cart.php");
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Catalogue</title>
    <link rel="icon" href="../images/logob.png">
    <link rel="stylesheet" href="../style.css">
</head>

<!-- BANNER IMAGE -->
<div class="banner2">
    <img src="../images/banner2.jpg" alt="BLOOM BOUTIQUE">
    <h1 class="banner-title">CATALOGUE</h1>
</div>

<!-- PRODUCT DETAILED INFORMATION -->
<div class="more-info"><!-- main -->
    <div class="cat-product-image"><!-- image -->
        <img src="<?php echo htmlspecialchars($row["product_image"]); ?>" alt="Best Seller Image">
    </div><!-- end image -->

    <div class="detailed-info"><!-- info -->
        <div class="cat-status">
            <p class="info-cat-category"><?= $row['product_category']; ?></p>
            <p class="status"><?= $row['product_status']; ?></p>
        </div>

        <h2 class="info-cat-name"><?= $row['product_name']; ?></h2>

        <?php
        $old_price = $row['product_price'];
        $discount = $row['product_discount'];
        $new_price = $old_price - ($old_price * ($discount / 100));
        ?>

        <p class="info-cat-price">
            <strong>₱<?= number_format($new_price, 2); ?></strong>
            <?php if ($discount > 0): ?>
                <span class="old-price" style="color: #999; font-size: 0.9em; margin-left: 10px;">
                    <del>₱<?= number_format($old_price, 2); ?></del>
                </span>
            <?php endif; ?>
        </p>

        <p class="info-cat-description"><?= $row['product_description']; ?></p>
        <br>

        <!-- QUANTITY HANDLER -->
        <?php
        $quantity = isset($_POST['quantity']) ? (int) $_POST['quantity'] : 1;
        if (isset($_POST['increase']))
            $quantity++;
        if (isset($_POST['decrease']) && $quantity > 1)
            $quantity--;
        ?>

        <div>
            <form method="post" action="">
                <!-- SIZE OPTIONS -->
                <div class="size-container">
                    <label class="size-option">
                        <input type="radio" name="size" value="0" hidden checked>
                        <div class="size"> <!-- Style target -->
                            <img src="../images/size.png" alt="Size Image">
                            <h5>Standard</h5>
                            <h5 class="size-name">Default Price</h5>
                        </div>
                    </label>

                    <!-- <label class="size-option">
                        <input type="radio" name="size" value="1" hidden>
                        <div class="size">
                            <img src="../images/size.png" alt="Size Image">
                            <h5>Medium</h5>
                            <h5 class="size-name">+100</h5>
                        </div>
                    </label>

                    <label class="size-option">
                        <input type="radio" name="size" value="2" hidden>
                        <div class="size">
                            <img src="../images/size.png" alt="Size Image">
                            <h5>Large</h5>
                            <h5 class="size-name">+200</h5>
                        </div>
                    </label> -->
                </div>

                <br>
                <!-- CARD MESSAGE -->
                <label class="card-message" for="message">Card Message</label>
                <br><br>
                <textarea name="message" id="message" placeholder="Enter your message here..."></textarea>
                <br><br>
                <!-- Hidden input for product details -->
                <input type="hidden" name="product_id" value="<?= $product_id; ?>"> <!-- Set the correct product ID -->
                <input type="hidden" name="product_name" value="<?= $row['product_name']; ?>">
                <!-- Set the correct product name -->
                <input type="hidden" name="product_price" value="<?= $row['product_price']; ?>">
                <!-- Set the correct product price -->
                <input type="hidden" name="product_image" value="<?= htmlspecialchars($row['product_image']); ?>">
                <input type="hidden" name="product_discount" value="<?= $row['product_discount']; ?>">

                <div class="cat-qbb">
                    <div class="quantity-selector">
                        <button type="submit" name="decrease">-</button>
                        <input type="text" name="quantity" value="<?= $quantity ?>" readonly>
                        <button type="submit" name="increase">+</button>
                    </div>

                    <button type="submit" name="add_to_cart" class="add-to-cart-btn">Add to Cart</button>
                    <a href="billing.php"><button class="buy-now-btn">Buy Now</button></a>
                </div>
            </form>
        </div>
    </div><!-- end info -->

</div><!-- end main -->

<hr class="hr">
<!-- Tabs -->
<nav class="tabs"><!-- tabs -->
    <a href="#seereviews" class="tab-button">Reviews</a>
    <a href="#additionalinfo" class="tab-button">Additional Information</a>
    <?php
    $showReviewButton = false;

    if (isset($_SESSION['user_id'])) {
        $customerID = $_SESSION['user_id']; // assuming this is stored in session
        $productID = $_GET['product_id']; // assuming this variable is already defined
    
        // Check if the user has purchased and completed the product
        $orderQuery = "
    SELECT COUNT(*) 
    FROM order_items 
    INNER JOIN orders ON order_items.order_id = orders.order_id 
    WHERE orders.user_id = ? 
    AND order_items.product_id = ? 
    AND orders.order_status = 'Delivered'
    ";

        $stmt = $conn->prepare($orderQuery);
        $stmt->bind_param("ii", $customerID, $productID);
        $stmt->execute();
        $stmt->bind_result($orderCount);
        $stmt->fetch();
        $stmt->close();

        // If the user has purchased the product and it's delivered
        if ($orderCount > 0) {

            // Check if the user has already reviewed the product
            $reviewQuery = "
        SELECT COUNT(*) 
        FROM reviews 
        WHERE customer_id = ? 
        AND product_id = ?
        ";

            $stmt = $conn->prepare($reviewQuery);
            $stmt->bind_param("ii", $customerID, $productID);
            $stmt->execute();
            $stmt->bind_result($reviewCount);
            $stmt->fetch();
            $stmt->close();

            // If the user has not reviewed yet, show the review button
            if ($reviewCount == 0) {
                $showReviewButton = true;
            }
        }
    }
    ?>

    <?php if ($showReviewButton): ?>
        <a href="#sendreview" class="tab-button">Send Review</a>
    <?php endif; ?>

</nav><!-- end tabs -->


<!-- review list -->
<?php
$product_id = $_GET['product_id']; // Or you can set it manually if needed
$query = "
SELECT r.review_text, r.rating, r.created_at, r.review_image, u.customerFN, u.customerLN, u.profile_image
FROM reviews r
INNER JOIN customerinfo u ON r.customer_id = u.id
WHERE r.product_id = ?
ORDER BY r.created_at DESC
";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!-- review list -->
<div id="seereviews" class="linksection">
    <h3 class="rlist-title">Review List</h3>
    <div class="reviews-list">
        <?php while ($rowreview = $result->fetch_assoc()): ?>
            <div class="rlist-container">
                <div class="customer-feedback">
                    <div class="rlist-image">
                        <img src="../images/profilepictures/<?php echo $rowreview['profile_image'] ?: 'default-profile.jpg'; ?>"
                            alt="Reviewer">
                        <p class="rev_name"><strong><?php echo $rowreview['customerFN'];
                        echo ' ' . $rowreview['customerLN']; ?></strong></p>
                    </div>

                    <p class="rlist-message">
                        <?php echo nl2br(htmlspecialchars($rowreview['review_text'])); ?>
                    </p>

                    <div class="rlist-rating">
                        <h3>⭐⭐⭐⭐⭐</h3>
                        <h5><?php echo htmlspecialchars($rowreview['rating']); ?>.0</h5>
                    </div>

                    <div class="rlist-uploads">
                        <?php
                        $images = json_decode($rowreview['review_image']);
                        if ($images) {
                            foreach ($images as $image) {
                                echo '<img src="' . htmlspecialchars($image) . '" alt="Review image">';
                            }
                        } else {
                            echo '<img src="' . $rowreview['review_image'] . '" alt="Review image">';

                        }
                        ?>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </div><!-- end reviews -->
</div>
<?php
?>

<!-- ADDITIONAL INFORMATION -->
<div id="additionalinfo" class="linksection ">
    <div class="addmain"><!-- main additional info -->
        <div class="addinfo"><!-- add info -->
            <h2 class="info-cat-name"><?= $row['product_name']; ?></h2>
            <p>Includes:</p>
            <ul>
                <li><strong>Bridal Bouquet:</strong> White lilies, peonies, and roses with baby's breath and eucalyptus
                </li>
                <li><strong>Groom's Boutonniere:</strong> White rose with eucalyptus</li>
                <li><strong>Bridesmaids' Bouquets:</strong> A mix of soft pink roses, tulips, and baby’s breath</li>
            </ul>
            <p><strong>Reception Centerpieces:</strong> Elegant floral arrangements with white lilies, roses, and Queen
                Anne’s Lace</p>
        </div><!-- end add info -->
    </div><!-- end main additional info -->
</div>

<!-- SEND REVIEW -->
<div id="sendreview" class="linksection">
    <div class="review-main" id="sendreview"><!-- main review container -->
        <div class="send-review" id="review-id">
            <h3>Add your review</h3>
            <p>We value your feedback! Share your experience by submitting a review below.
                Your insights help us improve and help others make informed decisions.</p>
            <br>
            <form method="POST" action="submit_review.inc.php" enctype="multipart/form-data">
                <div class="send-input-grp">
                    <label>Your Rating</label>
                    <div class="star-rating">
                        <input type="radio" id="star5" name="rating" value="5">
                        <label for="star5">★</label>
                        <input type="radio" id="star4" name="rating" value="4">
                        <label for="star4">★</label>
                        <input type="radio" id="star3" name="rating" value="3">
                        <label for="star3">★</label>
                        <input type="radio" id="star2" name="rating" value="2">
                        <label for="star2">★</label>
                        <input type="radio" id="star1" name="rating" value="1">
                        <label for="star1">★</label>
                    </div>
                </div>

                <div class="send-input-grp">
                    <label for="reviewer-input">Detailed Review</label>
                    <textarea id="reviewer-input" name="review_text" required></textarea>
                </div>

                <div class="send-input-grp">
                    <label>Upload Image (Optional)</label>
                    <input type="file" name="review_image" accept="image/*">
                </div>

                <input type="hidden" name="product_id" value="<?php echo $_GET['product_id']; ?>">


                <input type="submit" name="review-submit" value="Submit Review">
            </form>

        </div>
    </div><!-- end main review container -->
</div>



<?php include_once 'footer.php'; ?>