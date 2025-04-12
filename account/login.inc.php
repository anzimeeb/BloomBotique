<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if(isset($_POST["login"])){
    $email = $_POST["email"];
    $password = $_POST["pass"] ;
    
    require_once "dbu.inc.php";
    require_once 'functionsUsers.inc.php';

    if(emptyInputLogin ($email,  $password) !==false){
        header("location:login.php?error=emptyinput");
        exit();
    }

    loginUser($conn, $email, $email, $password);

} else {
    header("location:login.php?error=ayaw");
    exit();
}
?>