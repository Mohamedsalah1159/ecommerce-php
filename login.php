<?php
    ob_start(); //output buffering start
    session_start();
    $pagetitle = 'login';
    if(isset($_SESSION['user'])){
        header('location: index.php');
    }
    include "init.php";
    // check if user coming by http post request
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        if(isset($_POST["login"])){
            $user = $_POST["username"];
            $pass = $_POST["password"];
            $hashedpass = sha1($pass);
            // Check if user exist in database
            $stmt = $con->prepare("SELECT userID, username, password FROM users WHERE username= ? AND password= ?");
            $stmt->execute(array($user, $hashedpass));
            $get = $stmt->fetch();
            $count = $stmt->rowCount();
            // if $count > 0 this main the database contain about this user
            if($count > 0){
                $_SESSION['user']= $user; //Rejester username
                $_SESSION['uid'] = $get["userID"]; //Rejester UserID in Session
                header('location: index.php'); //Redirect to Dashboard Page
                exit();
            }
        }else{
            $formErrors = array();
            $username  = $_POST["username"];
            $password  = $_POST["password"];
            $password2 = $_POST["password2"];
            $email     = $_POST["email"];
            if(isset($username)){
                $filterdUser = filter_var($username, FILTER_SANITIZE_STRING);
                if(strlen($filterdUser) < 4){
                    $formErrors[] = "Username Must Be More Than 4 Characters";
                }
            }
            if(isset($password) && isset($password2)){
                if(empty($password)){
                    $formErrors[] = "Sorry Password Can\'t Be Empty";
                }
                if(sha1($password) !== sha1($password2)){
                    $formErrors[] = "Sorry Password Is Not Match";
                }
            }

            if(isset($email)){
                $filterdEmail = filter_var($email, FILTER_SANITIZE_EMAIL);
                if(filter_var($filterdEmail, FILTER_VALIDATE_EMAIL) != true){
                    $formErrors[] = "Sorry This Email Is Not Valid";
                }
            }
            if(empty($formerrors)){
                //check if user exist in database
                $check = checkItems('username', 'users', $username);
                if($check == 1){
                    $formErrors[] = "Sorry This User Is Exist";

                }else{
                //insert user info in database
                $stmt = $con->prepare('INSERT INTO users(username, password, email, RegStatus, Date) VALUES (:zuser, :zpass, :zemail, 0, now())');
                $stmt->execute(array(
                    'zuser'  => $username,
                    'zpass'  => sha1($password),
                    'zemail' => $email
                ));
                $successMsg = "Congratulations You Are A Registerd Member";
                }
            }
        }

    }
?>
    <div class="container login-page">
        <h1 class="text-center"><span class="selected" data-class="login">Login </span> | <span data-class="signup"> Signup</span></h1>
        <!--start login form-->
        <form class="login" action="<?php echo $_SERVER['PHP_SELF']?>" method="POST">
            <div class="input-container"><input class="form-control" type="text" name="username" autocomplete="off" placeholder="Type Your Username" required /></div>
            <div class="input-container"><input class="form-control" type="password" name="password" autocomplete="new-password" placeholder="Type Your Password" required /></div>
            <input class="btn btn-primary btn-block" style="width:100%" name="login" type="submit" value="login" />

        </form>
        <!--end login form-->
        <!--start signup form-->
        <form class="signup" action="<?php echo $_SERVER['PHP_SELF']?>" method="POST">
            <div class="input-container"><input pattern=".{4,}" title="Username Must Be More Than 4 Chars" class="form-control" type="text" name="username" autocomplete="off" placeholder="Type Your Username" required /></div>
            <div class="input-container"><input minlength="4" class="form-control" type="password" name="password" autocomplete="new-password" placeholder="Type A Complex Password" required /></div>
            <div class="input-container"><input minlength="4" class="form-control" type="password" name="password2" autocomplete="new-password" placeholder="Type Password Again" required /></div>
            <div class="input-container"><input class="form-control" type="email" name="email" autocomplete="off" placeholder="Type A Vallid Email"  /></div>
            <input class="btn btn-success btn-block" style="width:100%" name="signup" type="submit" value="Signup" />

        </form>
        <!--end signup form-->
        <div class="the-errors text-center">
            <?php
                if(!empty($formErrors)){
                    foreach($formErrors as $error){
                        echo "<div class='msg'>" . $error . "</div>";
                    }
                }
                if(isset($successMsg)){
                    echo "<div class='msg success'>" . $successMsg . "</div>";
                }
                
            ?>
        </div>
    </div>
<?php
    include $tmp . "footer.php";
    ob_end_flush();
?>