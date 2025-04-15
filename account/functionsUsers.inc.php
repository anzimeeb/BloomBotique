<?php

function emptyInputSignup($firstname, $lastname, $username, $email, $password, $password_confirm): bool
{
    $result = true;
    if (empty($firstname) || empty($lastname) || empty($username) || empty($email) || empty($password) || empty($password_confirm)) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

function invalidEmail($email): bool
{
    $result = true;
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

function pwdMatch($password, $password_confirm): bool
{
    $result = true;
    if ($password !== $password_confirm) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

function emailExist($conn, $email, $username)
{
    $sql = "SELECT * FROM customerinfo WHERE customerEmail = ? OR customerUsername =?;";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location:signup.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ss", $email, $username);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($resultData)) {
        mysqli_stmt_close($stmt); // Close statement before returning
        return $row;
    } else {
        mysqli_stmt_close($stmt); // Close statement before returning
        return false;
    }
}

function createUser($conn, $firstname, $lastname, $pNumber, $username, $email, $password, $password_confirm)
{
    // Check if passwords match
    if ($password !== $password_confirm) {
        header("location:signup.php?error=passwordsdonotmatch");
        exit();
    }

    // Prepare the SQL query to insert data into customerinfo
    $sql = "INSERT INTO customerinfo (customerFN, customerLN, phone_number, customerUsername, customerEmail, customerPassword) 
            VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_stmt_init($conn);

    // Check if the statement preparation is successful
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location:signup.php?error=stmtfailed");
        exit();
    }

    // Hash the password for security
    $hashedPwd = password_hash($password, PASSWORD_DEFAULT);

    // Bind parameters to the SQL query
    mysqli_stmt_bind_param($stmt, "ssssss", $firstname, $lastname, $pNumber, $username, $email, $hashedPwd);

    // Execute the statement
    mysqli_stmt_execute($stmt);

    // Close the prepared statement
    mysqli_stmt_close($stmt);

    // Redirect the user after successful account creation
    header("location:signup.php?error=none");
    header("location:login.php");
    exit();
}

function emptyInputLogin($email, $password)
{
    $result = true;
    if (empty($email) || empty($password)) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

function loginUser($conn, $email, $username, $password)
{
    $emailExist = emailExist($conn, $email, $username);

    if ($emailExist == false) {
        header("location:login.php?error=wronglogin");
        exit();
    }

    $pwdhashed = $emailExist["customerPassword"];
    $checkPwd = password_verify($password, $pwdhashed);
    if ($checkPwd == false) {
        header("location:login.php?error=wronglogin");
        exit();
    } else if ($checkPwd == true) {
        session_start();
        $_SESSION["customerEmail"] = $emailExist["customerEmail"];
        echo "<br>login successfully<br>";
        // Get the redirect from POST, not GET
        $redirect = isset($_POST['redirect']) ? $_POST['redirect'] : '';

        if ($redirect === 'tocart') {
            header("Location: ../pages/cart.php");
        } else {
            header("Location: ../index.php");
        }
    }
}

function otpInfoInsert($conn, $otp, $expiry, $email)
{
    $sql = "INSERT INTO customerotpinfo (otp, otp_expiry, email) VALUES (?, ?, ?)";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location:otpInput.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "sss", $otp, $expiry, $email);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

?>