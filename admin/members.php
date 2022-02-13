<?php
/*
********************************************************************************
**Mange Member Page
** You can Add | Edit | Delete from here

********************************************************************************
*/
ob_start(); //output buffering start
session_start();
$pagetitle = 'Members';
if(isset($_SESSION['username'])){
    include 'init.php';
    $do = "";
    if(isset($_GET['do'])){
        $do = $_GET['do'];
    }else{
        $do = 'manage';
    }
    if($do == 'manage'){ //manage page
        $value = 'mohamed';
        checkItems('username', 'users', $value);

        $query = '';
        if(isset($_GET["page"]) && $_GET["page"] == "pending"){
            $query = "AND RegStatus = 0";
        }
        //select all users except admin
        $stmt = $con->prepare("SELECT * FROM users WHERE groupID != 1 $query ORDER BY userID DESC");
        $stmt->execute();
        $rows = $stmt->fetchAll();

        if(! empty($rows)){
            ?>
            <h1 class= 'text-center'>Manage Members</h1>
            <div class= 'container'>
                <div class='table-responsive'>
                    <table class='main-table manage-members text-center table table-bordered'>
                        <tr style='background-color: #333;color: #fff;'>
                            <td>#ID</td>
                            <td>avatar</td>
                            <td>Username</td>
                            <td>Email</td>
                            <td>Fullname</td>
                            <td>Registerd Date</td>
                            <td>control</td>
                        </tr>
                        <?php
                            foreach($rows as $row){
                                echo '<tr>';
                                    echo '<td>' . $row['userID'] . '</td>';
                                    echo '<td>';
                                    if(empty ($row['avatar'])){
                                        echo '<img src="../download (1).jpg" alt="" />';
                                    }else{
                                        echo '<img src="uploads/avatar/' . $row['avatar'] .'" alt="" />';
                                    }
                                    echo '</td>';
                                    echo '<td>' . $row['username'] . '</td>';
                                    echo '<td>' . $row['email'] . '</td>';
                                    echo '<td>' . $row['fullname'] . '</td>';
                                    echo '<td>' . $row['Date'] . '</td>';
                                    echo '<td>
                                            <a href="members.php?do=edit&userID=' . $row['userID'] . '" class="btn btn-success"><i class="fa fa-edit"></i>Edit</a>
                                            <a href="members.php?do=delete&userID=' . $row['userID'] . '" class="btn btn-danger confirm"><i class="fa fa-close"></i>Delete</a>';
                                            if($row['RegStatus'] == 0){
                                            echo '<a href="members.php?do=activate&userID=' . $row['userID'] . '" class="btn btn-info activate"><i class="fa fa-check"></i>Activate</a>';
                                            }
                                    echo '</td>';
                                echo '</tr>';
                            }
                        ?>
                    </table>
                </div>
                <a href='members.php?do=add' class='btn btn-primary'><strong>+</strong>New Member </a>
            </div>
            
        <?php
        }else{
            echo "<div class='container'>";
                echo "<div class='nice-message'>There is no Members To Show</div>";
                echo "<a href='members.php?do=add' class='btn btn-primary'><strong>+</strong>New Member </a>";
            echo "</div>";
        }
        }elseif($do == 'add'){ //add page ?>
            <h1 class= 'text-center'>Add New Member</h1>
            <div class= 'container'>
                <form class= 'form-horizontal' action='?do=insert' method='post' enctype="multipart/form-data">
                    <!--start username field-->
                    <div class='form-group form-group-lg'>
                        <label class='col-sm-2 control-label text-center'>Username</label>
                        <div class='col-sm-10 col-md-5'>
                            <input type='text' name='username' class='form-control' autocomplete = 'off' required='required' placeholder= "Username To Login" />
                        </div>
                    <div>
                    <!--end username field-->
                    <!--start password field-->
                    <div class='form-group form-group-lg'>
                        <label class='col-sm-2 control-label text-center'>Password</label>
                        <div class='col-sm-10 col-md-5'>
                            <input type='password' name='password' class='password form-control' autocomplete= 'new-password' required='required' placeholder= "Password Must Be Hard & Complex" />
                            <i class='show-pass fa fa-eye fa-2x'></i>
                        </div>
                    <div>
                    <!--end password field-->
                    <!--start e-mail field-->
                    <div class='form-group form-group-lg'>
                        <label class='col-sm-2 control-label text-center'>E-mail</label>
                        <div class='col-sm-10 col-md-5'>
                            <input type='email' name='email' class='form-control' required='required' placeholder= "Email Must Be Valid" />
                        </div>
                    <div>
                    <!--end e-mail field-->
                    <!--start fullname field-->
                    <div class='form-group form-group-lg'>
                        <label class='col-sm-2 control-label text-center'>Fullname</label>
                        <div class='col-sm-10 col-md-5'>
                            <input type='text' name='full' class='form-control' required='required' placeholder= "Fullname Appear In Your Profile Page" />
                        </div>
                    <div>
                    <!--end fullname field-->
                    <!--start avatar field-->
                    <div class='form-group form-group-lg'>
                        <label class='col-sm-2 control-label text-center'>User Avatar</label>
                        <div class='col-sm-10 col-md-5'>
                            <input type='file' name='avatar' class='form-control' required='required' />
                        </div>
                    <div>
                    <!--end avatar field-->
                    <!--start username field-->
                    <div class='form-group form-group-lg'>
                        <div class='col-sm-offset-2 col-sm-10'>
                            <input type='submit' value='Add Member' class='btn btn-primary' />
                        </div>
                    <div>
                    <!--end username field-->
                </form>
            </div>

    <?php     
    }elseif($do == 'insert'){ //insert page
        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
            echo "<h1 class= 'text-center'>Insert Member</h1>";
            echo "<div class='container'>";
            //Upload Variables
            $avatarName = $_FILES["avatar"]["name"];
            $avatarSize = $_FILES["avatar"]["size"];
            $avatarTmp  = $_FILES["avatar"]["tmp_name"];
            $avatarType = $_FILES["avatar"]["type"];
            // list of Allowed file typed to Upload
            $avatarAllowedExtentions = array("jpeg", "jpg", "png", "gif");
            //Get Avatar Extentions
            $avatarExtentions = strtolower(end(explode('.', $avatarName)));

            //Get Variables From the Form
            $username  = $_POST['username'];
            $pass      = $_POST['password'];
            $email     = $_POST['email'];
            $fullname  = $_POST['full'];

            $hashpass = sha1($_POST['password']);
            //validate the form
            $formerrors = array();
            if(strlen($username) < 4){
                $formerrors[] = 'user name must be more than <strong>4 characters</strong>';
            }
            if(strlen($username) > 20){
                $formerrors[] = 'user name must be less than <strong>20 characters</strong>';
            }
            if(empty($username)){
                $formerrors[] = 'you can\'t leave <strong>username input empty</strong>';
            }
            if(empty($pass)){
                $formerrors[] = 'you can\'t leave <strong>password input empty</strong>';
            }
            if(empty($email)){
                $formerrors[] = 'you can\'t leave <strong>email input empty</strong>';
            }
            if(empty($fullname)){
                $formerrors[] = 'you can\'t leave <strong>fullname input empty</strong>';
            }
            if(! empty($avatarName) && ! in_array($avatarExtentions, $avatarAllowedExtentions)){
                $formerrors[] = "This Extintion Is Not <strong>Allowed</strong>";
            }
            if(empty($avatarName)){
                $formerrors[] = "Avatar Is <strong>Requierd</strong>";
            }
            if($avatarSize > 4194304){
                $formerrors[] = "Avatar Can't Be Larger Than <strong>4MB</strong>";
            }
            foreach($formerrors as $error){
                echo '<div class="alert alert-danger">' . $error . '</div>';
            }
            //Check if there is no error procceed the update operation
            if(empty($formerrors)){
                $avatar = rand(0, 100000000) . "_" . $avatarName;
                move_uploaded_file($avatarTmp, "uploads\avatar\\" . $avatar);
                //check if user exist in database
                $check = checkItems('username', 'users', $username);
                if($check == 1){
                    $theMsg = "<div class='alert alert-danger'>sorry this user name is already exist</div>";
                    redirectHome($theMsg, 'back');

                }else{
                //insert user info in database
                $stmt = $con->prepare('INSERT INTO users(username, password, email, fullname, RegStatus, Date, avatar) VALUES (:zname, :zpass, :zemail, :zfull, 1, now(), :zavatar)');
                $stmt->execute(array(
                    'zname'  => $username,
                    'zpass'  => $hashpass,
                    'zemail' => $email,
                    'zfull'  => $fullname,
                    'zavatar'=> $avatar
                ));

                $theMsg = "<div class='alert alert-success'>" . $stmt->rowcount() . 'record inserted </div>';
                redirectHome($theMsg,"back");

                }
                
            }
            //UPDATE the database with info
            
        }else{
            echo "<h1 class= 'text-center'>ERROR</h1>";
            echo "<div class='container'>";
                $theMsg ='<div class="alert alert-danger">No you can not show this page directly</div>';
                redirectHome($theMsg);
            echo "</div>";
        }
        echo "</div>";
    }elseif($do == 'edit'){ //edit page
        /*if(isset($_GET['userid']) && is_numeric($_GET['userid'])){
            $userID = $_GET['userid'];
            echo intval($userID);
        } else{
            echo 0;
        }*/
        $userID = isset($_GET['userID']) && is_numeric($_GET['userID']) ? intval($_GET['userID']) : 0;
        $stmt = $con->prepare("SELECT * FROM users WHERE userID= ? LIMIT 1");
        $stmt->execute(array($userID));
        $row = $stmt->fetch();
        $count = $stmt->rowCount();
        if($count > 0){?>
            <h1 class= 'text-center'>Edit Member</h1>
            <div class= 'container'>
                <form class= 'form-horizontal' action='?do=update' method='post'>
                    <input type='hidden' name='userID' value='<?php echo $userID ?>' />
                    <!--start username field-->
                    <div class='form-group form-group-lg'>
                        <label class='col-sm-2 control-label text-center'>Username</label>
                        <div class='col-sm-10 col-md-5'>
                            <input type='text' name='username' value= '<?php echo $row['username'] ?>' class='form-control' autocomplete = 'off' required='required'/>
                        </div>
                    <div>
                    <!--end username field-->
                    <!--start password field-->
                    <div class='form-group form-group-lg'>
                        <label class='col-sm-2 control-label text-center'>Password</label>
                        <div class='col-sm-10 col-md-5'>
                            <input type='hidden' name='oldpassword' value='<?php echo $row['password'] ?>' />
                            <input type='password' name='newpassword' class='form-control' autocomplete= 'new-password' placeholder= "Leave Blank If You Don't Change It"/>
                        </div>
                    <div>
                    <!--end password field-->
                    <!--start e-mail field-->
                    <div class='form-group form-group-lg'>
                        <label class='col-sm-2 control-label text-center'>E-mail</label>
                        <div class='col-sm-10 col-md-5'>
                            <input type='email' name='email' value= '<?php echo $row['email'] ?>' class='form-control' required='required' />
                        </div>
                    <div>
                    <!--end e-mail field-->
                    <!--start fullname field-->
                    <div class='form-group form-group-lg'>
                        <label class='col-sm-2 control-label text-center'>Fullname</label>
                        <div class='col-sm-10 col-md-5'>
                            <input type='text' name='full' value= '<?php echo $row['fullname'] ?>'  class='form-control' required='required' />
                        </div>
                    <div>
                    <!--end fullname field-->
                    <!--start username field-->
                    <div class='form-group form-group-lg'>
                        <div class='col-sm-offset-2 col-sm-10'>
                            <input type='submit' value='Save' class='btn btn-primary' />
                        </div>
                    <div>
                    <!--end username field-->
                </form>
            </div>
    <?php
        // if there is no such id show error message
        }else{
            echo "<h1 class= 'text-center'>ERROR</h1>";
            echo "<div class='container'>";
                $theMsg ='<div class="alert alert-danger">there is no such id</div>';
                redirectHome($theMsg);
            echo "</div>";
        }
    } elseif($do == 'update'){ //update page
        echo "<h1 class= 'text-center'>Update Member</h1>";
        echo "<div class='container'>";
        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
            $id        = $_POST['userID'];
            $username  = $_POST['username'];
            $email     = $_POST['email'];
            $fullname  = $_POST['full'];
            //password trick
            $pass = empty($_POST['newpassword']) ? $_POST['oldpassword'] : sha1($_POST['newpassword']);
            /*$pass = '';
            if(empty($_POST['newpassword'])){
                $pass= $_POST['oldpassword'];
            }else {
                $pass= sha1($_POST['newpassword']);
            }*/
            //validate the form
            $formerrors = array();
            if(strlen($username) < 4){
                $formerrors[] = 'user name must be more than <strong>4 characters</strong>';
            }
            if(strlen($username) > 20){
                $formerrors[] = 'user name must be less than <strong>20 characters</strong>';
            }
            if(empty($username)){
                $formerrors[] = 'you can\'t leave <strong>username input empty</strong>';
            }
            if(empty($email)){
                $formerrors[] = 'you can\'t leave <strong>email input empty</strong>';
            }
            if(empty($fullname)){
                $formerrors[] = 'you can\'t leave <strong>fullname input empty</strong>';
            }
            foreach($formerrors as $error){
                echo '<div class="alert alert-danger">' . $error . '</div>';
            }
            //Check if there is no error procceed the update operation
            if(empty($formerrors)){
                $stmt2 = $con->prepare("SELECT * FROM users WHERE username = ? AND userID != ?");
                $stmt2->execute(array($username, $id));
                $count = $stmt2->rowCount();
                if($count == 1){
                    $theMsg = "<div class='alert alert-danger'>Sorry this Username Is Exist </div>";
                    redirectHome($theMsg,"back");
                }else{
                    $stmt = $con->prepare('UPDATE users SET username= ? , email= ? , fullname= ?, password= ? WHERE userID= ?');
                    $stmt->execute(array($username, $email, $fullname, $pass, $id));
                    $theMsg = "<div class='alert alert-success'>" . $stmt->rowcount() . 'record Update </div>';
                    redirectHome($theMsg,"back");
                }
            }
            //UPDATE the database with info

        }else{
                $theMsg ='<div class="alert alert-danger">No you can show anything in this page</div>';
                redirectHome($theMsg,"back");
        }
        echo "</div>";
    }elseif($do == 'delete'){ //delete member page
        echo "<h1 class= 'text-center'>Delete Member</h1>";
        echo "<div class='container'>";
            $userID = isset($_GET['userID']) && is_numeric($_GET['userID']) ? intval($_GET['userID']) : 0;
            $check = checkItems('userID', 'users', $userID);
            if($check > 0){
                $stmt = $con->prepare('DELETE FROM users WHERE userID= :zuser');
                $stmt->bindParam(':zuser', $userID);
                $stmt->execute();
                $theMsg = "<div class='alert alert-success'>" . $stmt->rowcount() . 'record Deleted </div>';
                redirectHome($theMsg,"back");
            }else{
                $theMsg = '<div class="alert alert-danger">This id is not exist</div>';
                redirectHome($theMsg,"back");
            }
        echo '</div>';
    }elseif($do == 'activate'){
        echo "<h1 class= 'text-center'>Activate Member</h1>";
        echo "<div class='container'>";
            $userID = isset($_GET['userID']) && is_numeric($_GET['userID']) ? intval($_GET['userID']) : 0;
            $check = checkItems('userID', 'users', $userID);
            if($check > 0){
                $stmt = $con->prepare('UPDATE users SET RegStatus=1 WHERE userID=?');
                $stmt->execute(array($userID));
                $theMsg = "<div class='alert alert-success'>" . $stmt->rowcount() . 'record Updated </div>';
                redirectHome($theMsg,"back");
            }else{
                $theMsg = '<div class="alert alert-danger">This id is not exist</div>';
                redirectHome($theMsg,"back");
            }
        echo '</div>';    }
    include $tmp . 'footer.php';

} else{
    header('location: index.php');
    exit();
}
ob_end_flush();

