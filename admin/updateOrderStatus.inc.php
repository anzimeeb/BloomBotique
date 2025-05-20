<?php
require_once 'dba.inc.php'; // Include the database connection
require '../account/PHPMailer-6.9.2/src/PHPMailer.php';
require '../account/PHPMailer-6.9.2/src/Exception.php';
require '../account/PHPMailer-6.9.2/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

date_default_timezone_set('Asia/Manila');

if (isset($_POST['order_id']) && isset($_POST['order_status']) && isset($_POST['email'])) {
    $orderId = intval($_POST['order_id']);
    $orderStatus = $_POST['order_status'];
    $email = $_POST['email'];

    // Update order status
    $sql = "UPDATE orders SET order_status = ? WHERE order_id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("si", $orderStatus, $orderId);
        if ($stmt->execute()) {
            // Send email
            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'Yourkofishop@gmail.com';
                $mail->Password = 'adkm joci tsbo xdlj';
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;

                $mail->setFrom('Yourkofishop@gmail.com', 'Bloom Boutique');
                $mail->addAddress($email);

                $mail->isHTML(true);
                $mail->Subject = 'Your Bloom Boutique Order Update';
                $mail->Body = "<div style='font-family: Arial, sans-serif; padding: 20px;'>
                                    <h2 style='color: #d63384;'>Order Update from Bloom Boutique</h2>
                                    <p>Hi there,</p>
                                    <p>We're reaching out to let you know that the status of your order <strong>#{$orderId}</strong> has been updated to:</p>
                                    <p style='font-size: 18px; font-weight: bold; color: #28a745;'>$orderStatus</p>
                                    <p>Thank you for shopping with us! We hope you enjoy your beautiful blooms.</p>
                                    <p style='margin-top: 30px;'>Best regards,<br>Bloom Boutique Team</p>
                                </div>";

                $mail->send();
                session_start();
                $_SESSION["customerEmail"] = $email;
            } catch (Exception $e) {
                echo "Mailer Error: {$mail->ErrorInfo}";
                exit();
            }

            header("Location: orders.php?message=success");
            exit();
        } else {
            echo "Error updating order status.";
            exit();
        }
    } else {
        echo "Failed to prepare the SQL statement.";
        exit();
    }
} else {
    header("Location: orders.php?error=invalid_request");
    exit();
}
