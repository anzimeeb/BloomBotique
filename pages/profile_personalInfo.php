<?php
require_once 'header.php';
require_once '../connection.php';
require_once 'functionsPages.inc.php';

if (!isset($_SESSION['customerEmail'])) {
    header("location:../account/login.php");
}

if (isset($_SESSION['customerEmail'])) {
    $email = $_SESSION['customerEmail'];  // Get the email from the session
    $userId = getUserIdFromSession($conn, $email);
    getCartFromDatabase($conn, $userId);

    // Call the function to get the user's profile data from the database
    $userData = getUserProfile($conn, $email);
    $orders = getUserOrders($conn, $userId);
} else {
    // If user is not logged in, handle the error (or redirect)
    echo "User is not logged in.";
    exit;
}

?>

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
            <!-- <a href="#mngadd" class="nav-button" data-target="mngadd">Manage Address</a> -->
            <a href="#passwordmgr" class="nav-button" data-target="passwordmgr">Password Manager</a>
            <a href="../account/logout.php" class="nav-button">Logout</a>
        </nav>

        <!-- Right Side: Profile Information -->
        <div id="profinfo" class="profilelinks active">
            <div class="profile-content">
                <div class="profile-photo-container">
                    <!-- Profile picture (use default image if profile image is null or empty) -->
                    <img src="<?= htmlspecialchars($userData['profile_image']) ? '../images/profilepictures/' . htmlspecialchars($userData['profile_image']) : '../images/yinprofile.jpg' ?>"
                        alt="Profile Picture" class="profile-photo">
                </div>

                <!-- Profile form -->
                <form method="POST" action="updateProfile.php" enctype="multipart/form-data" id="profile-form">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="profile-fname">First Name</label>
                            <input type="text" id="profile-fname" name="profile-fname"
                                value="<?= htmlspecialchars($userData['customerFN']) ?>" required disabled>
                        </div>

                        <div class="form-group">
                            <label for="profile-lname">Last Name</label>
                            <input type="text" id="profile-lname" name="profile-lname"
                                value="<?= htmlspecialchars($userData['customerLN']) ?>" required disabled>
                        </div>
                    </div>

                    <div class="form-group full-width">
                        <label for="profile-email">Email</label>
                        <input type="email" id="profile-email" name="profile-email"
                            value="<?= htmlspecialchars($userData['customerEmail']) ?>" required disabled>
                    </div>

                    <div class="form-group full-width">
                        <label for="profile-phone">Phone</label>
                        <input type="tel" id="profile-phone" name="profile-phone"
                            value="<?= htmlspecialchars($userData['phone_number']) ?>" disabled>
                    </div>

                    <div class="form-group full-width">
                        <label for="profile-image">Profile Image (optional)</label>
                        <input type="file" id="profile-image" name="profile-image" disabled>
                    </div>

                    <div class="button-container">
                        <button type="button" id="edit-btn" class="update-btn" onclick="toggleEdit()">Edit</button>
                        <button type="submit" id="submit-btn" name="updateProfile" class="update-btn"
                            style="display: none;">
                            Update Profile
                        </button>
                        <button type="button" id="cancel-btn" class="cancel-btn" style="display: none;"
                            onclick="cancelEdit()">Cancel</button>
                    </div>
                </form>
            </div>
        </div><!-- end RIGHT SIDE: PROFILE INFORMATION -->

        <!-- RIGHT SIDE: MY ORDERS -->
        <div id="myord" class="profilelinks">
            <div class="myorders">
                <?php if (!empty($orders)): ?>
                    <?php foreach ($orders as $order): ?>
                        <div class="perOrder">
                            <div>
                                <div class="grouped-column">
                                    <div class="column-group full-width">
                                        <label for="order-dits">Order ID: #<?= htmlspecialchars($order['order_id']) ?></label>
                                        <p class="get-details"><?= htmlspecialchars($order['order_id']) ?></p>
                                    </div>
                                    <hr>

                                    <div class="column-group full-width">
                                        <label for="payment-meth" class="">Payment Method</label>
                                        <p class="get-details"><?= htmlspecialchars($order['payment_method']) ?></p>
                                    </div>
                                    <hr>

                                    <div class="column-group full-width">
                                        <label for="total-pay">Total Payment</label>
                                        <p class="get-details"><?= '$' . number_format($order['total_amount'], 2) ?></p>
                                    </div>
                                    <hr>

                                    <div class="column-group full-width">
                                        <label for="estimated">Estimated Delivery Date</label>
                                        <?php
                                        // Convert created_at to a DateTime object
                                        $createdDate = new DateTime($order['created_at']);

                                        // Add one week to the created date
                                        $createdDate->modify('+1 week');

                                        // Format the new estimated delivery date
                                        $estimatedDeliveryDate = $createdDate->format('Y-m-d');  // You can modify the format as needed
                                        ?>
                                        <p class="get-details"><?= htmlspecialchars($estimatedDeliveryDate) ?></p>
                                    </div>
                                </div>

                                <!-- Display each product for the order -->
                                <?php foreach ($order['items'] as $item): ?>
                                    <div class="myorders-contents">
                                        <img src="<?= htmlspecialchars($item['product_image']) ?>" alt="">
                                        <div class="grouped-namecateg">
                                            <p class="bouquet-name"><?= htmlspecialchars($item['product_name']) ?></p>
                                            <p class="bouquet-categ"><?= htmlspecialchars($item['product_category']) ?></p>
                                            <p>Quantity: <?= htmlspecialchars($item['quantity']) ?></p>
                                        </div>
                                    </div>
                                    <hr>
                                <?php endforeach; ?>

                                <div class="confirmation">
                                    <?php if ($order['order_status'] === 'Pending'): ?>
                                        <label id="conf" for="confirmed" style="color: orange;">Pending</label>
                                        <p>Your order is still being processed.</p>
                                    <?php elseif ($order['order_status'] === 'Accepted'): ?>
                                        <label id="conf" for="confirmed" style="color: green;">Accepted</label>
                                        <p>Your order has been accepted and is being prepared.</p>
                                    <?php elseif ($order['order_status'] === 'Shipped'): ?>
                                        <label id="conf" for="confirmed" style="color: blue;">Shipped</label>
                                        <p>Your order has been shipped and is on its way.</p>
                                    <?php elseif ($order['order_status'] === 'Delivered'): ?>
                                        <label id="conf" for="confirmed" style="color: #28a745;">Delivered</label>
                                        <p>Your order has been delivered successfully.</p>
                                    <?php elseif ($order['order_status'] === 'Cancelled'): ?>
                                        <label id="conf" for="confirmed" style="color: red;">Cancelled</label>
                                        <p>Your order has been cancelled.</p>
                                    <?php else: ?>
                                        <label id="conf" for="confirmed" style="color: grey;">Unknown</label>
                                        <p>We could not determine the current status of your order.</p>
                                    <?php endif; ?>
                                </div>


                                <!-- Track and Cancel Buttons (linked to each order) -->
                                <div class="track-cancel-grp">
                                    <a href="trackOrder.php?order_id=<?= htmlspecialchars($order['order_id']) ?>">
                                        <button class="track-order-btn">Track Order</button>
                                    </a>

                                    <?php $orderStatus = htmlspecialchars($order['order_status']);  if ($orderStatus == 'Pending'): ?>
                                        <div class="track-cancel-grp">
                                            <a href="cancelOrder.php?order_id=<?= htmlspecialchars($order['order_id']) ?>">
                                                <button class="cancel-order-btn">Cancel Order</button>
                                            </a>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <hr>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>You have no orders.</p>
                <?php endif; ?>
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
                <form method="POST" action="changePassword.php">
                    <div class="passmngr-grp">
                        <label for="current-password">Current Password</label>
                        <input type="password" id="current-password" name="current-password" required>
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
                // Allow the default behavior for logout link
                if (button.getAttribute('href') && button.getAttribute('href').includes('logout.php')) {
                    return; // Don't prevent the default behavior for logout
                }

                // Prevent default behavior for other hash links
                if (!button.getAttribute('href').startsWith('login.php')) {
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
        });

        function toggleEdit() {
            const inputs = document.querySelectorAll('#profile-fname, #profile-lname, #profile-email, #profile-phone, #profile-image');
            const editBtn = document.getElementById('edit-btn');
            const submitBtn = document.getElementById('submit-btn');
            const cancelBtn = document.getElementById('cancel-btn');

            // Check if fields are disabled or not
            const areFieldsDisabled = Array.from(inputs).every(input => input.disabled);

            // Toggle the disabled attribute based on the current state
            inputs.forEach(input => input.disabled = !areFieldsDisabled);

            // Show or hide the submit and cancel buttons based on the current state
            if (areFieldsDisabled) {
                editBtn.style.display = 'none';  // Change to 'Update Profile' when editing
                submitBtn.style.display = 'inline-block'; // Show the submit button
                cancelBtn.style.display = 'inline-block'; // Show the cancel button
            } else {
                editBtn.textContent = 'Edit';  // Change back to 'Edit' after editing
                submitBtn.style.display = 'none'; // Hide the submit button
                cancelBtn.style.display = 'none'; // Hide the cancel button
            }
        }

        function cancelEdit() {
            const inputs = document.querySelectorAll('#profile-fname, #profile-lname, #profile-email, #profile-phone, #profile-image');
            const editBtn = document.getElementById('edit-btn');
            const submitBtn = document.getElementById('submit-btn');
            const cancelBtn = document.getElementById('cancel-btn');

            // Revert the values back to the original (disabled fields and hide the buttons)
            inputs.forEach(input => input.disabled = true);
            submitBtn.style.display = 'none'; // Hide the submit button
            cancelBtn.style.display = 'none'; // Hide the cancel button
            editBtn.textContent = 'Edit'; // Change back to 'Edit'

            // Optionally, you can reset the values to their original ones (not necessary in your case)
            // You can reload the form or refresh the page here if needed to reset the state
        }

    </script>

    <?php include_once 'footer.php'; ?>
</body>

</html>