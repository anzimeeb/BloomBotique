<?php
session_start();

if (!isset($_SESSION['employeeEmail'])) {
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
                if (isset($_GET["error"])) {
                    if ($_GET["error"] == "emptyinput") {
                        echo "<p>Fill in all fields!</p>";
                    } elseif ($_GET["error"] == "wronglogin") {
                        echo "<p>Incorrect Login Information!</p>";
                    }
                }
                ?>

                <form action="reset-password-admin.inc.php" method="POST" onsubmit="return validatePassword()">
                    <input type="password" name="newPassword" id="newPassword" placeholder="New Password" required>
                    <br>
                    <input type="password" name="confPassword" id="confPassword" placeholder="Confirm Password"
                        required>
                    <br>
                    <small id="passwordError" style="color:red; display:none;">Passwords must be at least 8 characters
                        and match.</small>
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

    <script>
        function validatePassword() {
            const newPassword = document.getElementById("newPassword").value;
            const confPassword = document.getElementById("confPassword").value;
            const errorText = document.getElementById("passwordError");

            if (newPassword.length < 8 || newPassword !== confPassword) {
                errorText.style.display = "block";
                return false;
            }

            errorText.style.display = "none";
            return true;
        }
    </script>



</body>
</hmtl>