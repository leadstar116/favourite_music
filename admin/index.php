<?php
    $debugging = true;
    if($debugging) {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
    }

    if(!isset($_SESSION)) {
        session_start(); 
    }

    if(isset($_SESSION['user_id'])) {
        include_once('categories/index.php');
    } else {
        include_once('login.php');
    }
    die;
?>