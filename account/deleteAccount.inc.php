<?php
require_once 'dbu.inc.php'; // Include your database connection
session_start();

// Check if the user is logged in
if (!isset($_SESSION['customerEmail'])) {
    header("Location: ../account/login.php");
    exit;
}

// Get the logged-in user's email
$email = $_SESSION['customerEmail'];

// Prepare the delete query
$sql = "DELETE FROM customerinfo WHERE customerEmail = ?";

// Prepare the statement
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);

// Execute the delete query
if ($stmt->execute()) {
    // Clear session and log the user out
    session_unset();
    session_destroy();
    
    // Redirect to a goodbye or login page with a message
    header("Location: ../account/login.php?message=accountDeleted");
    exit;
} else {
    echo "<p>Error deleting account. Please try again later.</p>";
}

$stmt->close();
?>
