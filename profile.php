<?php
session_start();
$pagetitle = 'Profile';
include 'init.php';
if(isset($_SESSION["user"])){
    $getUser = $con->prepare("SELECT * FROM users WHERE username=?");
    $getUser->execute(array($sessionUser));
    $info = $getUser->fetch();
    $userid = $info["userID"];
?>
<h1 class="text-center">My Profile</h1>
<div class="information block">
    <div class="container">
        <div class="panel panel-primary" style="border: 1px solid #0b5ed7;">
            <div class="panel-heading" style="color: #fff;background-color: #0b5ed7;padding: 10px;">My Information</div>
            <div class="panel-body" style="padding: 10px;">
                <ul class="list-unstyled">
                    <li><span>Name</span>                : <?php echo $info["username"]; ?> </li>
                    <li><span>Email</span>               : <?php echo $info["email"]; ?>    </li>
                    <li><span>Full Name</span>           : <?php echo $info["fullname"]; ?> </li>
                    <li><span>Register Date</span>       : <?php echo $info["username"]; ?> </li>
                    <li><span>Favourite Category</span>  :                                  </li>
                </ul>
                <a href="#" class="btn btn-default">Edit Information</a>
            </div>
        </div>
    </div>
</div>
<div id="my-ads" class="my-ads block">
    <div class="container">
        <div class="panel panel-primary" style="border: 1px solid #0b5ed7;">
            <div class="panel-heading" style="color: #fff;background-color: #0b5ed7;padding: 10px;">My Items</div>
            <div class="panel-body" style="padding: 10px;">
            <?php
            $myItems = getAllFrom("*", "items", "WHERE member_ID = $userid", "", "item_ID");
            if(! empty($myItems)){
                echo "<div class='row'>";
                foreach($myItems as $item){
                    echo "<div class='col-sm-6 col-md-3'>";
                        echo "<div class='thumbnail item-box'>";
                        if($item["approve"] == 0){
                            echo "<span class='approve-status'>Not Approved</span>";
                        }
                            echo "<span class='price-tag'>$" . $item["Price"] . "</span>";
                            echo "<img class='img-responsive' src='download.jpg' alt='' />";
                            echo "<div class='caption'>";
                                echo "<h3><a href='items.php?itemID=" . $item["item_ID"] . "'>" . $item["Name"] . "</a></h3>";
                                echo "<p>" . $item["Description"] . "</p>";
                                echo "<div class='date'>" . $item["add_date"] . "</div>";
                            echo "</div>";
                        echo "</div>";
                    echo "</div>";
                }
                echo "</div>";
            }else{
                echo "Sorry There Is No Ads To Show , <a href='newad.php'>Create New Ad</a>";
            }
            ?>
            </div>
        </div>
    </div>
</div>
<div class="my-comments block">
    <div class="container">
        <div class="panel panel-primary" style="border: 1px solid #0b5ed7;">
            <div class="panel-heading" style="color: #fff;background-color: #0b5ed7;padding: 10px;">My Latest Comments</div>
            <div class="panel-body" style="padding: 10px;">
            <?php
            $myComments = getAllFrom("comment", "comments", "WHERE user_ID = $userid", "", "c_ID");
            if(! empty($myComments)){
                foreach($myComments as $comment){
                    echo "<p>" . $comment["comment"] . "</p>";
                }
            }else{
                echo "There is Not Comment To Show";
            }
            ?>
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

