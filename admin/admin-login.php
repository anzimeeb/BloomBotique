<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="icon" href="../img/icon/coffeLogo.png" type="image/png" media="(prefers-color-scheme: light)">
    <link rel="icon" href="../img/icon/whiteLogo.png" type="image/png" media="(prefers-color-scheme: dark)">
    <link rel="stylesheet" href="../css/admin.css">
    <link rel="shortcut icon" href="">
</head>

<body>
        <section class="account">
            <div class="login-container" id="login-form1">

            <div id="login-logo">
                <img src="../images/loginLogo.png" alt="Bloom Boutique">
            </div>

            <p class="admin-message">Glad to Have You, Admin! <br> Keeping the Business Flowing, One Click at a Time.</p>
                
                <?php
                if(isset($_GET["error"])){
                    if($_GET["error"] == "emptyinput"){
                        echo "<p>Fill in all fields!</p>";
                    } elseif($_GET["error"] == "wronglogin"){
                        echo "<p>Incorrect Login Information!</p>";
                    }
                }
                ?>
                
                <!-- Login Form -->
                <!-- <form method="POST" action="admin-login.inc.php">
                    <input type="text" name="username" placeholder="Username/Email" required>
                    <br>
                    <input type="password" name="password" placeholder="Password" required>
                    <br>
                    <a id="forgotpw" href="forgot-password.php">Forgot Password?</a>
                    <br>
                    <input type="submit" value="Sign In" name="loginadmin">
                </form>
            </div>
            <div id="account-item2">
                <img src="../img/adminlogin.png">
            </div> -->

            

            <form method="POST" action="admin-login.inc.php">
                    <label class="label">Email</label>
                    <input type="text" name="username" required><br>
                    <label class="label">Password</label>
                    <input type="password" name="password" required><br>
                    <a id="forgotpw" href="forgot-password.php">Forgot Password?</a>
                    <br>
                    <input type="submit" name="loginadmin" value="Login"><br>
                </form>
        </div>
            <div id="login-image"><img src="../images/loginPic.png"></div>
        </section>
</body>

</html>