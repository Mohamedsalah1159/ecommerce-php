<?php
include 'connect.php';
//Routes
$tmp  = "includes/templates/";  //template directory
$lang = "includes/languages/";  //language directory
$func = "includes/functions/";  //functions directory
$css  = "layout/css/";          //css directory
$js   = "layout/js/";           //js directory

include $func . "functions.php";
include $lang . 'english.php';
include $tmp . 'header.php';
if(!isset($nonavbar)){
    include $tmp . 'navbar.php';
}

