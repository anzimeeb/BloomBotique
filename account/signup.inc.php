<?php

if(isset($_POST["createaccsubmit"])){
    $firstname = $_POST["fname"];
    $lastname = $_POST["lname"];
    $pNumber = $_POST["pNumber"];
    $username = $_POST["user"];
    $email = $_POST["email"];
    $password = $_POST["pass"];
    $password_confirm = $_POST["cpass"];

    require_once 'dbu.inc.php';
    require_once 'functionsUsers.inc.php';

    if(emptyInputSignup($firstname,$lastname,$username, $email,$password, $password_confirm)!==false){
        header("location:signup.php?error=emptyinput");
        exit();
    }

    if(invalidEmail($email)!==false){
        header("location:signup.php?error=invalidEmail");
        exit();
    }

    if(pwdMatch($password, $password_confirm) !== false){
        header("location:signup.php?error=pwdMatch");
        exit();
    }

    if(emailExist($conn, $email, $email) !== false){
        header("location:signup.php?error=emailExist");
        exit();
    }

    createUser($conn, $firstname, $lastname, $pNumber, $username, $email, $password, $password_confirm);


} else {
    header("location:signup.php");
}
?>