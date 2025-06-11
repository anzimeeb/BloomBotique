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
                //try this on your own
                    
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
