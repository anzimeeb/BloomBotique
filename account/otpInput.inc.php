<?php
require 'PHPMailer-6.9.2/src/PHPMailer.php';
require 'PHPMailer-6.9.2/src/Exception.php';
require 'PHPMailer-6.9.2/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
date_default_timezone_set('Asia/Manila'); // Ensure timezone is set

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (isset($_POST["otpCheck"])) {
    session_start();

    // Validate session and input
    if (!isset($_SESSION["customerEmail"])) {
        die("Session expired. Please try again.");
    }

    $email = $_SESSION["customerEmail"];
    $otp = $_POST['otp'];

    require 'dbu.inc.php'; // Database connection

    // Fetch OTP details from the database
    $sql = "SELECT otp, otp_expiry FROM customerotpinfo WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        die("Invalid email or OTP not generated.");
    }

    $row = $result->fetch_assoc();

    // Compare OTP and expiration
    $currentDateTime = new DateTime(); // Current server time
    $otpExpiry = new DateTime($row['otp_expiry']); // Convert string to DateTime

    if ($otp != $row['otp']) {
        die("Invalid OTP.");
    }

    if ($currentDateTime > $otpExpiry) {
        die("OTP has expired.");
    }

    // OTP verified, redirect to reset password form
    header("Location: resetPassword.php?email=" . urlencode($email));
    exit();
}
?>
