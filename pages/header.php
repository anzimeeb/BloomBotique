<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>
        <?php
            // Get the current page name without the extension
            $currentPage = basename($_SERVER['PHP_SELF'], ".php"); 
        
            // Check if the current page is 'eachmenu'
            if ($currentPage === "eachmenu") {
                // Get the productName from the query string
                $productName = isset($_GET['productName']) ? $_GET['productName'] : "Product"; // Default to "Product" if not set
                echo htmlspecialchars(urldecode($productName)); // Decode and sanitize the product name for output
            } else {
                // Format the page name for other pages
                $formattedPage = ucfirst(str_replace('-', ' ', $currentPage)); // Capitalize and replace hyphens with spaces
                echo $formattedPage;
            }
        ?>
        </title>
    <link rel="icon" href="../images/logob.png">
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
<header>
    <!-- NAVIGATION/HEADER -->
    <div class="navbar">
        <div class="leftside">
            <div class="headerlogo">
                <a href="#"><img src="../images/navlogo.png"></a>
            </div>
        </div>
        <ul class="navigation">
            <li><a href="../index.php" <?php if(basename($_SERVER['PHP_SELF']) == '../index.php') echo 'class="active"'; ?>>Home</a></li>
            <li><a href="catalogue.php" <?php if(basename($_SERVER['PHP_SELF']) == 'catalogue.php') echo 'class="active"'; ?>>Catalogue</a></li>
            <li><a href="about.php" <?php if(basename($_SERVER['PHP_SELF']) == 'about.php') echo 'class="active"'; ?>>About Us</a></li>
            <li><a href="contact.php" <?php if(basename($_SERVER['PHP_SELF']) == 'contact.php') echo 'class="active"'; ?>>Contact Us</a></li>
            <li><a href="cart.php" <?php if(basename($_SERVER['PHP_SELF']) == 'cart.php') echo 'class="active"'; ?>>Cart</a></li>
            <li><a href="faqs.php" <?php if(basename($_SERVER['PHP_SELF']) == 'faqs.php') echo 'class="active"'; ?>>FAQS</a></li>
        </ul>
        <div class="auth-links">
                <?php
                if (isset($_SESSION["customerEmail"])) {
                    echo '<a href="profile_personalInfo.php" class="login-btn">Hi! <img src="../images/profile.png" alt="Profile"></a>';
                } else {
                    echo '<a href="../account/login.php" class="login-btn"><svg xmlns="http://www.w3.org/2000/svg" width="16"
                        height="16" fill="bg-purple-custom" class="bi bi-person-fill" viewBox="0 0 16 16">
                        <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6" />
                    </svg>Login</a> |
                <a href="../account/signup.php" class="signup-btn">Signup</a>';
                } ?>
            </div>
    </div>
</header>
</body>