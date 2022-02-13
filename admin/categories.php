<?php
/*
********************************************************************************
**  Category Page

********************************************************************************
*/
ob_start(); //output buffering start
session_start();
$pagetitle = 'Categories';
if(isset($_SESSION['username'])){
    include 'init.php';
    $do = "";
    if(isset($_GET['do'])){
        $do = $_GET['do'];
    }else{
        $do = 'manage';
    }
    if($do == 'manage'){
        $sort = "asc";
        $sort_array = array("asc", "desc");
        if(isset($_GET["sort"]) && in_array($_GET["sort"], $sort_array)){
            $sort = $_GET["sort"];
        }
        $stmt2 = $con->prepare("SELECT * FROM categories WHERE parent = 0 ORDER BY Ordering $sort");
        $stmt2->execute();
        $cats = $stmt2->fetchAll();
        if(!empty($cats)){
        ?>
        <h1 class="text-center">Manage Categories</h1>
        <div class="container categories">
            <div class="panel panel-default">
                <div class="panel-heading">Manage Categories
                    <div class="option pull-right">
                        Ordering:[ 
                        <a class="<?php if($sort == "asc"){echo "active";} ?> href=?sort=asc">Asc</a> |
                        <a class="<?php if($sort == "desc"){echo "active";} ?> href=?sort=desc">Desc</a> ]
                        view:[ 
                        <span class="active" data-view="full">Full</span>
                        <span>Classic</span> ]
                    </div>
                </div>
                <div class="panel-body" style="background-color: #fff;">
                    <?php
                        foreach($cats as $cat){
                            echo "<div class='cat'>";
                                echo "<div class='hidden-buttons'>";
                                    echo "<a href='categories.php?do=edit&catID=". $cat["ID"] ." ' class='btn btn-xs btn-primary'><i class='fa fa-edit'></i>Edit</a>";
                                    echo "<a href='categories.php?do=delete&catID=". $cat["ID"] ." ' class='confirm btn btn-xs btn-danger'><i class='fa fa-close'></i>Delete</a>";
                                echo "</div>";
                                echo "<h3>" . $cat["Name"] . "</h3>";
                                echo "<div class='full-view'>";
                                echo "<p>"; if($cat["Description"] == ""){echo"This Category Has No Description";}else{echo $cat["Description"];}  echo"</p>";
                                    if($cat["Visibility"] == 1){echo "<span class='visibility prop'>Hidden</span>";}
                                    if($cat["Allow_Comment"] == 1){echo "<span class='commenting prop'>Comment Disabled</span>";}
                                    if($cat["Allow_Ads"] == 1){echo "<span class='advertises prop'>Ads Disabled</span>";}
                                echo "</div>";
                                $childCats = getAllFrom("*", "categories", "WHERE parent = {$cat['ID']}", "", "ID", "ASC");
                                if(! empty($childCats)){
                                    echo "<h6 class='child-head'>Child Categories</h6>";
                                    echo "<ul class='list-unstyled child-cats'>";
                                    foreach($childCats as $c){
                                        echo "<li class='child-link'>";
                                            echo "<a href='categories.php?do=edit&catID=". $c["ID"] ." '>" . $c['Name'] . "</a>";
                                            echo "<a href='categories.php?do=delete&catID=". $c["ID"] ." ' class='show-delete confirm'>Delete</a>";
                                        echo "</li>";
                                    }
                                    echo "</ul>";
                                }
                            echo "</div>";
                            // get child categories

                            echo "<hr>";

                        }
                        
                    ?>
                </div>
            </div>
            <a class="add-category btn btn-primary" href="categories.php?do=add"><span style="font-weight: bold;">+</span>Add New Category</a>
        </div>
        <?php
        }else{
            echo "<div class='container'>";
                echo "<div class='nice-message'>There is no Categories To Show</div>";
                echo "<a href='categories.php?do=add' class='btn btn-sm btn-primary'><strong>+</strong>New Item </a>";
            echo "</div>";
        }
    }elseif($do == 'add'){ ?>
    <h1 class= 'text-center'>Add New Category</h1>
    <div class= 'container'>
        <form class= 'form-horizontal' action='?do=insert' method='post'>
            <!--start name field-->
            <div class='form-group form-group-lg'>
                <label class='col-sm-2 control-label text-center'>Name</label>
                <div class='col-sm-10 col-md-5'>
                    <input type='text' name='name' class='form-control' autocomplete = 'off' required='required' placeholder= "Name Of Category" />
                </div>
            <div>
            <!--end name field-->
            <!--start Description field-->
            <div class='form-group form-group-lg'>
                <label class='col-sm-2 control-label text-center'>Description</label>
                <div class='col-sm-10 col-md-5'>
                    <input type='text' name='description' class='form-control' placeholder= "Number To Arrange The Categories" />
                </div>
            <div>
            <!--end Description field-->
            <!--start Ordering field-->
            <div class='form-group form-group-lg'>
                <label class='col-sm-2 control-label text-center'>Ordering</label>
                <div class='col-sm-10 col-md-5'>
                    <input type='text' name='ordering' class='form-control' placeholder= "Email Must Be Valid" />
                </div>
            <div>
            <!--end Ordering field-->
            <!--start category type-->
            <div class='form-group form-group-lg'>
                <label class='col-sm-2 control-label text-center'>Parent?</label>
                <div class='col-sm-10 col-md-5'>
                    <select name="parent">
                            <option value="0">None</option>
                            <?php
                                $allCats =getAllFrom("*", "categories", "WHERE parent = 0", "", "ID", "ASC");
                                foreach($allCats as $cat){
                                    echo "<option value='" . $cat["ID"] . "'>" . $cat["Name"] . "</option>"; 
                                }

                            ?>
                    </select>                
                </div>
            <div>
            <!--end category type-->
            <!--start Visability field-->
            <div class='form-group form-group-lg'>
                <label class='col-sm-2 control-label text-center'>Visible</label>
                <div class='col-sm-10 col-md-5'>
                    <div>
                        <input id="vis-yes" type="radio" name="visibility" value="0" checked />
                        <label for="vis-yes">Yes</label>
                    </div>
                    <div>
                        <input id="vis-no" type="radio" name="visibility" value="1" />
                        <label for="vis-no">No</label>
                    </div>
                </div>
            <div>
            <!--end Visability field-->
            <!--start Commenting field-->
            <div class='form-group form-group-lg'>
                <label class='col-sm-2 control-label text-center'>Allow Commenting</label>
                <div class='col-sm-10 col-md-5'>
                    <div>
                        <input id="com-yes" type="radio" name="commenting" value="0" checked />
                        <label for="com-yes">Yes</label>
                    </div>
                    <div>
                        <input id="com-no" type="radio" name="commenting" value="1" />
                        <label for="com-no">No</label>
                    </div>
                </div>
            <div>
            <!--end Commenting field-->
            <!--start Ads field-->
            <div class='form-group form-group-lg'>
                <label class='col-sm-2 control-label text-center'>Allow Ads</label>
                <div class='col-sm-10 col-md-5'>
                    <div>
                        <input id="ads-yes" type="radio" name="ads" value="0" checked />
                        <label for="ads-yes">Yes</label>
                    </div>
                    <div>
                        <input id="ads-no" type="radio" name="ads" value="1" />
                        <label for="ads-no">No</label>
                    </div>
                </div>
            <div>
            <!--end Ads field-->
            <!--start username field-->
            <div class='form-group form-group-lg'>
                <div class='col-sm-offset-2 col-sm-10'>
                    <input type='submit' value='Add Category' class='btn btn-primary' />
                </div>
            <div>
            <!--end username field-->
        </form>
    </div>    
    <?php
    }elseif($do == 'insert'){
        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
            echo "<h1 class= 'text-center'>Insert Category</h1>";
            echo "<div class='container'>";
            $name      = $_POST['name'];
            $desc      = $_POST['description'];
            $parent    = $_POST['parent'];
            $order     = $_POST['ordering'];
            $visible   = $_POST['visibility'];
            $comment   = $_POST['commenting'];
            $ads       = $_POST['ads'];

            //check if category exist in database
            $check = checkItems('Name', 'categories', $name);
            if($check == 1){
                $theMsg = "<div class='alert alert-danger'>sorry this category is already exist</div>";
                redirectHome($theMsg, 'back');

            }else{
            //insert category info in database
            $stmt = $con->prepare('INSERT INTO categories(Name, Description, parent, Ordering, Visibility, Allow_Comment, Allow_Ads) VALUES (:zname, :zdesc, :zparent, :zorder, :zvisible, :zcomment, :zads)');
            $stmt->execute(array(
                'zname'     => $name,
                'zdesc'     => $desc,
                "zparent"   => $parent,
                'zorder'    => $order,
                'zvisible'  => $visible,
                'zcomment'  => $comment,
                'zads'      => $ads
            ));

            $theMsg = "<div class='alert alert-success'>" . $stmt->rowcount() . 'record inserted </div>';
            redirectHome($theMsg,"back");

            }
        //UPDATE the database with info

        }else{
            echo "<h1 class= 'text-center'>ERROR</h1>";
            echo "<div class='container'>";
                $theMsg ='<div class="alert alert-danger">No you can not show this page directly</div>';
                redirectHome($theMsg, "back",5);
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
        $catID = isset($_GET['catID']) && is_numeric($_GET['catID']) ? intval($_GET['catID']) : 0;
        $stmt = $con->prepare("SELECT * FROM categories WHERE ID= ?");
        $stmt->execute(array($catID));
        $cat = $stmt->fetch();
        $count = $stmt->rowCount();
        if($count > 0){?>
        <h1 class= 'text-center'>Edit Category</h1>
    <div class= 'container'>
        <form class= 'form-horizontal' action='?do=update' method='post'>
        <input type="hidden" name="catID" value="<?php echo $catID ?>" />
            <!--start name field-->
            <div class='form-group form-group-lg'>
                <label class='col-sm-2 control-label text-center'>Name</label>
                <div class='col-sm-10 col-md-5'>
                    <input type='text' name='name' class='form-control' required='required' placeholder= "Name Of Category" value="<?php echo $cat['Name'] ?>" />
                </div>
            <div>
            <!--end name field-->
            <!--start Description field-->
            <div class='form-group form-group-lg'>
                <label class='col-sm-2 control-label text-center'>Description</label>
                <div class='col-sm-10 col-md-5'>
                    <input type='text' name='description' class='form-control' placeholder= "Descripe The Categories" value="<?php echo $cat['Description'] ?>"  />
                </div>
            <div>
            <!--end Description field-->
            <!--start Ordering field-->
            <div class='form-group form-group-lg'>
                <label class='col-sm-2 control-label text-center'>Ordering</label>
                <div class='col-sm-10 col-md-5'>
                    <input type='text' name='ordering' class='form-control' placeholder= "Arrange the category" value="<?php echo $cat['Ordering'] ?>"  />
                </div>
            <div>
            <!--end Ordering field-->
            <!--start category type-->
            <div class='form-group form-group-lg'>
                <label class='col-sm-2 control-label text-center'>Parent?</label>
                <div class='col-sm-10 col-md-5'>
                    <select name="parent">
                            <option value="0">None</option>
                            <?php
                                $allCats =getAllFrom("*", "categories", "WHERE parent = 0", "", "ID", "ASC");
                                foreach($allCats as $c){
                                    echo "<option value='" . $c["ID"] . "'";
                                    if($cat["parent"] == $c["ID"]){echo "selected";}
                                    echo ">" . $c["Name"] . "</option>"; 
                                }

                            ?>
                    </select>                
                </div>
            <div>
            <!--end category type-->
            <!--start Visability field-->
            <div class='form-group form-group-lg'>
                <label class='col-sm-2 control-label text-center'>Visible</label>
                <div class='col-sm-10 col-md-5'>
                    <div>
                        <input id="vis-yes" type="radio" name="visibility" value="0" <?php if($cat["Visibility"] == 0){echo 'checked';} ?> />
                        <label for="vis-yes">Yes</label>
                    </div>
                    <div>
                        <input id="vis-no" type="radio" name="visibility" value="1" <?php if($cat["Visibility"] == 1){echo 'checked';} ?> />
                        <label for="vis-no">No</label>
                    </div>
                </div>
            <div>
            <!--end Visability field-->
            <!--start Commenting field-->
            <div class='form-group form-group-lg'>
                <label class='col-sm-2 control-label text-center'>Allow Commenting</label>
                <div class='col-sm-10 col-md-5'>
                    <div>
                        <input id="com-yes" type="radio" name="commenting" value="0" <?php if($cat["Allow_Comment"] == 0){echo 'checked';} ?>/>
                        <label for="com-yes">Yes</label>
                    </div>
                    <div>
                        <input id="com-no" type="radio" name="commenting" value="1" <?php if($cat["Allow_Comment"] == 1){echo 'checked';} ?> />
                        <label for="com-no">No</label>
                    </div>
                </div>
            <div>
            <!--end Commenting field-->
            <!--start Ads field-->
            <div class='form-group form-group-lg'>
                <label class='col-sm-2 control-label text-center'>Allow Ads</label>
                <div class='col-sm-10 col-md-5'>
                    <div>
                        <input id="ads-yes" type="radio" name="ads" value="0" <?php if($cat["Allow_Ads"] == 0){echo 'checked';} ?> />
                        <label for="ads-yes">Yes</label>
                    </div>
                    <div>
                        <input id="ads-no" type="radio" name="ads" value="1" <?php if($cat["Allow_Ads"] == 1){echo 'checked';} ?> />
                        <label for="ads-no">No</label>
                    </div>
                </div>
            <div>
            <!--end Ads field-->
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
    }elseif($do == 'update'){
        echo "<h1 class= 'text-center'>Update Category</h1>";
        echo "<div class='container'>";
        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
            $id       = $_POST['catID'];
            $name     = $_POST['name'];
            $desc     = $_POST['description'];
            $order    = $_POST['ordering'];
            $parent   = $_POST['parent'];
            $visible  = $_POST['visibility'];
            $comment  = $_POST['commenting'];
            $ads      = $_POST['ads'];

            $stmt = $con->prepare('UPDATE categories SET Name= ? , Description= ? , Ordering= ?, parent=?, Visibility= ?, Allow_Comment= ?, Allow_Ads= ?  WHERE ID= ?');
            $stmt->execute(array($name, $desc, $order, $parent, $visible, $comment, $ads, $id));
            $theMsg = "<div class='alert alert-success'>" . $stmt->rowcount() . 'record Updated </div>';
            redirectHome($theMsg,"back");

            //UPDATE the database with info

        }else{
                $theMsg ='<div class="alert alert-danger">No you can show anything in this page</div>';
                redirectHome($theMsg,"back");
        }
        echo "</div>";
        
    }elseif($do == 'delete'){
        echo "<h1 class= 'text-center'>Delete Category</h1>";
        echo "<div class='container'>";
            $catID = isset($_GET['catID']) && is_numeric($_GET['catID']) ? intval($_GET['catID']) : 0;
            $check = checkItems('ID', 'categories', $catID);
            if($check > 0){
                $stmt = $con->prepare('DELETE FROM categories WHERE ID= :zid');
                $stmt->bindParam(':zid', $catID);
                $stmt->execute();
                $theMsg = "<div class='alert alert-success'>" . $stmt->rowcount() . 'record Deleted </div>';
                redirectHome($theMsg,"back");
            }else{
                $theMsg = '<div class="alert alert-danger">This id is not exist</div>';
                redirectHome($theMsg,"back");
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