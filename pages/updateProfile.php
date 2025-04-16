<?php
// Include database connection
include '../connection.php';  // Ensure the correct path for your database connection

// Check if the updateProfile button was clicked
if (isset($_POST['updateProfile'])) {
    // Collect and sanitize input data from the form
    $userEmail = mysqli_real_escape_string($conn, $_POST['profile-email']); // Match 'profile-email'
    $firstName = mysqli_real_escape_string($conn, $_POST['profile-fname']); // Match 'profile-fname'
    $lastName = mysqli_real_escape_string($conn, $_POST['profile-lname']); // Match 'profile-lname'
    $phoneNumber = isset($_POST['profile-phone']) ? mysqli_real_escape_string($conn, $_POST['profile-phone']) : null; // Match 'profile-phone'

    // Handle file upload (optional, if user wants to update profile image)
    if (isset($_FILES['profile-image']) && $_FILES['profile-image']['error'] == 0) {
        $profileImage = $_FILES['profile-image']['name']; // Match 'profile-image' in the form
        $tempImage = $_FILES['profile-image']['tmp_name']; // Match 'profile-image' in the form
        $uploadDir = "../images/profilepictures/"; // Directory to save uploaded images
        $uploadFile = $uploadDir . basename($profileImage);

        // Move the uploaded image to the desired location
        if (move_uploaded_file($tempImage, $uploadFile)) {
            $imageQuery = ", profile_image = '$profileImage'"; // Add image field if image is uploaded
        } else {
            echo "Error uploading the image.";
            exit;
        }
    } else {
        $imageQuery = ""; // No image update if no file is uploaded
    }

    // Build the SQL query
    $query = "UPDATE customerinfo SET 
        customerFN = '$firstName',
        customerLN = '$lastName',
        phone_number = '$phoneNumber' 
        $imageQuery
        WHERE customerEmail = '$userEmail'";  // Ensure you're updating the correct user's record by email

    // Execute the query
    if (mysqli_query($conn, $query)) {
        // Redirect with success message
        header("Location: profile_personalInfo.php?message=success");
        exit;
    } else {
        echo "Error updating profile: " . mysqli_error($conn);
    }
} else {
    // Redirect back if accessed directly (i.e. without submitting the form)
    header("Location: profile.php");
    exit;
}
?>
