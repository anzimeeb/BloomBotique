<?php
require '../account/PHPMailer-6.9.2/src/PHPMailer.php';
require '../account/PHPMailer-6.9.2/src/Exception.php';
require '../account/PHPMailer-6.9.2/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

date_default_timezone_set('Asia/Manila');

if(isset($_POST["forgotPasswordAdmin"])){
    $email = $_POST["email"];
    
    require_once "dba.inc.php";
    require_once 'functionsAdmin.inc.php';

    if(invalidEmail ($email)!==false){
        header("location:forgot-password.php?error=emptyinput");
        exit();
    }

    // Check if the email exists in the database
    $sql = "SELECT * FROM employeeUsers WHERE employeeEmail = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        die("Email not registered.");
    }
    
    else  {
        // Generate OTP
            $otp = rand(100000, 999999);
            $expiry = date("Y-m-d H:i:s", strtotime("+10 minutes")); // OTP valid for 10 minutes
            
        // Configure PHPMailer
        $mail = new PHPMailer(true);
        
        try {
            // Store OTP in the database
            otpInfoInsert($conn, $otp, $expiry, $email);
            
            echo $otp;
            
            // Server settings
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';         // Set mail server (e.g., Gmail SMTP server)
            $mail->SMTPAuth = true;
            $mail->Username = 'Yourkofishop@gmail.com'; // SMTP username
            $mail->Password = 'adkm joci tsbo xdlj'; // SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;
    
            // Recipients
            $mail->setFrom('Yourkofishop@gmail.com', 'Yourkofi');
            $mail->addAddress($email); // Add the recipient's email
    
            // Content
            $mail->isHTML(true);
            $mail->Subject = 'Admin OTP Code';
            $mail->Body = "Your OTP is <strong>$otp</strong>. It is valid for 10 minutes.";
    
            $mail->send();
            echo 'OTP sent successfully!';
            
            session_start();
            $_SESSION["employeeEmail"]=$email;
            
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
        
        header("location:otpInput-admin.php");
        exit();
    }
    
    


} else {
    header("location:forgotPassword.php?error=ayaw");
    exit();
}
?>