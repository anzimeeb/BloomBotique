<?php
session_start();
require_once 'connection.php';

$sql = "SELECT * FROM products WHERE product_bestseller = 1 AND product_status = 1";
$best = $conn->query($sql);
?>

<?php
$sql = "SELECT * FROM reviews";
$review = $conn->query($sql);
?>

<?php
$sql = "SELECT * FROM discount";
$disc = $conn->query($sql);
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Listing</title>
    <link rel="icon" href="images/logob.png">
    <link rel="stylesheet" href="css/style.css?v=3">
</head>

<body>
    <header>
        <?php if (isset($_SESSION["customerEmail"])) {
        } ?>
        <!-- NAVIGATION/HEADER -->
        <div class="navbar">
            <div class="leftside">
                <div class="headerlogo">
                    <a href="#"><img src="images/navlogo.png"></a>
                </div>
            </div>
            <ul class="navigation">
                <li><a href="index.php" class="active">Home</a></li>
                <li><a href="pages/catalogue.php">Catalogue</a></li>
                <li><a href="pages/about.php">About Us</a></li>
                <li><a href="pages/contact.php">Contact Us</a></li>
                <li><a href="pages/cart.php">Cart</a></li>
                <li><a href="pages/faqs.php">FAQS</a></li>
            </ul>
            <div class="auth-links">
                <?php
                if (isset($_SESSION["customerEmail"])) {
                    echo '<a href="pages/profile_personalInfo.php" class="login-btn">Hi! <img src="images/profile.png" alt="Profile"></a>';
                } else {
                    echo '<a href="account/login.php" class="login-btn"><svg xmlns="http://www.w3.org/2000/svg" width="16"
                        height="16" fill="bg-purple-custom" class="bi bi-person-fill" viewBox="0 0 16 16">
                        <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6" />
                    </svg>Login</a> |
                <a href="account/signup.php" class="signup-btn">Signup</a>';
                } ?>
            </div>
        </div>
    </header>

    <!-- BANNER IMAGE -->
    <div class="banner">
        <img src="images/banner.png" alt="BLOOM BOUTIQUE">
    </div>

    <!-- DECLARATIONS (SHOP BY OCCASIONS) -->
    <div class="occasions-text">
        <h4>Occasions</h4>
        <h1>Shop By <span class="text-color" id="span">Occasions</span></h1>
    </div>

    <?php
    $occasions = [
        ['name' => "Wedding", 'icon' => 'images/weddings.png'],
        ['name' => "Graduation", 'icon' => 'images/graduation.png'],
        ['name' => "Birthday", 'icon' => 'images/bday.png'],
        ['name' => "Burial", 'icon' => 'images/burial.png']
    ];
    ?>

    <!-- FOR EACH -->
    <div class="occasions-icon">
        <?php foreach ($occasions as $occasion): ?>
            <a href="pages/catalogue.php?options[]=<?= urlencode($occasion['name']) ?>" class="occasion-link">
                <div class="occasion">
                    <button class="icon-button" type="button">
                        <img src="<?= $occasion['icon'] ?>" alt="<?= $occasion['name'] ?>">
                    </button>
                    <p><?= $occasion['name'] ?></p>
                </div>
            </a>
        <?php endforeach; ?>
    </div>



    <!-- DISCOUNT BANNER -->
    <div class="image-container">
        <?php
        while ($row = mysqli_fetch_assoc($disc)) {
            ?>
            <div class="image">
                <?php echo '<img src="data:image;base64, ' . base64_encode($row["discount_image"]) . '" alt="Discount Image">'; ?>
                <div class="overlay">
                    <div class="discount-wrap">
                        <div class="discount"><?php echo $row["percent"]; ?>% Discount</div>
                    </div>
                    <div class="image-title"><?php echo $row["discount_title"]; ?></div>
                    <div class="image-description2"><?php echo $row["discount_promo"]; ?></div>
                    <div class="image-description"><?php echo $row["discount_desc"]; ?></div>

                    <div class="shop-button">
                        <a href="pages/catalogue.php" class="shop-now-btn">Shop now →</a>
                    </div>
                </div>
            </div>
            <?php
        }
        ?>
    </div>

    <!-- HOME PAGE'S ABOUT -->
    <section class="home-about-content">
        <div class="home-about-desc" id="home-about-description">

            <h4>About Us</h4>
            <h2><span class="text-color" id="spanhome">Delivering Nature's</span><br>Beauty to Your Door</h2>

            <p>At Bloom Boutique, we believe that flowers have the power to brighten any moment,
                express emotions, and create lasting memories. Our passion for floral artistry
                drives us to craft exquisite arrangements that bring beauty and joy to every occasion.
                <br><br>
                With a commitment to quality, sustainability, and exceptional customer service, we ensure
                that every petal and arrangement tells a story of love and elegance. Visit our boutique or
                shop online to find the perfect floral expression for any moment.
                <br><br>
                🌸Bloom with us, because every flower has a story to tell🌸

                <br><br><br><br>
            </p>

            <div class="read-wrap">
                <a href="pages/about.php"><button class="read-more-btn">Read more...</button></a>
            </div>

        </div>

        <div id="home-image"><img src="images/homeAbout.png" alt="Bloom Boutique"></div>
    </section>

    <!-- TOP SELLER PRODUCTS -->
    <div class="our-products">
        <h4>Our Products</h4>
    </div>
    <div class="best-seller">
        <h2><strong>Our <span class="text-color" id="spanbest">Top Seller Products!</span></strong></h2>
        <a href="pages/catalogue.php">
            <button class="see-all-btn">See all</button>
        </a>
    </div>

    <div class="show-best"><!-- showcase div -->
        <div class="products-container-wrapper">
            <button id="prev-btn" class="scroll-btn prev-btn">&lt;</button>
            <div class="products-container">
                <?php
                if (mysqli_num_rows($best) > 0) {
                    while ($row = mysqli_fetch_assoc($best)) {
                        $price = $row["product_price"];
                        $discount = $row["product_discount"];
                        $finalPrice = ($discount > 0)
                            ? number_format($price - ($price * ($discount / 100)), 2)
                            : number_format($price, 2);
                        ?>
                        <div class="product-card">
                            <div class="bs-image">
                                <a href="pages/catalogue_product.php?product_id=<?php echo $row['product_id']; ?>">
                                    <img src="uploads/<?php echo htmlspecialchars($row["product_image"]); ?>"
                                        alt="Best Seller Image">
                                </a>
                            </div>
                            <div class="rating-occasion">
                                <p class="occasion-name"><?php echo htmlspecialchars($row["product_category"]); ?></p>
                                <div class="rating">
                                    <img src="images/star.png" alt="Star" width="15">
                                    <span>4.9</span>
                                </div>
                            </div>
                            <p class="product-name"><?php echo htmlspecialchars($row["product_name"]); ?></p>
                            <p class="price">
                                $<?php echo $finalPrice; ?>
                                <?php if ($discount > 0): ?>
                                    <span class="old-price"><del>$<?php echo number_format($price, 2); ?></del></span>
                                <?php endif; ?>
                            </p>
                        </div>
                        <?php
                    }
                } else {
                    echo "<p style='padding: 1rem;'>No bestsellers available at the moment.</p>";
                }
                ?>
            </div>
            <button id="next-btn" class="scroll-btn next-btn">&gt;</button>
        </div>
    </div><!-- end showcase div -->

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const container = document.querySelector('.products-container');
            const prevBtn = document.getElementById('prev-btn');
            const nextBtn = document.getElementById('next-btn');

            // Amount to scroll with each button click (adjust as needed)
            const scrollAmount = 300;

            // Function to check if buttons should be shown/hidden
            function checkButtons() {
                // Hide prev button if at start
                if (container.scrollLeft <= 0) {
                    prevBtn.classList.add('hide');
                } else {
                    prevBtn.classList.remove('hide');
                }

                // Hide next button if at end
                if (container.scrollLeft + container.clientWidth >= container.scrollWidth - 10) {
                    nextBtn.classList.add('hide');
                } else {
                    nextBtn.classList.remove('hide');
                }
            }

            // Previous button click
            prevBtn.addEventListener('click', function () {
                container.scrollLeft -= scrollAmount;
                setTimeout(checkButtons, 500); // Check after scroll animation completes
            });

            // Next button click
            nextBtn.addEventListener('click', function () {
                container.scrollLeft += scrollAmount;
                setTimeout(checkButtons, 500); // Check after scroll animation completes
            });

            // Check on scroll
            container.addEventListener('scroll', checkButtons);

            // Initial check
            checkButtons();
        });
    </script>


    <!-- DECLARATION (REVIEWS) -->
    <div class="reviews-section">
        <h4>Reviews</h4>
        <h2>What <span class="text-color">Our Clients Say</span></h2>
    </div>

    <div class="reviews"><!-- reviews -->
        <div class="reviews-container">
            <?php
            while ($row = mysqli_fetch_assoc($review)) {
                ?>
                <div class="feedback">
                    <div class="review-image">
                        <img src="images/reviewer.png" alt="Icon">
                        <p class="rev_name"><strong><?php echo $row["reviewer_name"]; ?></strong></p>
                    </div>

                    <div class="reviewer-rating">
                        <h3>⭐⭐⭐⭐⭐<h3>
                                <h5><?php echo $row["reviewer_rate"]; ?></h5>
                    </div>
                    <p class="review-message"><?php echo $row["review"]; ?></p>
                </div>
                <?php
            }
            ?>
        </div>
    </div><!-- end reviews -->

    <!-- FOOTER -->
    <footer>
        <div class="footer-container">

            <!-- LOGO AND DESCRIPTION -->
            <div class="section-logo">
                <img src="images/logoFooter.png" alt="Bloom Boutique Logo" class="footer-logo">
                <div class="underlogo-desc">
                    <p>Blooming marvelous bouquets, delivered with a smile.</p>
                </div>
            </div>

            <!-- GET IN TOUCH -->
            <div class="footer-sec">
                <h4><strong>Get in Touch</strong></h4>
                <div class="footer-items">
                    <img src="images/loc.png" alt="Location" class="footer-icon">
                    <p>8819 Ohio St. South Gate, CA 90280</p>
                </div>
                <div class="footer-items">
                    <img src="images/email.png" alt="Email" class="footer-icon">
                    <p>Ourstudio@hello.com</p>
                </div>
                <div class="footer-items">
                    <img src="images/call.png" alt="Phone" class="footer-icon">
                    <p>+1 386-688-3295</p>
                </div>
            </div>

            <!-- SOCIAL MEDIA -->
            <div class="footer-section">
                <div class="socmed-icons">
                    <a href="https://www.facebook.com/roselyn.m.s"><img src="images/fb.png" alt="FB"></a>
                    <a href="https://www.facebook.com/roselyn.m.s"><img src="images/ig.png" alt="IG"></a>
                    <a href="https://www.facebook.com/roselyn.m.s"><img src="images/grab.png" alt="GRAB"></a>
                    <a href="https://www.facebook.com/roselyn.m.s"><img src="images/gmail.png" alt="GMAIL"></a>
                </div>
                <p>Join us on our social media accounts!</p>
            </div>

            <!-- EMAIL SUBMISSION -->
            <div class="section-email">
                <h4><strong>Bloom Boutique</strong></h4>
                <p>Your Email</p>
                <form action="#" method="POST">
                    <input type="email" name="email" placeholder="Enter Your Email" class="email-input">
                    <button type="submit" class="sub-btn">Submit</button>
                </form>

            </div>
        </div>

        <!-- COPYRIGHT -->
        <div class="footer-bottom">
            <p>&copy; <?php echo date("Y"); ?> Bloom Boutique. All rights reserved.</p>
        </div>
    </footer>
</body>