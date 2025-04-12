<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link rel="icon" href="../img/icon/coffeLogo.png" type="image/png" media="(prefers-color-scheme: light)">
    <link rel="icon" href="../img/icon/whiteLogo.png" type="image/png" media="(prefers-color-scheme: dark)">
    <link rel="stylesheet" href="../css/admin.css">
    <link rel="shortcut icon" href="">
</head>

<body>
    <main>
        <section class="account">
            <div class="login-container" id="account-item1">
                <h2>Forgot Password</h2>

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

                <form action="forgot-password.inc.php" method="POST">
                    <input type="text" name="email" placeholder="Email" required>
                    <br>
                    <input type="submit" name="forgotPasswordAdmin" value="Send OTP">
                    <br>
                </form>
            </div>
            <div id="account-item2">
                <img src="../img/forgot.png">
            </div>
        </section>
    </main>

    
</body>
</hmtl>