<?php
include 'init.php';
?>
    <div class="container">
        <h1 class="text-center">Show Category Items</h1>
        <div class="row">
            <?php
                if(isset($_GET['pageid']) && is_numeric($_GET['pageid'])){
                    $category = intval($_GET['pageid']);
                    $allItems = getAllFrom("*", "items", "WHERE cat_ID = {$category}", "AND approve = 1", "item_ID");
                    foreach($allItems as $item){
                        echo "<div class='col-sm-6 col-md-3'>";
                            echo "<div class='thumbnail item-box'>";
                                echo "<span class='price-tag'>" . $item["Price"] . "</span>";
                                echo "<img class='img-responsive' src='download.jpg' alt='' />";
                                echo "<div class='caption'>";
                                    echo "<h3><a href='items.php?itemID=" . $item["item_ID"] . "'>" . $item["Name"] . "</a></h3>";
                                    echo "<p>" . $item["Description"] . "</p>";
                                    echo "<div class='date'>" . $item["add_date"] . "</div>";
                                echo "</div>";
                            echo "</div>";
                        echo "</div>";
                    }
                }else{
                    echo "you must add pageid";
                }?>

        </div>

    </div>

<?php
include $tmp . 'footer.php';
?>

