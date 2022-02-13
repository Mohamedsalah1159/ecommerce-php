<?php
/*
********************************************************************************
**  Items Page

********************************************************************************
*/
ob_start(); //output buffering start
session_start();
$pagetitle = 'Items';
if(isset($_SESSION['username'])){
    include 'init.php';
    $do = "";
    if(isset($_GET['do'])){
        $do = $_GET['do'];
    }else{
        $do = 'manage';
    }
    if($do == 'manage'){

        $stmt = $con->prepare("SELECT items.* ,categories.name AS categoryName, users.username FROM items INNER JOIN categories ON categories.ID = items.cat_ID INNER JOIN users ON users.userID = items.member_ID ORDER BY item_ID DESC");
        $stmt->execute();
        $items = $stmt->fetchAll();
        if(! empty($items)){
        ?>
            <h1 class= 'text-center'>Manage Items</h1>
            <div class= 'container'>
                <div class='table-responsive'>
                    <table class='main-table text-center table table-bordered'>
                        <tr style='background-color: #333;color: #fff;'>
                            <td>#ID</td>
                            <td>Name</td>
                            <td>Description</td>
                            <td>price</td>
                            <td>Adding Date</td>
                            <td>Category</td>
                            <td>Username</td>
                            <td>control</td>
                        </tr>
                        <?php
                            foreach($items as $item){
                                echo '<tr>';
                                    echo '<td>' . $item['item_ID'] . '</td>';
                                    echo '<td>' . $item['Name'] . '</td>';
                                    echo '<td>' . $item['Description'] . '</td>';
                                    echo '<td>' . $item['Price'] . '</td>';
                                    echo '<td>' . $item['add_date'] . '</td>';
                                    echo '<td>' . $item['categoryName'] . '</td>';
                                    echo '<td>' . $item['username'] . '</td>';

                                    echo '<td>
                                            <a href="items.php?do=edit&itemID=' . $item['item_ID'] . '" class="btn btn-success"><i class="fa fa-edit"></i>Edit</a>
                                            <a href="items.php?do=delete&itemID=' . $item['item_ID'] . '" class="btn btn-danger confirm"><i class="fa fa-close"></i>Delete</a>';
                                            if($item['approve'] == 0){
                                                echo '<a href="items.php?do=approve&itemID=' . $item['item_ID'] . '" class="btn btn-info activate"><i class="fa fa-check"></i>Approve</a>';
                                            }
                                    echo '</td>';
                                echo '</tr>';
                            }
                        ?>
                    </table>
                </div>
                <a href='items.php?do=add' class='btn btn-sm btn-primary'><strong>+</strong>New Item </a>
            </div>
        <?php
        }else{
            echo "<div class='container'>";
                echo "<div class='nice-message'>There is no Items To Show</div>";
                echo "<a href='items.php?do=add' class='btn btn-sm btn-primary'><strong>+</strong>New Item </a>";
            echo "</div>";
        }
        
    }elseif($do == 'add'){?>
    <h1 class= 'text-center'>Add New Item</h1>
    <div class= 'container'>
        <form class= 'form-horizontal' action='?do=insert' method='post'>
            <!--start name field-->
            <div class='form-group form-group-lg'>
                <label class='col-sm-2 control-label text-center'>Name</label>
                <div class='col-sm-10 col-md-5'>
                    <input type='text' name='name' class='form-control' required='required' placeholder= "Name Of The Item" />
                </div>
            </div>
            <!--end name field-->
            <!--start Description field-->
            <div class='form-group form-group-lg'>
                <label class='col-sm-2 control-label text-center'>Description</label>
                <div class='col-sm-10 col-md-5'>
                    <input type='text' name='description' class='form-control' required='required' placeholder= "Description Of The Item" />
                </div>
            </div>
            <!--end Description field-->
            <!--start Price field-->
            <div class='form-group form-group-lg'>
                <label class='col-sm-2 control-label text-center'>Price</label>
                <div class='col-sm-10 col-md-5'>
                    <input type='text' name='price' class='form-control' required='required' placeholder= "Price Of The Item" />
                </div>
            </div>
            <!--end Price field-->
            <!--start Country field-->
            <div class='form-group form-group-lg'>
                <label class='col-sm-2 control-label text-center'>Country</label>
                <div class='col-sm-10 col-md-5'>
                    <input type='text' name='country' class='form-control' required='required' placeholder= "Country Of Made" />
                </div>
            </div>
            <!--end Country field-->
            <!--start Status field-->
            <div class='form-group form-group-lg'>
                <label class='col-sm-2 control-label text-center'>Status</label>
                <div class='col-sm-10 col-md-5'>
                    <select name="status">
                        <option value="0">...</option>
                        <option value="1">New</option>
                        <option value="2">Like New</option>
                        <option value="3">Used</option>
                        <option value="4">Very Old</option>
                    </select> 
                </div>
            </div>
            <!--end Status field-->
            <!--start Members field-->
            <div class='form-group form-group-lg'>
                <label class='col-sm-2 control-label text-center'>Member</label>
                <div class='col-sm-10 col-md-5'>
                    <select name="member">
                        <option value="0">...</option>
                        <?php
                            $allMembers = getAllFrom("*", "users", "", "", "userID");
                            foreach($allMembers as $user){
                                echo "<option value='" . $user["userID"] . "'>" . $user["username"] . "</option>";
                            }
                        ?>
                    </select> 
                </div>
            </div>
            <!--end Members field-->
            <!--start category field-->
            <div class='form-group form-group-lg'>
                <label class='col-sm-2 control-label text-center'>Category</label>
                <div class='col-sm-10 col-md-5'>
                    <select name="category">
                        <option value="0">...</option>
                        <?php
                            $allcats = getAllFrom("*", "categories", "WHERE parent = 0", "", "ID", "ASC");
                            foreach($allcats as $cat){
                                echo "<option value='" . $cat["ID"] . "'>" . $cat["Name"] . "</option>";
                                $childcats = getAllFrom("*", "categories", "WHERE parent = {$cat['ID']}", "", "ID", "ASC");
                                foreach($childcats as $child){
                                    echo "<option value='" . $child["ID"] . "'> --- " . $child["Name"] . " Child Of " . $cat["Name"] . "</option>";
                                }
                            }
                        ?>
                    </select> 
                </div>
            </div>
            <!--end category field-->
            <!--start tags field-->
            <div class='form-group form-group-lg'>
                <label class='col-sm-2 control-label text-center'>Tags</label>
                <div class='col-sm-10 col-md-5'>
                    <input type='text' name='tags' class='form-control' placeholder= "Separate Tags With Comma(,)" />
                </div>
            </div>
            <!--end tags field-->
            <!--start username field-->
            <div class='form-group form-group-lg'>
                <div class='col-sm-offset-2 col-sm-10'>
                    <input type='submit' value='Add Item' class='btn btn-primary btn-sm' />
                </div>
            </div>
            <!--end username field-->
        </form>
    </div>    
    <?php

    }elseif($do == 'insert'){
        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
            echo "<h1 class= 'text-center'>Insert Item</h1>";
            echo "<div class='container'>";
            $name      = $_POST['name'];
            $desc      = $_POST['description'];
            $price     = $_POST['price'];
            $country   = $_POST['country'];
            $status    = $_POST['status'];
            $member    = $_POST['member'];
            $cat       = $_POST['category'];
            $tags      = $_POST['tags'];

            //validate the form
            $formerrors = array();
            if(empty($name)){
                $formerrors[] = 'Name can\'t be <strong>empty</strong>';
            }
            if(empty($desc)){
                $formerrors[] = 'Description can\'t be <strong>empty</strong>';
            }
            if(empty($price)){
                $formerrors[] = 'Price can\'t be <strong>empty</strong>';
            }
            if(empty($country)){
                $formerrors[] = 'Country can\'t be <strong>empty</strong>';
            }
            if($status == 0){
                $formerrors[] = 'you must choose <strong>the status</strong>';
            }
            if($member == 0){
                $formerrors[] = 'you must choose <strong>the member</strong>';
            }
            if($cat == 0){
                $formerrors[] = 'you must choose <strong>the category</strong>';
            }
            foreach($formerrors as $error){
                echo '<div class="alert alert-danger">' . $error . '</div>';
            }
            //Check if there is no error procceed the update operation
            if(empty($formerrors)){
                //insert user info in database
                $stmt = $con->prepare('INSERT INTO items(Name, Description, Price, country_made, status, add_date, cat_ID, member_ID, tags) VALUES (:zname, :zdesc, :zprice, :zcountry, :zstatus, now(), :zcat, :zmember, :ztags)');
                $stmt->execute(array(
                    'zname'     => $name,
                    'zdesc'     => $desc,
                    'zprice'    => $price,
                    'zcountry'  => $country,
                    'zstatus'   => $status,
                    'zcat'      => $cat,
                    'zmember'   => $member,
                    "ztags"     => $tags
                ));
                $theMsg = "<div class='alert alert-success'>" . $stmt->rowcount() . 'record inserted </div>';
                redirectHome($theMsg,"back");
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
    }elseif($do == 'edit'){
            /*if(isset($_GET['itemID']) && is_numeric($_GET['itemID'])){
            $userID = $_GET['itemID'];
            echo intval($itemID);
        } else{
            echo 0;
        }*/
        $itemID = isset($_GET['itemID']) && is_numeric($_GET['itemID']) ? intval($_GET['itemID']) : 0;
        $stmt = $con->prepare("SELECT * FROM items WHERE item_ID= ?");
        $stmt->execute(array($itemID));
        $item = $stmt->fetch();
        $count = $stmt->rowCount();
        if($count > 0){?>
    <h1 class= 'text-center'>Edit Item</h1>
    <div class= 'container'>
        <form class= 'form-horizontal' action='?do=update' method='post'>
        <input type='hidden' name='itemid' value='<?php echo $itemID ?>' />
            <!--start name field-->
            <div class='form-group form-group-lg'>
                <label class='col-sm-2 control-label text-center'>Name</label>
                <div class='col-sm-10 col-md-5'>
                    <input type='text' name='name' class='form-control' required='required' placeholder= "Name Of The Item" value="<?php echo $item['Name'] ?>"/>
                </div>
            <div>
            <!--end name field-->
            <!--start Description field-->
            <div class='form-group form-group-lg'>
                <label class='col-sm-2 control-label text-center'>Description</label>
                <div class='col-sm-10 col-md-5'>
                    <input type='text' name='description' class='form-control' required='required' placeholder= "Description Of The Item" value="<?php echo $item['Description'] ?>" />
                </div>
            <div>
            <!--end Description field-->
            <!--start Price field-->
            <div class='form-group form-group-lg'>
                <label class='col-sm-2 control-label text-center'>Price</label>
                <div class='col-sm-10 col-md-5'>
                    <input type='text' name='price' class='form-control' required='required' placeholder= "Price Of The Item" value="<?php echo $item['Price'] ?>" />
                </div>
            <div>
            <!--end Price field-->
            <!--start Country field-->
            <div class='form-group form-group-lg'>
                <label class='col-sm-2 control-label text-center'>Country</label>
                <div class='col-sm-10 col-md-5'>
                    <input type='text' name='country' class='form-control' required='required' placeholder= "Country Of Made" value="<?php echo $item['country_made'] ?>"/>
                </div>
            <div>
            <!--end Country field-->
            <!--start Status field-->
            <div class='form-group form-group-lg'>
                <label class='col-sm-2 control-label text-center'>Status</label>
                <div class='col-sm-10 col-md-5'>
                    <select name="status">
                        <option value="1" <?php if($item["status"] == 1){echo 'selected';} ?>>New</option>
                        <option value="2" <?php if($item["status"] == 2){echo 'selected';} ?>>Like New</option>
                        <option value="3" <?php if($item["status"] == 3){echo 'selected';} ?>>Used</option>
                        <option value="4" <?php if($item["status"] == 4){echo 'selected';} ?>>Very Old</option>
                    </select> 
                </div>
            <div>
            <!--end Status field-->
            <!--start Members field-->
            <div class='form-group form-group-lg'>
                <label class='col-sm-2 control-label text-center'>Member</label>
                <div class='col-sm-10 col-md-5'>
                    <select name="member">
                        <?php
                            $stmt = $con->prepare("SELECT * FROM users");
                            $stmt->execute();
                            $users = $stmt->fetchAll();
                            foreach($users as $user){
                                echo "<option value='" . $user["userID"] . "'";
                                if($item["member_ID"] == $user["userID"]){echo 'selected';}
                                echo ">" . $user["username"] . "</option>";
                            }
                        ?>
                    </select> 
                </div>
            <div>
            <!--end Members field-->
            <!--start Categories field-->
            <div class='form-group form-group-lg'>
                <label class='col-sm-2 control-label text-center'>Category</label>
                <div class='col-sm-10 col-md-5'>
                    <select name="category">
                        <?php
                            $stmt2 = $con->prepare("SELECT * FROM categories");
                            $stmt2->execute();
                            $cats = $stmt2->fetchAll();
                            foreach($cats as $cat){
                                echo "<option value='" . $cat["ID"] . "'";
                                if($item["cat_ID"] == $cat["ID"]){echo 'selected';}
                                echo ">" . $cat["Name"] . "</option>";
                            }
                        ?>
                    </select> 
                </div>
            <div>
            <!--end Categories field-->
            <!--start tags field-->
            <div class='form-group form-group-lg'>
                <label class='col-sm-2 control-label text-center'>Tags</label>
                <div class='col-sm-10 col-md-5'>
                    <input type='text' name='tags' class='form-control' placeholder= "Separate Tags With Comma(,)" value="<?php echo $item['tags']?>" />
                </div>
            </div>
            <!--end tags field-->
            <!--start username field-->
            <div class='form-group form-group-lg'>
                <div class='col-sm-offset-2 col-sm-10'>
                    <input type='submit' value='Save Item' class='btn btn-primary btn-sm' />
                </div>
            <div>
            <!--end username field-->
        </form>
        <?php
        //select all users except admin
        $stmt = $con->prepare("SELECT comments.*, users.username AS User FROM comments INNER JOIN users ON users.userID = comments.user_ID WHERE item_ID=?");
        $stmt->execute(array($itemID));
        $rows = $stmt->fetchAll();
        if(! empty($rows)){
            ?>
            <h1 class= 'text-center'>Manage [<?php echo $item['Name'] ?>] Comments</h1>
                <div class='table-responsive'>
                    <table class='main-table text-center table table-bordered'>
                        <tr style='background-color: #333;color: #fff;'>
                            <td>Comment</td>
                            <td>User Name</td>
                            <td>Added Date</td>
                            <td>control</td>
                        </tr>
                        <?php
                            foreach($rows as $row){
                                echo '<tr>';
                                    echo '<td>' . $row['comment'] . '</td>';
                                    echo '<td>' . $row['User'] . '</td>';
                                    echo '<td>' . $row['comment_date'] . '</td>';
                                    echo '<td>
                                            <a href="comments.php?do=edit&comid=' . $row['c_ID'] . '" class="btn btn-success"><i class="fa fa-edit"></i>Edit</a>
                                            <a href="comments.php?do=delete&comid=' . $row['c_ID'] . '" class="btn btn-danger confirm"><i class="fa fa-close"></i>Delete</a>';
                                            if($row['status'] == 0){
                                            echo '<a href="comments.php?do=approve&comid=' . $row['c_ID'] . '" class="btn btn-info activate"><i class="fa fa-check"></i>Approve</a>';
                                            }
                                    echo '</td>';
                                echo '</tr>';
                            }
                        ?>
                    </table>
                </div>
        <?php
        }
        ?>

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
    }elseif($do == 'update'){
        echo "<h1 class= 'text-center'>Update Item</h1>";
        echo "<div class='container'>";
        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
            $id         = $_POST['itemid'];
            $name       = $_POST['name'];
            $desc       = $_POST['description'];
            $price      = $_POST['price'];
            $country    = $_POST['country'];
            $status     = $_POST['status'];
            $member     = $_POST['member'];
            $cat        = $_POST['category'];
            $tags       = $_POST['tags'];


            //validate the form
            $formerrors = array();
            if(empty($name)){
                $formerrors[] = 'Name can\'t be <strong>empty</strong>';
            }
            if(empty($desc)){
                $formerrors[] = 'Description can\'t be <strong>empty</strong>';
            }
            if(empty($price)){
                $formerrors[] = 'Price can\'t be <strong>empty</strong>';
            }
            if(empty($country)){
                $formerrors[] = 'Country can\'t be <strong>empty</strong>';
            }
            if($status == 0){
                $formerrors[] = 'you must choose <strong>the status</strong>';
            }
            if($member == 0){
                $formerrors[] = 'you must choose <strong>the member</strong>';
            }
            if($cat == 0){
                $formerrors[] = 'you must choose <strong>the category</strong>';
            }
            foreach($formerrors as $error){
                echo '<div class="alert alert-danger">' . $error . '</div>';
            }
            //Check if there is no error procceed the update operation
            if(empty($formerrors)){
                $stmt = $con->prepare('UPDATE items SET Name= ? , Description= ? , Price= ?, country_made= ?, status=?, member_ID=?, cat_ID=?, tags=? WHERE item_ID= ?');
                $stmt->execute(array($name, $desc, $price, $country, $status, $member, $cat, $tags, $id));
                $theMsg = "<div class='alert alert-success'>" . $stmt->rowcount() . 'record Updated </div>';
                redirectHome($theMsg,"back");
            }
            //UPDATE the database with info

        }else{
                $theMsg ='<div class="alert alert-danger">No you can show anything in this page</div>';
                redirectHome($theMsg,"back");
        }
        echo "</div>";
    }elseif($do == 'delete'){
        echo "<h1 class= 'text-center'>Delete Item</h1>";
        echo "<div class='container'>";
            $itemID = isset($_GET['itemID']) && is_numeric($_GET['itemID']) ? intval($_GET['itemID']) : 0;
            $check = checkItems('item_ID', 'items', $itemID);
            if($check > 0){
                $stmt = $con->prepare('DELETE FROM items WHERE item_ID= :zid');
                $stmt->bindParam(':zid', $itemID);
                $stmt->execute();
                $theMsg = "<div class='alert alert-success'>" . $stmt->rowcount() . 'record Deleted </div>';
                redirectHome($theMsg,"back");
            }else{
                $theMsg = '<div class="alert alert-danger">This id is not exist</div>';
                redirectHome($theMsg,"back");
            }
        echo '</div>';
    }elseif($do == 'approve'){
        echo "<h1 class= 'text-center'>Approve Item</h1>";
        echo "<div class='container'>";
            $itemID = isset($_GET['itemID']) && is_numeric($_GET['itemID']) ? intval($_GET['itemID']) : 0;
            $check = checkItems('item_ID', 'items', $itemID);
            if($check > 0){
                $stmt = $con->prepare('UPDATE items SET approve=1 WHERE item_ID=?');
                $stmt->execute(array($itemID));
                $theMsg = "<div class='alert alert-success'>" . $stmt->rowcount() . 'record Updated </div>';
                redirectHome($theMsg,"back");
            }else{
                $theMsg = '<div class="alert alert-danger">This id is not exist</div>';
                redirectHome($theMsg);
            }
        echo '</div>';  
    }
    include $tmp . 'footer.php';

} else{
    header('location: index.php');
    exit();
}

    ob_end_flush(); //Release the output
?>