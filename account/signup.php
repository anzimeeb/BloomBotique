<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create an account</title>
    <link rel="icon" href="../images/logob.png">
    <link rel="icon" href="../img/icon/whiteLogo.png" type="image/png" media="(prefers-color-scheme: dark)">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="shortcut icon" href="">
</head>

<body>
    <main>
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

                <div id="signup-logo">
                    <img src="../images/loginLogo.png" alt="Bloom Boutique">
                </div>

                <?php
                if (isset($_GET["error"])) {
                    if ($_GET["error"] == "emptyinput") {
                        echo "<p>Fill in all fields!</p>";
                    } elseif ($_GET["error"] == "invalidEmail") {
                        echo "<p>Invalid Email!</p>";
                    } elseif ($_GET["error"] == "pwdMatch") {
                        echo "<p>Password Does not Match!</p>";
                    } elseif ($_GET["error"] == "emailExist") {
                        echo "<p>Email Already Exist!</p>";
                    } elseif ($_GET["error"] == "stmtfailed") {
                        echo "<p>Something went wrong. Try Again!</p>";
                    }
                }
                ?>

                <!-- SIGNUP FORM -->
                <form method="POST" action="signup.inc.php" onsubmit="return validateSignupForm()">
                    <div id="in_same">
                        <div class="input-grp">
                            <label for="firstname">First Name</label>
                            <input type="text" name="fname" required>
                        </div>
                        <br>

                        <div class="input-grp">
                            <label for="lastname">Last Name</label>
                            <input type="text" name="lname" required>
                        </div>
                    </div>

                    <div id="in_same">
                        <div class="input-grp">
                            <label class="label">Phone Number</label>
                            <input type="text" name="pNumber">
                        </div>

                        <br>
                        <div class="input-grp">
                            <label class="label">Username</label>
                            <input type="text" name="user" required>
                        </div>
                    </div>

                    <label class="label">Email</label>
                    <input type="text" name="email" id="email" required>
                    <br>

                    <label class="label">Password</label>
                    <input type="password" name="pass" id="pass" required>
                    <br>

                    <label class="label">Re-Enter Password</label>
                    <input type="password" name="cpass" id="cpass" required>
                    <br>

                    <input type="submit" name="createaccsubmit" value="Sign Up">
                    <br>

                    <p>Already have an account? <a id="signup" href="login.php">Log In</a></p>
                </form>
            </div>
            <div id="login-image">
                <img src="../images/loginPic.png">
            </div>
        </section>
    </main>
</body>
<script>
    function validateSignupForm() {
        const email = document.getElementById("email").value;
        const password = document.getElementById("pass").value;
        const confirmPassword = document.getElementById("cpass").value;

        // Email check
        if (!email.includes("@") || !email.includes(".")) {
            alert("Please enter a valid email address.");
            return false;
        }

        // Password length check
        if (password.length < 8) {
            alert("Password must be at least 8 characters long.");
            return false;
        }

        // Password match check
        if (password !== confirmPassword) {
            alert("Passwords do not match.");
            return false;
        }

        return true; // ✅ Submit form
    }
</script>


</html>