<?php

function emptyInputAddEmployee($firstname, $lastname, $email, $password, $password_confirm): bool {
    $result = true;
    if (empty($firstname) || empty($lastname) || empty($email) || empty($password) || empty($password_confirm)) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

function invalidEmail($email): bool {
    $result = true;
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

function pwdMatch($password, $password_confirm): bool {
    $result = true;
    if ($password !== $password_confirm) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

function emailExist($conn, $email, $username) {
    $sql = "SELECT * FROM employeeUsers WHERE employeeUsername = ? OR employeeEmail = ?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location:employee-add.php?error=stmtfailed");
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

function createEmployee($conn, $firstname, $lastname, $username, $email, $employeeShift, $password, $employeeRole) {
    $sql = "INSERT INTO employeeUsers (employeeFN, employeeLN, employeeUsername, employeeEmail, employeeShift, employeePassword, employeeRole) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location:employee.php?error=stmtfailed");
        exit();
    }

    $hashedPwd = password_hash($password, PASSWORD_DEFAULT);

    mysqli_stmt_bind_param($stmt, "sssssss", $firstname, $lastname, $username, $email, $employeeShift, $hashedPwd, $employeeRole);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location:employee.php?error=none");
    exit();
}

function isPasswordHashed($password): bool {
    // Bcrypt hashes are 60 characters long and typically start with "$2y$", "$2a$", or "$2b$"
    return (strlen($password) === 60 && preg_match('/^\$2[aby]\$.{56}$/', $password));
}

function hashPasswordForSpecificUser($conn, $username, $currentPassword) {
    // Check if the user exists in the database
    $sql = "SELECT * FROM employeeUsers WHERE employeeUsername = ? OR employeeEmail = ?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location:admin-login.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ss", $username, $username); // Bind username to both placeholders
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($resultData)) {
        // Verify the current password
        if (!password_verify($currentPassword, $row['employeePassword'])) {
            echo "Incorrect current password. Update failed.";
            return;
        }

        // You should now assign the new password here if it's not hashed yet
        $newPassword = $currentPassword; // This line assigns the new password to use it in the hashing step

        // Check if the new password is already hashed
        if (isPasswordHashed($newPassword)) {
            echo "New password is already hashed.";
        } else {
            echo "New password is not hashed. Hashing now...";
            // Hash the new password and update the record
            $hashedPwd = password_hash($newPassword, PASSWORD_DEFAULT);

            $updateSql = "UPDATE employeeUsers SET employeePassword = ? WHERE employeeUsername = ? OR employeeEmail = ?;";
            $updateStmt = mysqli_stmt_init($conn);
            if (!mysqli_stmt_prepare($updateStmt, $updateSql)) {
                header("location:admin-login.php?error=stmtfailed");
                exit();
            }

            mysqli_stmt_bind_param($updateStmt, "sss", $hashedPwd, $username, $username); // Bind parameters
            mysqli_stmt_execute($updateStmt);
            mysqli_stmt_close($updateStmt);

            echo "Password hashed and updated successfully for user: " . $username;
        }
    } else {
        echo "User not found.";
    }

    mysqli_stmt_close($stmt);
}

function emptyInputAdminLogin($email, $username, $password): bool {
    $result = true;
    if (empty($email || $username) || empty($password)) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

function loginAdmin($conn, $email, $password) {
    // Check if the email exists
    $emailExist = emailExist($conn, $email, $email);

    if ($emailExist == false) {
        header("location:admin-login.php?error=wronglogin");
        exit();
    }

    $pwdhashed = $emailExist["employeePassword"];

    // Check if the password is not hashed (if it has 60 characters or matches bcrypt hash format)
    if (strlen($pwdhashed) !== 60 || !preg_match('/^\$2[aby]\$.{56}$/', $pwdhashed)) {
        // If not hashed, hash it and update the database
        $hashedPwd = password_hash($password, PASSWORD_DEFAULT);

        // Update the password in the database
        $updateSql = "UPDATE employeeUsers SET employeePassword = ? WHERE employeeEmail = ? OR employeeUsername = ?;";
        $updateStmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($updateStmt, $updateSql)) {
            header("location:admin-login.php?error=stmtfailed");
            exit();
        }

        mysqli_stmt_bind_param($updateStmt, "sss", $hashedPwd, $email, $email);
        mysqli_stmt_execute($updateStmt);
        mysqli_stmt_close($updateStmt);

        echo "Password has been hashed and updated in the database.";
        $pwdhashed = $hashedPwd; // Now use the hashed password for verification
    }

    // Verify the password using password_verify
    $checkPwd = password_verify($password, $pwdhashed);

    if ($checkPwd == false) {
        // Password doesn't match, return to login page
        header("location:admin-login.php?error=wrongloginpassword");
        exit();
    } else if ($checkPwd == true) {
        // Password matches, start the session and log in
        session_start();
        $_SESSION["employeeEmail"] = $emailExist["employeeEmail"];
        $_SESSION["employeeUsername"] = $emailExist["employeeUsername"];
        header("location:product.php");
        exit();
    }
}

function otpInfoInsert($conn, $otp, $expiry, $email) {
    $sql = "INSERT INTO employeeotpinfo (otp, otp_expiry, email) VALUES (?, ?, ?)";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location:otpInput.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "sss", $otp, $expiry, $email);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

function renderTable($result, $columns) {
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<tr class="table-row">';
            foreach ($columns as $column) {
                echo '<td class="table-cell">' . htmlspecialchars($row[$column]) . '</td>';
            }
            echo '</tr>';
        }
    } else {
        echo '<tr><td colspan="' . count($columns) . '" class="table-cell">No data found.</td></tr>';
    }
}
?>
