<?php
/* get all function v2.0
** function to get all records from any database table
*/
function getAllFrom($field, $table, $where = NULL, $and = NULL,$orderfield, $ordering = "DESC"){
    global $con;
    $getAll = $con->prepare("SELECT $field FROM $table $where $and ORDER BY $orderfield $ordering");
    $getAll->execute();
    $all = $getAll->fetchAll();
    return $all;
}


/*
**title function v.1
**Function title if the page has $pagetitle the funtion will put it 
**and if it not has this variable it wil put the default pagename
*/
function gettitle(){
    global $pagetitle;
    if(isset($pagetitle)){
        echo $pagetitle;
    } else{
        echo 'default';
    }
}
/*
** Home Redirect function v.2
** Home Redirect function {this function accept parameters}
** $theMsg message = echo the {error, succes, warning} message
** $url = the link you want to redirect to it
** $seconds = seconds before Redirecting
*/
function redirectHome($theMsg ,$url = null ,$seconds = 3){
    if($url === null){
        $url = 'index.php';
        $link = 'Homepage';
    }else{
        if(isset($_SERVER["HTTP_REFERER"]) && !empty($_SERVER["HTTP_REFERER"])){
            $url = $_SERVER["HTTP_REFERER"];
            $link = 'previous page';

        }else{
            $url = 'index.php';
            $link = 'Homepage';
        }
        
    }
    echo $theMsg ;
    echo '<div class="alert alert-info">you will be Redirected to ' . $link . ' after ' . $seconds . ' seconds</div>';
    header("refresh:$seconds;url=$url");
    exit();
}
/*
**function to check items in database v.1 funtion accept (parameters)
**$select = the item to select (example: user, item category)
**$from = the table to select from (example: users, items, categories)
**$value = the value of select (example: mohamed, box, electronics)
*/
function checkItems($select, $from, $value){
    global $con;
    $statment = $con->prepare("SELECT $select FROM $from WHERE $select=?");
    $statment->execute(array($value));
    $count = $statment->rowCount();
    return $count;
}



/*
**count number of items function v.1
**function to count number of items rows
**$item = the item to count
**$table = the table to choose from
*/
function countItems($item, $table){
    global $con;
    $stmt2= $con->prepare("SELECT COUNT($item) FROM $table");
    $stmt2->execute();
    return $stmt2->fetchColumn();

}

/* get latest records function v1.0
** function to get latest items from database [users, items, comments]
** $select = field to select
** $table = the table to choose from
** $order = the column who order by him (the desc order)
** $limit = number of records to get
*/
function getLatest($select, $table, $order, $limit = 5){
    global $con;
    $getStmt = $con->prepare("SELECT $select FROM $table ORDER BY $order DESC LIMIT $limit");
    $getStmt->execute();
    $rows = $getStmt->fetchAll();
    return $rows;
}

/* check if user is not activate v1.0
** function to check the Regstautus of the user
*/
function checkUserStatus($user){
    global $con;
    $stmtx = $con->prepare("SELECT username, RegStatus FROM users WHERE username= ? AND RegStatus= 0");
    $stmtx->execute(array($user));
    $status = $stmtx->rowCount();
    return $status;

}