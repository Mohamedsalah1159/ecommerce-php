<?php
/*
********************************************************************************
**Mange comments Page
** You can Edit | Delete | Approve comments from here

********************************************************************************
*/
ob_start(); //output buffering start
session_start();
$pagetitle = 'Comments';
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

        //select all users except admin
        $stmt = $con->prepare("SELECT comments.*, items.Name AS Item_Name, users.username AS User FROM comments INNER JOIN items ON items.item_ID = comments.item_ID INNER JOIN users ON users.userID = comments.user_ID ORDER BY c_ID DESC");
        $stmt->execute();
        $comments = $stmt->fetchAll();

        if(! empty($comments)){
            ?>
            <h1 class= 'text-center'>Manage Comments</h1>
            <div class= 'container'>
                <div class='table-responsive'>
                    <table class='main-table text-center table table-bordered'>
                        <tr style='background-color: #333;color: #fff;'>
                            <td>#ID</td>
                            <td>Comment</td>
                            <td>Item Name</td>
                            <td>User Name</td>
                            <td>Added Date</td>
                            <td>control</td>
                        </tr>
                        <?php
    
                            foreach($comments as $comment){
                                echo '<tr>';
                                    echo '<td>' . $comment['c_ID'] . '</td>';
                                    echo '<td>' . $comment['comment'] . '</td>';
                                    echo '<td>' . $comment['Item_Name'] . '</td>';
                                    echo '<td>' . $comment['User'] . '</td>';
                                    echo '<td>' . $comment['comment_date'] . '</td>';
                                    echo '<td>
                                            <a href="comments.php?do=edit&comid=' . $comment['c_ID'] . '" class="btn btn-success"><i class="fa fa-edit"></i>Edit</a>
                                            <a href="comments.php?do=delete&comid=' . $comment['c_ID'] . '" class="btn btn-danger confirm"><i class="fa fa-close"></i>Delete</a>';
                                            if($comment['status'] == 0){
                                            echo '<a href="comments.php?do=approve&comid=' . $comment['c_ID'] . '" class="btn btn-info activate"><i class="fa fa-check"></i>Approve</a>';
                                            }
                                    echo '</td>';
                                echo '</tr>';
                            }
                        ?>
                    </table>
                </div>
            </div>    
        <?php    
        }else{
            echo "<div class='container'>";
                echo "<div class='nice-message'>There is no Comments To Show</div>";
            echo "</div>";
        }
        }elseif($do == 'edit'){ //edit page
        /*if(isset($_GET['userid']) && is_numeric($_GET['userid'])){
            $userID = $_GET['userid'];
            echo intval($userID);
        } else{
            echo 0;
        }*/
        $comid = isset($_GET['comid']) && is_numeric($_GET['comid']) ? intval($_GET['comid']) : 0;
        $stmt = $con->prepare("SELECT * FROM comments WHERE c_ID= ?");
        $stmt->execute(array($comid));
        $row = $stmt->fetch();
        $count = $stmt->rowCount();
        if($count > 0){?>
            <h1 class= 'text-center'>Edit Comment</h1>
            <div class= 'container'>
                <form class= 'form-horizontal' action='?do=update' method='post'>
                    <input type='hidden' name='comid' value='<?php echo $comid ?>' />
                    <!--start comment field-->
                    <div class='form-group form-group-lg'>
                        <label class='col-sm-2 control-label text-center'>Comment</label>
                        <div class='col-sm-10 col-md-5'>
                            <textarea class="form-control" name="comment"><?php echo $row["comment"] ?></textarea>
                        </div>
                    <div>
                    <!--end comment field-->
                    <!--start submit field-->
                    <div class='form-group form-group-lg'>
                        <div class='col-sm-offset-2 col-sm-10'>
                            <input type='submit' value='Save' class='btn btn-primary' />
                        </div>
                    <div>
                    <!--end submit field-->
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
        echo "<h1 class= 'text-center'>Update Comment</h1>";
        echo "<div class='container'>";
        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
            $comid    = $_POST['comid'];
            $comment  = $_POST['comment'];

            //Check if there is no error procceed the update operation
            $stmt = $con->prepare('UPDATE comments SET comment= ? WHERE c_ID= ?');
            $stmt->execute(array($comment, $comid));
            $theMsg = "<div class='alert alert-success'>" . $stmt->rowcount() . 'record Update </div>';
            redirectHome($theMsg,"back");

            //UPDATE the database with info

        }else{
                $theMsg ='<div class="alert alert-danger">No you can show anything in this page</div>';
                redirectHome($theMsg,"back");
        }
        echo "</div>";
    }elseif($do == 'delete'){ //delete comment page
        echo "<h1 class= 'text-center'>Delete Comment</h1>";
        echo "<div class='container'>";
            $comid = isset($_GET['comid']) && is_numeric($_GET['comid']) ? intval($_GET['comid']) : 0;
            $check = checkItems('c_ID', 'comments', $comid);
            if($check > 0){
                $stmt = $con->prepare('DELETE FROM comments WHERE c_ID= :zid');
                $stmt->bindParam(':zid', $comid);
                $stmt->execute();
                $theMsg = "<div class='alert alert-success'>" . $stmt->rowcount() . 'record Deleted </div>';
                redirectHome($theMsg,"back");
            }else{
                $theMsg = '<div class="alert alert-danger">This id is not exist</div>';
                redirectHome($theMsg,"back");
            }
        echo '</div>';
    }elseif($do == 'approve'){
        echo "<h1 class= 'text-center'>Approve Comment</h1>";
        echo "<div class='container'>";
            $comid = isset($_GET['comid']) && is_numeric($_GET['comid']) ? intval($_GET['comid']) : 0;
            $check = checkItems('c_ID', 'comments', $comid);
            if($check > 0){
                $stmt = $con->prepare('UPDATE comments SET status = 1 WHERE c_ID=?');
                $stmt->execute(array($comid));
                $theMsg = "<div class='alert alert-success'>" . $stmt->rowcount() . 'record Approved </div>';
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

