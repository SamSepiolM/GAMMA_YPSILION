<?php
session_start();
if( !isset($_SESSION["AUTH"])) {
    include_once "./views/login-signup.php";
    //include_once "./views/login.php";
    //header("Location: ./views/home.php");
} else {
    //require_once "./views/home.php";
    header("Location: ./views/home.php");
}