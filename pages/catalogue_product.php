<?php
    require_once 'header.php';
    require_once '../connection.php';

    if (isset($_GET['product_id'])) {
        $product_id = intval($_GET['product_id']);
    
        // Fetch product details
        $stmt = $conn->prepare("SELECT * FROM product_catalogue WHERE product_id = ?");
        $stmt->bind_param("i", $product_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if($result->num_rows > 0){
            $row = $result->fetch_assoc();
        }else{
            die();
        }
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
        <?php echo '<img src="data:image/png;base64,' . base64_encode($row["product_image"]) . '" alt="Product Image">'; ?>
    </div><!-- end image -->

    <div class="detailed-info"><!-- info -->
        <div class="cat-status">
            <p class="info-cat-category"><?= $row['product_category']; ?></p>
            <p class="status"><?= $row['product_status']; ?></p>
        </div>
            <h2 class="info-cat-name"><?= $row['product_name']; ?></h2>
            <p class="info-cat-price"><strong>₱<?= number_format($row['new_price'], 2); ?></strong></p>
            <p class="info-cat-description"><?= $row['product_description']; ?></p>
            <br>

            <div class="size-container"><!-- size container -->
            <div class="size">
                <img src="../images/size.png" alt="Size Image">
                <h5>Standard</h5>
                <h5 class="size-name">Default Price</h5>
            </div>

            <div class="size">
                <img src="../images/size.png" alt="Size Image">
                <h5>Medium</h5>
                <h5 class="size-name">+100</h5>
            </div>

            <div class="size">
                <img src="../images/size.png" alt="Size Image">
                <h5>Large</h5>
                <h5 class="size-name">+200</h5>
            </div>
        </div> <!-- end size container -->
            <br>
            <label class="card-message">Card Message</label>
            <br>
            <textarea id="message"></textarea>

<!-- QUANTITY BUTTON -->
<?php
    $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;
        if (isset($_POST['increase'])) {
        $quantity++;
    }
        if (isset($_POST['decrease']) && $quantity > 1) {
        $quantity--;
    }
?>

<br><br>
        <div class="cat-qbb"><!-- cat-qbb -->
            <form method="post" action="">
                <div class="quantity-selector">
                    <button type="submit" name="decrease">-</button>
                    <input type="text" name="quantity" value="<?= $quantity ?>" readonly>
                    <button type="submit" name="increase">+</button>
                </div>
            </form>
                    <!-- BUTTONS -->
                    <a href="cart.php"><button class="add-to-cart-btn">Add to Cart</button></a>
                    <a href="billing.php"><button class="buy-now-btn">Buy Now</button></a>
        </div><!-- end cat-qbb -->

    </div><!-- end info -->
</div><!-- end main -->

<hr>
<!-- Tabs -->
<nav class="tabs"><!-- tabs -->
    <a href="#additionalinfo" class="tab-button">Additional Information</a>
    <a href="#sendreview" class="tab-button">Review</a>
</nav><!-- end tabs -->
<hr>


<!-- ADDITIONAL INFORMATION -->
 <div id="additionalinfo" class="linksection">
<div class="addmain"><!-- main additional info -->
<div class="addinfo"><!-- add info -->
    <h3>Everlasting Love Package</h3>
    <p>Includes:</p>
        <ul>
            <li><strong>Bridal Bouquet:</strong> White lilies, peonies, and roses with baby's breath and eucalyptus</li>
            <li><strong>Groom's Boutonniere:</strong> White rose with eucalyptus</li>
            <li><strong>Bridesmaids' Bouquets:</strong> A mix of soft pink roses, tulips, and baby’s breath</li>
        </ul>
    <p><strong>Reception Centerpieces:</strong> Elegant floral arrangements with white lilies, roses, and Queen Anne’s Lace</p>
</div><!-- end add info -->
</div><!-- end main additional info -->
</div>



<!-- SEND REVIEW -->
<div id="sendreview" class="linksection">
<div class="review-main" id="sendreview"><!-- main review container -->
    <div class="send-review" id="review-id">
        <h3>Add your review</h3>
        <p>Lorem ipsum dolor sit amet. Ut eaque consectetur sed voluptatibus doloremque ea nobis quis 33 laboriosam aliquid est deleniti eaque ut blanditiis nobis.</p>

        <form method="POST" action="">
            <div class="name-email">
                <div class="send-input-grp">
                    <label for="name">Name</label>
                    <input type="text" name="name" required>
                </div>

                <div class="send-input-grp">
                    <label for="email">Email</label>
                    <input type="text" name="email" required>
                </div>
            </div>

            <div class="send-input-grp">
                <label>Your Rating</label>
                <div class="star-rating">
                    ★ ★ ★ ★ ★
                </div>
            </div>

            <div class="send-input-grp">
                <label for="title">Add Review Title</label>
                <input type="text" name="title" required>
            </div>

            <div class="send-input-grp">
                <label for="reviewer-input">Add Detailed Review</label>
                <textarea id="reviewer-input" required></textarea>
            </div>

            <div class="send-input-grp">
                <label>Photo / Video (Optional)</label>
                <label class="upload-icon">
                    <img src="../images/upload.png" alt="Upload Icon">
                    <p>Upload photo</p>
                    <input type="file" name="evidence" accept="image/*">
                </label>
            </div>

            <input type="submit" name="review-submit" value="Submit">
        </form>
    </div>
</div><!-- end main review container -->
</div>

<!-- reviews -->
<!-- <h3>Review List</h3>


<div class="reviews">
        <div class="reviews-container">
                <div class="feedback">
                    <div class="review-image">
                        <img src="../images/reviewer.png" alt="Icon">
                        <p class="rev_name"><strong>Roselyn Caampued</strong></p>
                    </div>
                    
                    <p><strong>Perfect for Birthdays and Weddings!</strong></p>
                    <p class="review-message">Mahal na mahal ko talaga siya mga beh huhuhu Mahal na mahal ko talaga siya mga beh huhuhu Mahal na mahal ko talaga siya mga beh huhuhu
                    Mahal na mahal ko talaga siya mga beh huhuhu Mahal na mahal ko talaga siya mga beh huhuhu Mahal na mahal ko talaga siya mga beh huhuhu Mahal na mahal ko talaga siya mga beh huhuhu
                    </p>

                    <div class="reviewer-rating">
                        <h3>⭐⭐⭐⭐⭐<h3>
                        <h5>5.0</h5>
                    </div> 

                    <div class="reviews-images">
                        <img src="../images/picture1.jpg" alt="">
                        <img src="../images/picture2.jpg" alt="">
                        <img src="../images/picture3.jpg" alt="">
                    </div>
                        
                </div>
        </div> -->
    </div><!-- end reviews -->


<?php include_once'footer.php';?>