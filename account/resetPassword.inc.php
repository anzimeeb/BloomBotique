<?php
// Display errors for debugging (remove or suppress in production)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Start session
session_start();

    require 'dbu.inc.php'; // Database connection


// Check if form is submitted
if (isset($_POST['resetPassword'])) {
    // Validate input
    $email = $_SESSION['customerEmail'];
    $newPassword = $_POST['newPassword'];
    $confirmPassword = $_POST['confPassword'];

    if (empty($email) || empty($newPassword) || empty($confirmPassword)) {
        die("All fields are required.");
    }

    if ($newPassword !== $confirmPassword) {
        die("Passwords do not match.");
    }

    // Hash the new password securely
    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

    // Update the database with the new password
    $sql = "UPDATE customerinfo SET customerPassword = ? WHERE customerEmail = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $hashedPassword, $email);

    if ($stmt->execute()) {
        // Password updated successfully
        echo "Password has been reset successfully.";
        // Redirect to login page or success page
        // Function to delete OTP after successful password update
    
    function deleteOTP($conn, $email) {
        $sql = "DELETE FROM customerotpinfo WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email); // Binding the email to delete OTPs associated with it
        $stmt->execute();
    }
    
    deleteOTP($conn, $email);

        header("Location: login.php?reset=success");
        exit();
    } else {
        // Handle database error
        echo "Error resetting password. Please try again.";
    }
} else {
    // Redirect to the reset password form if accessed improperly
    header("Location: resetPassword.php?error=unauthorizedimporper");
    exit();
}
