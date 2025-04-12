<?php
session_start();

if (!isset($_SESSION['employeeEmail'])){
    header("location:forget-password.php");
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
    <link rel="stylesheet" href="../css/admin.css">
    <link rel="shortcut icon" href="">
</head>

<body>
    <main>
        <section class="account">
            <div class="login-container" id="account-item1">
                <h2>Enter your OTP</h2>

                <p>OTP has been sent to your email.</p>

                <form action="otpInput-admin.inc.php" method="POST">
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