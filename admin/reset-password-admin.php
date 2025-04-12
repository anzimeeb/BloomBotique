<?php
session_start();

if (!isset($_SESSION['employeeEmail'])){
    header("location:forgot-password.php");
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
    <link rel="stylesheet" href="../css/main.css">
    <link rel="shortcut icon" href="">
</head>

<body>    
    <main>
        <section class="account">
            <div class="login-container" id="account-item1">
                <h2>Reset Admin Password</h2>

                <p>Reset you taste with our coffee!</p>

                <?php
                if(isset($_GET["error"])){
                    if($_GET["error"] == "emptyinput"){
                        echo "<p>Fill in all fields!</p>";
                    } elseif($_GET["error"] == "wronglogin"){
                        echo "<p>Incorrect Login Information!</p>";
                    }
                }
                ?>

                <form action="reset-password-admin.inc.php" method="POST">
                    <input type="password" name="newPassword" placeholder="New Password" required>
                    <br>
                    <input type="password" name="confPassword" placeholder="Confirm Password" required>
                    <br>
                    <input type="submit" name="reset-password-admin" value="Reset Password">
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