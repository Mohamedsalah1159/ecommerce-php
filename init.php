<?php
ini_set("display-errors", "On");
error_reporting("E_ALL");
include 'admin/connect.php';
$sessionUser= "";
if(isset($_SESSION["user"])){
    $sessionUser= $_SESSION["user"];
}

//Routes
$tmp  = "includes/templates/";  //template directory
$lang = "includes/languages/";  //language directory
$func = "includes/functions/";  //functions directory
$css  = "layout/css/";          //css directory
$js   = "layout/js/";           //js directory

include $func . "functions.php";
include $lang . 'english.php';
include $tmp . 'header.php';


