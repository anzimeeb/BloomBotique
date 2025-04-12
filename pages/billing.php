<?php
    require_once 'header.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Billing</title>
    <link rel="icon" href="images/logob.png">
    <link rel="stylesheet" href="../style.css">
</head>

<!-- BANNER IMAGE -->
<div class="banner2">
    <img src="../images/banner2.jpg" alt="BLOOM BOUTIQUE">
    <h1 class="banner-title">BILLING</h1>
</div>

<!-- BILLING -->
<section class="billing-main"><!-- main -->
<div class="billing-container" id="billing-form1"><!-- left side -->
        <form  action=" " method="POST">
            <h3>Billing Details</h3>
            <div id="billing-info">
                <div class="bill-input-grp">
                    <label for="firstname">First Name</label>
                    <input type="text" name="firstname" required>
                </div>
                <br>

                <div class="bill-input-grp">
                    <label for="lastname">Last Name</label>
                    <input type="text" name="lastname">
                </div>
            </div>

                    <label class="billing-label">Street Address</label>
                    <input type="text" name="streetadd" required>
                    <br>

                    <label class="billing-label">City</label>
                    <input type="text" name="city" required>
                    <br>

                    <label class="billing-label">State</label>
                    <input type="text" name="state" required>
                    <br>

                    <label class="billing-label">Zip Code</label>
                    <input type="text" name="zipcode" required>
                    <br>

                    <label class="billing-label">Phone</label>
                    <input type="text" name="bill-phone" required>
                    <br>

                    <label class="billing-label">Email</label>
                    <input type="text" name="bill-email" required>
                    <br>

                    <label class="billing-label">Delivery Address</label>
                    <div class="continer"><!-- radio button -->
                        <div class="form-check border">
                            <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
                            <label class="form-check-label" for="flexRadioDefault1">
                            Same as Shipping Address
                            </label>
                        </div>
                        <div class="form-check border">
                            <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" checked>
                            <label class="form-check-label" for="flexRadioDefault2">
                            New Address
                            </label>
                        </div>
                    </div><!-- end radio button -->
        </form>
    </div><!-- end left side -->

<!-- ORDER SUMMARY -->
<div class="order-summary"><!-- right side -->
    <div class="summary-container"><!-- summary container -->
        <div class="order-name">
            <h4>Order Summary</h4>
        </div>
        <hr class="gray">

        <div class="summary-details">
            <p>Items</p>
            <p class="items">4</p>
        </div>

        <div class="summary-details">
            <p>Sub Total</p>
            <p class="items">$3,000</p>
        </div>

        <div class="summary-details">
            <p>Shipping</p>
            <p class="items">$150</p>
        </div>

        <div class="summary-details">
            <p>Cash on Delivery</p>
        </div>

        <hr class="gray">

        <div class="summary-details">
            <p>Total</p>
            <p class="items">$3,150</p>
        </div>

        <br>

        <form action="order_completed.php" method="POST">
            <div class="proceed">
                <button type="submit" name="proceed-ordercomplete" class="proceed-button">Proceed to Payment</button>
            </div>
        </form>

        <br>
    </div><!-- end summary container -->
    <br>
</div><!-- end right side -->
<!-- END ORDER SUMMARY -->
</section>

<?php include_once'footer.php';?>