<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="icon" href="../images/logob.png" type="image/png" media="(prefers-color-scheme: light)">
    <link rel="icon" href="../images/logob.png" type="image/png" media="(prefers-color-scheme: dark)">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="shortcut icon" href="">
</head>

<body>
    <section class="account">
        <div class="login-container" id="login-form1">
                <div id="login-logo">
                <img src="../images/loginLogo.png" alt="Bloom Boutique">
                </div>

                <!-- LOGIN FORM -->
                <form method="POST" action="login.inc.php">
                    <label class="label">Email</label>
                    <input type="text" name="email" required><br>
                    <label class="label">Password</label>
                    <input type="password" name="pass" required><br>
                    <a id="forgotpw" href="forgotpassword.php">Forgot Password?</a><br>
                    <input type="hidden" name="redirect" value="<?= isset($_GET['redirect']) ? htmlspecialchars($_GET['redirect']) : '' ?>">
                    <input type="submit" name="login" value="Login"><br>
                    <p>Don't have an account? <a id="signup" href="signup.php">Sign Up</a></p>
                </form>
        </div>
            <div id="login-image"><img src="../images/loginPic.png"></div>
    </section>
</body>

</html>