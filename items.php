<?php
session_start();
$pagetitle = 'Show Items';
include 'init.php';
    $itemID = isset($_GET['itemID']) && is_numeric($_GET['itemID']) ? intval($_GET['itemID']) : 0;
    $stmt = $con->prepare("SELECT items.* ,categories.name AS categoryName, users.username FROM items INNER JOIN categories ON categories.ID = items.cat_ID INNER JOIN users ON users.userID = items.member_ID WHERE item_ID= ? AND approve = 1");
    $stmt->execute(array($itemID));
    $count = $stmt->rowCount();
    if ($count > 0){
        $item = $stmt->fetch();
        ?>
        <h1 class="text-center"><?php echo $item["Name"] ?></h1>
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <img class='img-responsive img-thumbnail center-block' src='download.jpg' alt='' />
                </div>
                <div class="col-md-9 item-info">
                    <h2><?php echo $item["Name"]; ?></h2>
                    <p><?php echo $item["Description"]; ?></p>
                    <ul class="list-unstyled">
                        <li><span>Added Date : </span><?php echo $item["add_date"]; ?></li>
                        <li><span>Price : </span><?php echo  $item["Price"]; ?></li>
                        <li><span>Made In : </span><?php echo $item["country_made"]; ?></li>
                        <li><span>Category : </span><a href="categories.php?pageid=<?php echo $item["cat_ID"]?>"><?php echo $item["categoryName"]; ?></a></li>
                        <li><span>Added By : </span><a href="#"><?php echo $item["username"]; ?></a></li>
                        <li class="tags-items"><span>Tags : </span>
                            <?php $allTags = explode(",", $item["tags"]);
                                foreach($allTags as $tag){
                                    $tag = str_replace(" ", "", $tag);
                                    $lowertag = strtolower($tag);
                                    if(! empty($tag)){
                                        echo "<a href='tags.php?name={$lowertag}'>" . $tag . "</a>";
                                    }
                                }
                            ?>
                        </li>
                    </ul>
                </div>
            </div>
            <hr class="custom-hr">
            <!-- start add comment-->
            <?php if(isset($_SESSION["user"])){ ?>

            <div class="row">
                <div class="col-md-offset-3">
                    <div class="add-comment">
                        <h3 class="text-center">Add Your Comment</h3>
                        <form action="<?php echo $_SERVER["PHP_SELF"] . '?itemID=' . $item['item_ID'] ?>" method="POST">
                            <textarea name="comment" required></textarea>
                            <input class="btn btn-primary" type="submit" value="Add Comment" />
                        </form>
                        <?php
                            if($_SERVER["REQUEST_METHOD"] == "POST"){
                                $comment = filter_var($_POST["comment"], FILTER_SANITIZE_STRING);
                                $itemID = $item["item_ID"];
                                $userID = $_SESSION["uid"];
                            }
                            if(! empty($comment)){
                                $stmt= $con->prepare("INSERT INTO comments(comment, status, comment_date, item_ID, user_ID) VALUES(:zcomment, 0, now(), :zitemid, :zuserid)");
                                $stmt->execute(array(
                                    "zcomment" => $comment,
                                    "zitemid" => $itemID,
                                    "zuserid" => $userID
                                ));
                                if($stmt){
                                    echo "<div class='alert alert-success'>Comment Added</div>";
                                }
                            }

                        ?>
                    </div>
                </div>
            </div>
            <?php }else{
                echo "<a href='login.php'>Login</a> Or <a href='login.php'>Register</a> To Add Comment";
            } ?>
            <!-- end add comment-->
            <hr class="custom-hr">
            <?php
                $stmt = $con->prepare("SELECT comments.*, users.username AS Member FROM comments INNER JOIN users ON users.userID = comments.user_ID WHERE item_ID=? AND status=1 ORDER BY c_ID DESC");
                $stmt->execute(array($item["item_ID"]));
                $comments = $stmt->fetchAll();
            foreach($comments as $comment){
                echo "<div class='comment-box'>";
                    echo "<div class='row'>";
                        echo "<div class='col-sm-2'><img class='img-responsive img-thumbnail img-circle center-block' style='border-radius=50%' src='download.jpg' alt='' />" . $comment["Member"] . "</div>";
                        echo "<div class='col-sm-10'><p class='lead'>" . $comment["comment"] . "</p></div>";

                    echo "</div>";
                echo "</div>";
                echo "<hr class='custom-hr'>";
            }
            ?>
        </div>
        
        <?php
    }else{
        echo "<div class='container'>";
            echo "<div class='alert alert-danger'>There Is No Such ID Or This Item Is Waiting Approval</div>";
        echo "</div/>";

    }

?>

<?php
include $tmp . 'footer.php';
?>

