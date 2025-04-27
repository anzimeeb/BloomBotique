<?php
session_start();
require_once '../connection.php';
require_once 'functionsPages.inc.php';

if (isset($_POST['save_customflower'])) {
    saveCustomFlower($conn, $_SESSION['user_id']);
}

?>