<?php
    require_once 'header.php';
    require_once '../connection.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Completed</title>
    <link rel="icon" href="images/logob.png">
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <!-- BANNER IMAGE -->
    <div class="banner2">
        <img src="../images/banner2.jpg" alt="BLOOM BOUTIQUE">
        <h1 class="banner-title">ORDER COMPLETED</h1>
    </div>
    
    <div class="oc">

        <div class="confirm-complete">
            <img src="../images/ordercomplete_check.png" alt="">
            <p><strong>Your Order is Completed!</strong></p>
            <p>Thank you, your order has been received.</p>
        </div>

        <div class="group-order-completed">
            <div class="column-order">            
                <label id="ordercomplete" for="order-dits">Order details</label>
                <p class="get-details">#00012837482</p>
            </div>
            <hr class="vertical-divider">

            <div class="column-order">
                <label id="ordercomplete" for="payment-meth">Payment Method</label>
                <p class="get-details">Paypal</p>
            </div>
            <hr class="vertical-divider">

            <div class="column-order">
                <label id="ordercomplete" for="transid">Transaction ID</label>
                <p class="get-details">TR467295028</p>
            </div>
            <hr class="vertical-divider">

            <div class="column-order">
                <label id="ordercomplete" for="estimated">Estimated Delivery Date</label>
                <p class="get-details">02/20/25</p>
            </div>
        </div>

        <div class="ordercomplete">
            <p class="order-deitals">Order Details</p>
            <hr class="horizontal-divider">

                <div class="ordercomplete-title">
                    <p>Products</p>
                    <p>Sub Total</p>
                </div>

            <div class="completeorder-contents">
                <img src="../images/catalogue/blush_of_love.png" alt="">
                <div class="grouped-namecateg">
                    <p class="bouquet-name">Blush of Love</p>
                    <p class="bouquet-categ">Wedding</p>
                </div>

                <div class="ordercomplete-subtotal">
                    <p class="ordercomplete-subprice">Php 750.00</p>
                </div>
            </div>

            <div class="completeorder-contents">
                <img src="../images/catalogue/blush_of_love.png" alt="">
                <div class="grouped-namecateg">
                    <p class="bouquet-name">Blush of Love</p>
                    <p class="bouquet-categ">Wedding</p>
                </div>

                <div class="ordercomplete-subtotal">
                    <p class="ordercomplete-subprice">Php 750.00</p>
                </div>
            </div>

            <hr class="horizontal-divider">
                <div class="other-details">
                    <p class="shipping-fee">Shipping</p>
                    <p class="shipping-price">Php 750.00</p>
                </div>
            <hr class="horizontal-divider">
                <div class="other-details">
                    <p class="total-fee">Total</p>
                    <p class="total-price">Php 750.00</p>
                </div>
                </div> <!--order complete end -->
        </div>

    <?php include_once 'footer.php'; ?>
</body>