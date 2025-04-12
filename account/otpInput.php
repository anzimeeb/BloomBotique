<?php
session_start();

if (!isset($_SESSION['customerEmail'])){
    header("location:forgotPassword.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP Input</title>
    <link rel="icon" href="../img/icon/coffeLogo.png" type="image/png" media="(prefers-color-scheme: light)">
    <link rel="icon" href="../img/icon/whiteLogo.png" type="image/png" media="(prefers-color-scheme: dark)">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="shortcut icon" href="">
</head>

<body>
    <!-- <header>
        <div class="navbar">
            <div class="left-menu">
                <a href="../index.php">Home</a>
                <a href="../pages/menu.php">Menu</a>
                <a href="../pages/find-a-store.php">Find a Store</a>
            </div>
            <div class="logo">
                <a href="../index.php"><img src="../img/logoF.png"></a>
            </div>
            <div class="right-menu">
                <a href="#">Contact Us</a>
                <input type="text" class="search-bar" placeholder="Search">
                <a class="icon" href="../cart/cart.php"><img src="../img/shoppingcart.png" alt="Cart"></a>
                <a class="icon" href="login.php"><img src="../img/user.png" alt="User"></a>
            </div>
        </div>
        
        <img src="../img/logoF.png" class="hdImg">
        <div id="menuToggleContainer">
            <nav role="navigation">
                <div id="menuToggle">
                    <input type="checkbox">
                    <span></span>
                    <span></span>
                    <span></span>
                    <ul id="menu">
                        <a href="../index.php">
                            <li>Home</li>
                        </a>
                        <a href="../pages/menu.php">
                            <li>Menu</li>
                        </a>
                        <a href="../pages/ourstory.php">
                            <li>Our Story</li>
                        </a>
                        <a href="../pages/contactus.php">
                            <li>Contact Us</li>
                        </a>
                        <a href="../cart/cart.php">
                            <li>Cart</li>
                        </a>
                        <?php
                        if (isset($_SESSION["customerEmail"])) {
                            echo '<a href="../pages/profile.php"><li>Profile Hi!</li></a>';
                        } else {
                            echo '<a href="login.php"><li>Login</li></a>';
                            echo '<a href="signup.php"><li>Signup</li></a>';
                        }
                        ?>
                    </ul>
                </div>
            </nav>
        </div>
    </header> -->
    
    <main>
        <section class="account">
            <div class="login-container" id="account-item1">
                <h2>Enter your OTP</h2>

                <p>OTP has been sent to your email.</p>

                <?php
                if(isset($_GET["error"])){
                    if($_GET["error"] == "emptyinput"){
                        echo "<p>Fill in all fields!</p>";
                    } elseif($_GET["error"] == "wronglogin"){
                        echo "<p>Incorrect Login Information!</p>";
                    }
                }
                ?>

                <form action="otpInput.inc.php" method="POST">
                    <input type="text" name="otp" placeholder="OTP" required>
                    <br>
                    <input type="submit" name="otpCheck" value="Verify Code">
                    <br>
                </form>
            </div>
            <div id="account-item2">
                <img src="../img/p_signup.png">
            </div>
        </section>
    </main>

    
</body>
</hmtl>