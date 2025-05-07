<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
require_once '../connection.php';
require_once 'functionsPages.inc.php';

$method = $_SERVER['REQUEST_METHOD'];
$contentType = $_SERVER['CONTENT_TYPE'] ?? '';



// ✅ Then handle form submission
if (isset($_POST['save_customflower'])) {
    saveCustomFlower($conn, $_SESSION['user_id']);
}
?>
