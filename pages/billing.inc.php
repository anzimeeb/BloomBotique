<?php
session_start();
require_once '../connection.php';
require_once 'functionsPages.inc.php';

if (isset($_POST['placedorder']) && isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];
    $orderId = placeOrder($conn, $userId, $_POST);

    if ($orderId) {
        header("Location: ../pages/order-confirmation.php?order=$orderId");
        exit();
    } else {
        echo "Something went wrong placing the order.";
    }
} else {
    header("Location: ../pages/billing.php");
    exit();
}
