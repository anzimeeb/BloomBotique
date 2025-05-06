<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link rel="icon" href="../img/icon/coffeLogo.png" type="image/png" media="(prefers-color-scheme: light)">
    <link rel="icon" href="../img/icon/whiteLogo.png" type="image/png" media="(prefers-color-scheme: dark)">
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
                    <img src="../images/loginLogo.png" alt="Bloom Boutique">
                </div>

                <p>Lost your access? Let’s find it.</p>
            
                <?php
                if(isset($_GET["error"])){
                    if($_GET["error"] == "emptyinput"){
                        echo "<p>Fill in all fields!</p>";
                    } elseif($_GET["error"] == "wronglogin"){
                        echo "<p>Incorrect Login Information!</p>";
                    }
                }
                ?>

                <!-- FORGOT PASSWORD FORM -->
                <form action="forgotPassword.inc.php" method="POST">
                    <label class="label">Email</label>
                    <input type="text" name="email" placeholder="Email" required>
                    <br>
                    <input type="submit" name="forgotPasswordUser" value="Send OTP">
                    <br>
                    <p>Back to <a id="signup" href="login.php">Log In</a></p>
                </form>
                </div>
            <div id="login-image">
                <img src="../images/loginPic.png">
            </div>
            
        </section>
 
</body>
</hmtl>