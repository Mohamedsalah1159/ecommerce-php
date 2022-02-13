<?php
session_start();
$pagetitle = 'Create New Item';
include 'init.php';
if(isset($_SESSION["user"])){
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $formErrors = array();

        $name       = filter_var($_POST["name"], FILTER_SANITIZE_STRING);
        $desc       = filter_var($_POST["description"], FILTER_SANITIZE_STRING);
        $price      = filter_var($_POST["price"], FILTER_SANITIZE_NUMBER_INT);
        $country    = filter_var($_POST["country"], FILTER_SANITIZE_STRING);
        $status     = filter_var($_POST["status"], FILTER_SANITIZE_NUMBER_INT);
        $category   = filter_var($_POST["category"], FILTER_SANITIZE_NUMBER_INT);
        $tags       = filter_var($_POST["tags"], FILTER_SANITIZE_STRING);
        if(strlen($name) < 4){
            $formErrors[] = "Item Title Must Be More Than 4 Characters ";
        }
        if(strlen($desc) < 10){
            $formErrors[] = "Item Description Must Be More Than 10 Characters ";
        }
        if(strlen($country) < 2){
            $formErrors[] = "Item Country Must Be More Than 2 Characters ";
        }
        if(empty($price)){
            $formErrors[] = "Item Price Must Be Not Empty";
        }
        if(empty($status)){
            $formErrors[] = "Item Status Must Be Not Empty";
        }
        if(empty($category)){
            $formErrors[] = "Item Category Must Be Not Empty";
        }
        if(empty($formErrors)){
            //insert user info in database
            $stmt = $con->prepare('INSERT INTO items(Name, Description, Price, country_made, status, add_date, cat_ID, member_ID, tags) VALUES (:zname, :zdesc, :zprice, :zcountry, :zstatus, now(), :zcat, :zmember, :ztags)');
            $stmt->execute(array(
                'zname'     => $name,
                'zdesc'     => $desc,
                'zprice'    => $price,
                'zcountry'  => $country,
                'zstatus'   => $status,
                'zcat'      => $category,
                'zmember'   => $_SESSION["uid"],
                'ztags'     => $tags
            ));
            if($stmt){
                $successMsg ="Item Has Been Added";
            }
        }
    }

?>
<h1 class="text-center"><?php echo $pagetitle ?></h1>
<div class="create-ad block">
    <div class="container">
        <div class="panel panel-primary" style="border: 1px solid #0b5ed7;">
            <div class="panel-heading" style="color: #fff;background-color: #0b5ed7;padding: 10px;"><?php echo $pagetitle ?></div>
            <div class="panel-body" style="padding: 10px;">
                <div class="row">
                    <div class="col-md-8">
                        <form class= 'form-horizontal' action='<?php echo $_SERVER["PHP_SELF"] ?>' method='post'>
                            <!--start name field-->
                            <div class='form-group form-group-lg'>
                                <label class='col-sm-3 control-label text-center'>Name</label>
                                <div class='col-sm-10 col-md-9'>
                                    <input pattern=".{4,}" title="This field Require At Least 4 Characters" type='text' name='name' class='form-control live' required='required' placeholder= "Name Of The Item" data-class=".live-title"/>
                                </div>
                            </div>
                            <!--end name field-->
                            <!--start Description field-->
                            <div class='form-group form-group-lg'>
                                <label class='col-sm-3 control-label text-center'>Description</label>
                                <div class='col-sm-10 col-md-9'>
                                    <input pattern=".{10,}" title="This field Require At Least 10 Characters" type='text' name='description' class='form-control live' required='required' placeholder= "Description Of The Item" data-class=".live-desc"/>
                                </div>
                            </div>
                            <!--end Description field-->
                            <!--start Price field-->
                            <div class='form-group form-group-lg'>
                                <label class='col-sm-3 control-label text-center'>Price</label>
                                <div class='col-sm-10 col-md-9'>
                                    <input type='text' name='price' class='form-control live' required='required' placeholder= "Price Of The Item" data-class=".live-price"/>
                                </div>
                            </div>
                            <!--end Price field-->
                            <!--start Country field-->
                            <div class='form-group form-group-lg'>
                                <label class='col-sm-3 control-label text-center'>Country</label>
                                <div class='col-sm-10 col-md-9'>
                                    <input type='text' name='country' class='form-control' required='required' placeholder= "Country Of Made" />
                                </div>
                            </div>
                            <!--end Country field-->
                            <!--start Status field-->
                            <div class='form-group form-group-lg'>
                                <label class='col-sm-3 control-label text-center'>Status</label>
                                <div class='col-sm-10 col-md-9'>
                                    <select name="status" required>
                                        <option value="">...</option>
                                        <option value="1">New</option>
                                        <option value="2">Like New</option>
                                        <option value="3">Used</option>
                                        <option value="4">Very Old</option>
                                    </select> 
                                </div>
                            </div>
                            <!--end Status field-->
                            <!--start Categories field-->
                            <div class='form-group form-group-lg'>
                                <label class='col-sm-3 control-label text-center'>Category</label>
                                <div class='col-sm-10 col-md-9'>
                                    <select name="category" required>
                                        <option value="">...</option>
                                        <?php
                                            $cats = getAllFrom("*", "categories", "WHERE parent = 0", "","ID");
                                            foreach($cats as $cat){
                                                echo "<option value='" . $cat["ID"] . "'>" . $cat["Name"] . "</option>";
                                            }
                                        ?>
                                    </select> 
                                </div>
                            </div>
                            <!--end Categories field-->
                            <!--start tags field-->
                            <div class='form-group form-group-lg'>
                                <label class='col-sm-3 control-label text-center'>Tags</label>
                                <div class='col-sm-10 col-md-9'>
                                    <input type='text' name='tags' class='form-control' placeholder= "Separate Tags With Comma(,)" />
                                </div>
                            </div>
                            <!--end tags field-->
                            <!--start submit field-->
                            <div class='form-group form-group-lg'>
                                <div class='col-sm-offset-3 col-sm-9'>
                                    <input type='submit' value='Add Item' class='btn btn-primary btn-md' />
                                </div>
                            </div>
                            <!--end submit field-->
                        </form>
                    </div>
                    <div class="col-md-4">
                        <div class='thumbnail item-box live-preview'>
                            <span class='price-tag'>$<span class="live-price">0</span></span>
                            <img class='img-responsive' src='download.jpg' alt='' />
                            <div class='caption'>
                                <h3 class="live-title">Title</h3>
                                <p class="live-desc">Description</p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- start looping through errors-->
                <?php
                if(! empty($formErrors)){
                    foreach($errors as $error){
                        echo "<div class='alert alert-danger'>" . $error . "</div>";
                    }
                }
                if(isset($successMsg)){
                    echo "<div class='alert alert-success'>" . $successMsg . "</div>";
                }
                ?>
                <!-- end looping through errors-->
            </div>
        </div>
    </div>
</div>

<?php
}else{
    header("location: login.php");
    exit();
}
include $tmp . 'footer.php';
?>

