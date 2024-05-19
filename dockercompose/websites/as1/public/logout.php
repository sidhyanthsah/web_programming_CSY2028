<?php
session_start(); 
if(isset($_SESSION['user_id'])){
    $_SESSION = array();

    // Destroy the session
    session_destroy();

    // Redirect the user to the logout page or any other desired page
    header("Location: login.php");
}else{
    header("Location: login.php");
}