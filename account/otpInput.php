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
    <link rel="icon" href="../images/logob.png">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="shortcut icon" href="">
</head>

<body> 
        <section class="account">
            <div class="login-container" id="login-form1">
                <div class="back-button-container">
                    <button onclick="goBack()" class="back-button">
                        <img src="../images/back.png" alt="back">
                    </button>
                </div>
                
                <script>
                    function goBack() {
                        window.history.back();
                        }
                </script>

                <div id="login-logo">
                    <img src="../images/otp.png" alt="Bloom Boutique">
                </div>

                <!-- <h2>Enter your OTP</h2> -->
                <p class="otp-message">Please enter the OTP code that has been sent to your email.</p>

                <?php
                if(isset($_GET["error"])){
                    if($_GET["error"] == "emptyinput"){
                        echo "<p>Fill in all fields!</p>";
                    } elseif($_GET["error"] == "wronglogin"){
                        echo "<p>Incorrect Login Information!</p>";
                    }
                }
                ?>

                <!-- OTP FORM -->
                <form action="otpInput.inc.php" method="POST">
                    <input type="text" name="otp" placeholder="Enter OTP" required>
                    <br>
                    <input type="submit" name="otpCheck" value="Verify Code">
                    <br>
                    <p>Back to <a id="signup" href="login.php">Log In</a></p>
                </form>
            </div>

            <div id="login-image">
                <img src="../images/loginPic.png">
            </div>
        </section>