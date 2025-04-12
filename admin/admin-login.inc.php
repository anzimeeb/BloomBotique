<?php

if(isset($_POST["loginadmin"])){
    $email = $_POST["username"];
    $username = $_POST["username"];
    $password = $_POST["password"] ;

    require_once 'dba.inc.php';
    require_once 'functionsAdmin.inc.php';

    if(emptyInputAdminLogin ($email, $username, $password)!==false){
        header("location:admin-login.php?error=emptyinput");
        exit();
    }
    
    // hashPasswordForSpecificUser($conn, $username, $password);
    loginAdmin($conn, $email, $password);


} else {
    header("location:admin-login.php?error=ayaw");
    exit();
}