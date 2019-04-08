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

session_unset();
session_destroy();

header('Location: /music-on-hold/music-tracks/admin/');
?>