<?php
require_once 'header.php';
require_once '../connection.php';

session_start();

if (!isset($_SESSION['customerEmail'])) {
    header("location:admin-login.php");
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $profile_firstname = $_POST['profile-fname'];
    $profile_lastname = $_POST['profile-lname'];
    $profile_email = $_POST['profile-email'];
    $profile_phone = $_POST['profile-phone'];

    if (!empty($profile_email) && !empty($profile_phone)) {
        // Update user profile code would go here
        echo "<script>alert('Profile updated successfully!');</script>";
    } else {
        echo "<script>alert('Please fill up all the fields.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="icon" href="images/logob.png">
    <link rel="stylesheet" href="../style.css">
</head>

<body>
    <!-- BANNER IMAGE -->
    <div class="banner2">
        <img src="../images/banner2.jpg" alt="BLOOM BOUTIQUE">
        <h1 class="banner-title">YOUR PROFILE</h1>
    </div>

    <div class="profile-main-container"><!-- main div -->
        <!-- LEFT SIDE: NAVIGATION OPTIONS -->
        <nav class="profile-options">
            <a href="#profinfo" class="nav-button active" data-target="profinfo">Personal Information</a>
            <a href="#myord" class="nav-button" data-target="myord">My Orders</a>
            <a href="#mngadd" class="nav-button" data-target="mngadd">Manage Address</a>
            <a href="#passwordmgr" class="nav-button" data-target="passwordmgr">Password Manager</a>
            <a href="../account/logout.php" class="nav-button">Logout</a>
        </nav>

        <!-- RIGHT SIDE: PROFILE INFORMATION -->
        <div id="profinfo" class="profilelinks active">
            <div class="profile-content">
                <div class="profile-photo-container">
                    <img src="../images/yinprofile.jpg" alt="Profile Picture" class="profile-photo">
                </div>

                <form method="POST" action="">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="profile-fname">First Name</label>
                            <input type="text" id="profile-fname" name="profile-fname" value="Roselyn" required>
                        </div>

                        <div class="form-group">
                            <label for="profile-lname">Last Name</label>
                            <input type="text" id="profile-lname" name="profile-lname" value="Santos" required>
                        </div>
                    </div>

                    <div class="form-group full-width">
                        <label for="profile-email">Email</label>
                        <input type="email" id="profile-email" name="profile-email" value="santosroselyn123@gmail.com"
                            required>
                    </div>

                    <div class="form-group full-width">
                        <label for="profile-phone">Phone</label>
                        <input type="tel" id="profile-phone" name="profile-phone" value="+639875432" required>
                    </div>

                    <div class="button-container">
                        <button type="submit" class="update-btn">Update Changes</button>
                    </div>
                </form>
            </div>
        </div><!-- end RIGHT SIDE: PROFILE INFORMATION -->

        <!-- RIGHT SIDE: MY ORDERS -->
        <div id="myord" class="profilelinks">
            <div class="myorders">
                <div class="grouped-column">
                    <div class="column-group full-width">
                        <label id="myorders" for="order-dits">Order details</label>
                        <p class="get-details">#00012837482</p>
                    </div>
                    <hr>

                    <div class="column-group full-width">
                        <label id="myorders" for="payment-meth">Payment Method</label>
                        <p class="get-details">Paypal</p>
                    </div>
                    <hr>

                    <div class="column-group full-width">
                        <label id="myorders" for="total-pay">Total Payment</label>
                        <p class="get-details">$750.00</p>
                    </div>
                    <hr>

                    <div class="column-group full-width">
                        <label id="myorders" for="estimated">Estimated Delivery Date</label>
                        <p class="get-details">02/20/25</p>
                    </div>
                </div>

                <div class="myorders-contents">
                    <img src="../images/catalogue/blush_of_love.png" alt="">
                    <div class="grouped-namecateg">
                        <p class="bouquet-name">Blush of Love</p>
                        <p class="bouquet-categ">Wedding</p>
                    </div>
                </div>

                <hr>
                <div class="myorders-contents">
                    <img src="../images/catalogue/blush_of_love.png" alt="">
                    <div class="grouped-namecateg">
                        <p class="bouquet-name">Blush of Love</p>
                        <p class="bouquet-categ">Wedding</p>
                    </div>
                </div>
                <hr>

                <div class="confirmation">
                    <label id="conf" for="confirmed">Accepted</label>
                    <p>Your Order has been accepted</p>
                </div>

                <div class="track-cancel-grp">
                    <a href="test.php">
                        <button class="track-order-btn">Track Order</button>
                    </a>

                    <a href="test.php">
                        <button class="cancel-order-btn">Cancel Order</button>
                    </a>
                </div>
            </div>
        </div><!-- end RIGHT SIDE: MY ORDERS -->

        <!-- RIGHT SIDE: MANAGE ADDRESS -->
        <div id="mngadd" class="profilelinks"><!-- MAIN MANAGE ADDRESS -->
            <div class="manage-address"><!-- SUB MANAGE ADDRESS -->

                <!-- EXISTING ADDRESS DISPLAY -->
                <div class="existing-container">
                    <div class="existing-address">
                        <div class="name-address">
                            <p class="add-name"><strong>Roselyn Caampued</strong></p>
                            <p class="add-existing">#27 Masarap Baranngay Isla, Valenzuela City</p>
                        </div>

                        <div class="actions">
                            <a href=""><span class="actions-edit">Edit</span></a>
                            <a href=""><span class="actions-delete">Delete</span></a>
                        </div>
                    </div>

                    <hr class="address-divider">

                    <div class="existing-address">
                        <div class="name-address">
                            <p class="add-name"><strong>John Kurt Caampued</strong></p>
                            <p class="add-existing">#72 Latina Baranngay Coloong, Valenzuela City</p>
                        </div>

                        <div class="actions">
                            <a href=""><span class="actions-edit">Edit</span></a>
                            <a href=""><span class="actions-delete">Delete</span></a>
                        </div>
                    </div>
                </div>
                <!-- END EXISTING ADDRESS DISPLAY -->

                <!-- ADD NEW ADDRESS FORM -->
                <div class="manageadd-container" id="manageadd-form">
                    <form action="" method="POST">
                        <h3>Add New Address</h3>

                        <div id="manageadd-info">
                            <div class="address-input-grp">
                                <label for="firstname" class="others-label">First Name</label>
                                <input type="text" name="firstname" required>
                            </div>
                            <br>

                            <div class="address-input-grp">
                                <label for="lastname" class="others-label">Last Name</label>
                                <input type="text" name="lastname">
                            </div>
                        </div>

                        <label class="others-label">Street Address</label>
                        <input type="text" name="streetadd" required>
                        <br>

                        <label class="others-label">City</label>
                        <input type="text" name="city" required>
                        <br>

                        <label class="others-label">State</label>
                        <input type="text" name="state" required>
                        <br>

                        <label class="others-label">Zip Code</label>
                        <input type="text" name="zipcode" required>
                        <br>

                        <label class="others-label">Phone</label>
                        <input type="text" name="add-phone" required>
                        <br>

                        <label class="others-label">Email</label>
                        <input type="text" name="add-email" required>
                        <br>

                        <div class="address-button">
                            <button type="submit" name="address" class="add-address-btn">Add Address</button>
                        </div>
                    </form>
                </div><!-- END ADD NEW ADDRESS FORM -->
            </div><!-- SUB MANAGE ADDRESS -->
        </div><!-- MAIN MANAGE ADDRESS -->

        <!-- RIGHT SIDE: PASSWORD MANAGER -->
        <div id="passwordmgr" class="profilelinks"><!-- MAIN MANAGE PASSWORD -->
            <div class="passwordmngr"><!-- SUB MANAGE PASSWORD -->
                <form method="POST" action="">
                    <div class="passmngr-grp">
                        <label for="current-password">Password</label>
                        <input type="password" id="current-password" name="current-password" required>
                    </div>

                    <div class="forgot-password">
                        <a href="#">Forgot Password</a>
                    </div>

                    <div class="passmngr-grp">
                        <label for="new-password">New Password</label>
                        <input type="password" id="new-password" name="new-password" required>
                    </div>

                    <div class="passmngr-grp">
                        <label for="confirm-password">Confirm New Password</label>
                        <input type="password" id="confirm-password" name="confirm-password" required>
                    </div>

                    <div class="passmngr-container">
                        <button type="submit" class="update-btn">Update Password</button>
                    </div>
                </form>
            </div><!-- SUB MANAGE PASSWORD -->
        </div><!-- MAIN MANAGE PASSWORD -->

    </div><!-- end main div -->

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Show Personal Information by default
            if (!window.location.hash) {
                document.getElementById('profinfo').classList.add('active');
                document.querySelector('a[data-target="profinfo"]').classList.add('active');
            } else {
                // If URL has hash, activate that section
                const targetId = window.location.hash.substring(1);
                document.getElementById(targetId).classList.add('active');
                document.querySelector(`a[data-target="${targetId}"]`).classList.add('active');
            }

            // Add click event to all navigation buttons
            const navButtons = document.querySelectorAll('.nav-button');
            navButtons.forEach(button => {
                // Only prevent default behavior for non-logout links
                if (!button.getAttribute('href').startsWith('login.php') && !button.getAttribute('href').startsWith('logout.php')) {
                    button.addEventListener('click', function (e) {
                        e.preventDefault(); // Prevent default behavior for hash links

                        // Remove active class from all tabs and buttons
                        document.querySelectorAll('.profilelinks').forEach(tab => {
                            tab.classList.remove('active');
                        });
                        document.querySelectorAll('.nav-button').forEach(btn => {
                            btn.classList.remove('active');
                        });

                        // Add active class to clicked button
                        this.classList.add('active');

                        // Get target ID and show that content
                        const targetId = this.getAttribute('data-target');
                        if (targetId) {
                            document.getElementById(targetId).classList.add('active');
                        }
                    });
                }
            });

    </script>

    <?php include_once 'footer.php'; ?>
</body>

</html>