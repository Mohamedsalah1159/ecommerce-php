<?php
$do = "";
if(isset($_GET['do'])){
    $do = $_GET['do'];
}else{
    $do = 'manage';
}
// If the Page Is Main Page
if($do == 'manage'){
    echo 'welcome you are in the manage categiory page';
    echo '<a href="page.php?do=add"> add new categiory +</a>';
}elseif($do == 'add'){
    echo 'welcome you are in the add page';
}elseif($do == 'insert'){
    echo 'welcome you are in the insert page';
}else{
    echo 'error there is no page like this name';
}
