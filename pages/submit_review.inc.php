<?php
session_start();
require_once '../connection.php';


if (isset($_POST['review-submit'])) {
    $rating = $_POST['rating'];
    $review_text = $_POST['review_text'];
    $product_id = $_POST['product_id']; // Assuming this is passed
    $user_id = $_SESSION['user_id']; // Assuming customerID is stored in session

    // Handle the image upload
    $review_image = null;
    if (isset($_FILES['review_image']) && $_FILES['review_image']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = '../images/review_images/'; // Define the upload directory
        $file_name = basename($_FILES['review_image']['name']);
        $target_path = $upload_dir . $file_name;

        // Move the uploaded file to the target directory
        if (move_uploaded_file($_FILES['review_image']['tmp_name'], $target_path)) {
            $review_image = $target_path;
        }
    }

    // Insert the review into the database
    $query = "INSERT INTO reviews (product_id, customer_id, rating, review_text, review_image) 
              VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("iiiss", $product_id, $user_id, $rating, $review_text, $review_image);
    $stmt->execute();

    // Redirect or display a success message
    header('Location: catalouge.php');
}


?>