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
    <title>Reset Password</title>
    <link rel="icon" href="../img/icon/coffeLogo.png" type="image/png" media="(prefers-color-scheme: light)">
    <link rel="icon" href="../img/icon/whiteLogo.png" type="image/png" media="(prefers-color-scheme: dark)">
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <section class="account">
        <div class="login-container" id="login-form1">
            <!-- Logo -->
            <div id="login-logo">
                <svg xmlns="http://www.w3.org/2000/svg" width="230" height="230" fill="currentColor" class="bi bi-lock"
                    viewBox="0 0 16 16">
                    <path
                        d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2m3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2M5 8h6a1 1 0 0 1 1 1v5a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V9a1 1 0 0 1 1-1" />
                </svg>
            </div>

            <!-- Heading -->
            <h2>Reset Password</h2>
            <p class="otp-message">Don't waste your time, just enjoy your coffee.</p>

            <!-- Error Handling -->
            <?php
            if (isset($_GET["error"])) {
                if ($_GET["error"] == "emptyinput") {
                    echo "<p>Fill in all fields!</p>";
                } elseif ($_GET["error"] == "wronglogin") {
                    echo "<p>Incorrect Login Information!</p>";
                }
            }
            ?>

            <!-- Reset Password Form -->
            <form action="resetPassword.inc.php" method="POST">
                <input type="password" name="newPassword" placeholder="New Password" required>
                <br>
                <input type="password" name="confPassword" placeholder="Confirm Password" required>
                <br>
                <input type="submit" name="resetPassword" value="Reset Password">
                <br>
            </form>
        </div>

        <div id="login-image">
            <img src="../images/loginPic.png">
        </div>
    </section>
</body>

</html>