<?php
ob_start(); //output buffering start
session_start();
if(isset($_SESSION['username'])){
    $pagetitle = 'dashboard';
    include 'init.php';
    // start dashboard page //
    $numUsers = 5; // number of latest user
    $latestUsers = getLatest("*", "users", "userID", $numUsers); // latest user array
    $numItems = 5; // number of latest items
    $latestItems = getLatest("*", "items", "item_ID", $numItems); // latest items array
    $numComments = 4; //number of comments

    ?>
    <div class="container home-stats text-center">
        <h1>Dashboard</h1>
        <div class="row">
            <div class="col-md-3">
                <div class="stat st-members"><a href="members.php">Total Members <span><?php echo countItems('userID', 'users') ?></a></span></div>
            </div>
            <div class="col-md-3">
                <div class="stat st-pending">Pending Members <span><a href="members.php?do=manage&page=pending"><?php echo checkItems("RegStatus", "users", 0); ?></a></span></div>
            </div>
            <div class="col-md-3">
            <div class="stat st-members"><a href="items.php">Total Items <span><?php echo countItems('item_ID', 'items') ?></a></span></div>
            </div>
            <div class="col-md-3">
                <div class="stat st-comments"><a href="comments.php">Total Comments<span><?php echo countItems('c_ID', 'comments') ?></a></span></div>
            </div>
        </div>
    </div>
    <div class="container latest">
    <div class="row">
            <div class="col-sm-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="fa fa-users"></i>Latest <?php echo $numUsers ?> Registerd Users
                        <span class="toggle-info">+</span>
                    </div>
                    <div class="panel-body">
                    <ul class= "list-unstyled latest-users">
                        <?php
                            if(! empty($latestUsers)){
                                foreach ($latestUsers as $user){
                                    echo "<li>" . $user["username"] . "<a href = 'members.php?do=edit&userID=". $user["userID"] . "' ><span class='btn btn-success'><i class = 'fa fa-edit'></i>Edit";
                                    if($user['RegStatus'] == 0){
                                        echo '<a href="members.php?do=activate&userID=' . $user['userID'] . '" class="btn btn-info activate"><i class="fa fa-check"></i>Activate</a>';
                                    }
                                    echo "</span></a></li>";
                                }
                            }else{
                                echo "There is no Members to show";
                            }


                        ?>
                    </ul>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="fa fa-tag"></i>Latest <?php echo $numItems?> Items
                        <span class="toggle-info">+</span>
                    </div>
                    <div class="panel-body">
                    <ul class= "list-unstyled latest-users">
                        <?php
                            if(! empty($latestItems)){
                                foreach ($latestItems as $item){
                                    echo "<li>" . $item["Name"] . "<a href = 'items.php?do=edit&itemID=". $item["item_ID"] . "' ><span class='btn btn-success'><i class = 'fa fa-edit'></i>Edit";
                                    if($item['approve'] == 0){
                                        echo '<a href="items.php?do=approve&itemID=' . $item['item_ID'] . '" class="btn btn-info activate"><i class="fa fa-check"></i>Approve</a>';
                                    }
                                    echo "</span></a></li>";
                                }
                            }else{
                                echo "There is no Items to show";
                            }
                        ?>
                    </ul>
                    </div>
                </div>
            </div>

        </div>
        <!-- start latest comments-->
        <div class="row">
            <div class="col-sm-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="fa fa-comments-o"></i>Latest <?php echo $numComments?> Comments
                        <span class="toggle-info">+</span>
                    </div>
                    <div class="panel-body">
                        <?php
                            $stmt = $con->prepare("SELECT comments.*, users.username AS User FROM comments INNER JOIN users ON users.userID = comments.user_ID ORDER BY c_ID DESC LIMIT $numComments");
                            $stmt->execute();
                            $comments = $stmt->fetchAll();
                            if(! empty($comments)){
                                foreach($comments as $comment){
                                    echo "<div class='comment-box'>";
                                        echo "<span class='member-n'>" . $comment["User"] . "</span>";
                                        echo "<p class='member-c'>" . $comment["comment"] . "</p>";
                                    echo "</div>";
                                }
                            }else{
                                echo "There is no Comments to show";
                            }
                        ?>
                    </div>
                </div>
            </div>

        </div>
        <!-- End latest comments-->
    </div>

    <?php
    // end dashboard page //
    include $tmp . 'footer.php';

} else{
    header('location: index.php');
    exit();
}

ob_end_flush();
?>