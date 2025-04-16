<?php
session_start();
require_once '../connection.php';  // Include the DB connection

// Check if the user is logged in
if (!isset($_SESSION['customerEmail'])) {
    header("Location: login.php");  // Redirect to login if not logged in
    exit;
}

if (isset($_POST['current-password'], $_POST['new-password'], $_POST['confirm-password'])) {
    $email = $_SESSION['customerEmail'];  // Get the email from the session
    $currentPassword = $_POST['current-password'];  // The current password entered
    $newPassword = $_POST['new-password'];  // The new password entered
    $confirmPassword = $_POST['confirm-password'];  // The confirmed new password

    // Sanitize inputs
    $currentPassword = mysqli_real_escape_string($conn, $currentPassword);
    $newPassword = mysqli_real_escape_string($conn, $newPassword);
    $confirmPassword = mysqli_real_escape_string($conn, $confirmPassword);

    // Fetch the user's data from the database
    $query = "SELECT customerPassword FROM customerinfo WHERE customerEmail = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    // Check if the current password is correct
    if (password_verify($currentPassword, $user['customerPassword'])) {
        // Check if the new password matches the confirm password
        if ($newPassword === $confirmPassword) {
            // Check if the new password is strong enough (optional)
            if (strlen($newPassword) >= 8) {  // Example: minimum 8 characters
                // Hash the new password before storing
                $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

                // Update the password in the database
                $updateQuery = "UPDATE customerinfo SET customerPassword = ? WHERE customerEmail = ?";
                $updateStmt = $conn->prepare($updateQuery);
                $updateStmt->bind_param('ss', $hashedPassword, $email);

                if ($updateStmt->execute()) {
                    echo "Password updated successfully!";
                    // Optionally, redirect the user back to their profile page
                    header("Location: profile_personalInfo.php?message=success");
                    exit;
                } else {
                    echo "Error updating password: " . mysqli_error($conn);
                }
            } else {
                echo "New password must be at least 8 characters long.";
            }
        } else {
            echo "New password and confirmation password do not match.";
        }
    } else {
        echo "Current password is incorrect.";
    }
} else {
    echo "All fields are required.";
}
?>
