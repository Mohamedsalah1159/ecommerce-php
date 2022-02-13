<?php
session_start();
$nonavbar = '';
$pagetitle = 'login';
if(isset($_SESSION['username'])){
    header('location: dashboard.php');
}
include 'init.php';
// check if user coming by http post request
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $username = $_POST["user"];
    $password = $_POST["pass"];
    $hashedpass = sha1($password);
    // Check if user exist in database
    $stmt = $con->prepare("SELECT userID, username, password FROM users WHERE username= ? AND password= ? AND groupID= 1 LIMIT 1");
    $stmt->execute(array($username, $hashedpass));
    $row = $stmt->fetch();
    $count = $stmt->rowCount();
    // if $count > 0 this main the database contain about this user
    if($count > 0){
        $_SESSION['username']= $username; //Rejester username
        $_SESSION['ID'] = $row['userID']; //Rejester id
        header('location: dashboard.php'); //Redirect to Dashboard Page
        exit();
    }
}

?>
<form class="login" action="<?php echo $_SERVER["PHP_SELF"] ?>" method="POST">
    <h4 class="text-center">ADMIN LOGIN</h4>
    <input class="form-control" type="text" name="user" placeholder="username" autocomplete="off"/>
    <input class="form-control" type="password" name="pass" placeholder="password" autocomplete="new-passwword"/>
    <input class="btn btn-primary btn-block" type="submit" value="login"/>
</form>
<?php
include $tmp . 'footer.php';
?>

