<?php
require_once 'header.php';
?>

<?php
require_once '../connection.php';

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $contact_firstname = $_POST['con_fname'];
    $contact_lastname = $_POST['con_lname'];
    $contact_email = $_POST['con_email'];
    $contact_phone = $_POST['con_phone'];
    $contact_subject = $_POST['con_subject'];
    $contact_message = $_POST['con_message'];

    if (!empty($contact_email) && !empty($contact_phone) && !is_numeric($contact_email)) {
        $query = "INSERT INTO contact (con_fname, con_lname, con_email, con_phone, con_subject, con_message) 
                    VALUES ('$contact_firstname', '$contact_lastname', '$contact_email', '$contact_phone', '$contact_subject', '$contact_message')";

        mysqli_query($conn, $query);
        echo " "; /*kapag nilagyan ko ng laman to kapag pinindot yung okay, niiba format, why oh why? */
    } else {
        echo "<script type='text/javascript'>
                alert('Please fill up all the fields.')
                </script>";/* ganun din */
    }
}
?>

<!-- BANNER IMAGE -->
<div class="banner2">
    <img src="../images/banner2.jpg" alt="BLOOM BOUTIQUE">
    <h1 class="banner-title">CONTACT US</h1>
</div>

<div class="contact-main-container"><!-- main container -->
    <div class="contact-image" id="con-image"><!-- left side: image -->
        <img src="../images/contactImage.png" alt="BLOOM BOUTIQUE">
    </div><!-- end left side: image -->

    <div class="contact-form"><!-- right side: contact form -->
        <div class="contact-container" id="contact-id"><!-- contact form container -->
            <form method="POST" action="https://formspree.io/f/xkndarzk">
                <div class="user-info">
                    <div class="contact-input-grp">
                        <label for="firstname">First Name</label>
                        <input type="text" name="con-fname" required>
                    </div>

                    <div class="contact-input-grp">
                        <label for="lastname">Last Name *</label>
                        <input type="text" name="cone-lname" required>
                    </div>
                </div>

                <div class="user-info">
                    <div class="contact-input-grp">
                        <label for="email">Email *</label>
                        <input type="text" name="con-email" required>
                    </div>
                </div>

                <div class="contact-input-grp">
                    <label for="subject">Subject *</label>
                    <input type="text" name="sub" required>
                </div>

                <div class="contact-input-grp">
                    <label for="contact-message">Your Message *</label>
                    <textarea id="contact-send-message" required></textarea>
                </div>

                <input type="submit" name="review-submit" value="Send Message">
            </form>
        </div><!-- end contact form container -->
    </div><!-- end right side: contact form -->
</div><!-- end main container -->

<!-- contact info (ADDRESS, PHONE, EMAIL) -->
<!-- contact options boxes (below form) -->
<!-- <div class="contact-options">
    <div class="contact-indiv">
        <img src="../images/c-address.png" alt="Address Icon">
        <h5>Address</h5>
    </div>

    <div class="contact-indiv">
        <img src="../images/c-phone.png" alt="Phone Icon">
        <h5>Phone</h5>
    </div>

    <div class="contact-indiv">
        <img src="../images/c-email.png" alt="Email Icon">
        <h5>Email</h5>
    </div>
</div>end contact options boxes (below form) -->

<!-- google map -->
<div class="map-container">
    <iframe
        src="https://maps.google.com/maps?q=Adriano%20Family%20Batsan%20Matnda%20San%20Miguel%20Bulacan&t=&z=12&ie=UTF8&iwloc=&output=embed"
        width="100%" height="350" frameborder="0" scrolling="no"></iframe>
</div>




<?php include_once 'footer.php'; ?>