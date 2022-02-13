<?php
/*
********************************************************************************
**  Template Page

********************************************************************************
*/
ob_start(); //output buffering start
session_start();
$pagetitle = '';
if(isset($_SESSION['username'])){
    include 'init.php';
    $do = "";
    if(isset($_GET['do'])){
        $do = $_GET['do'];
    }else{
        $do = 'manage';
    }
    if($do == 'manage'){
        echo "welcome";
    }elseif($do == 'add'){

    }elseif($do == 'insert'){
        
    }elseif($do == 'edit'){
        
    }elseif($do == 'update'){
        
    }elseif($do == 'delete'){
        
    }elseif($do == 'activate'){
        
    }
    include $tmp . 'footer.php';

} else{
    header('location: index.php');
    exit();
}

    ob_end_flush(); //Release the output
?>