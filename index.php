<?php
ob_start();
session_start();
$pagetitle = 'Homepage';
include 'init.php';
?>
    <div class="container">
        <div class="row">
            <?php
            $allItems = getAllFrom("*", "items", "WHERE approve = 1", "","item_ID");
            foreach($allItems as $item){
                echo "<div class='col-sm-6 col-md-3'>";
                    echo "<div class='thumbnail item-box'>";
                        echo "<span class='price-tag'> $" . $item["Price"] . "</span>";
                        echo "<img class='img-responsive' src='download.jpg' alt='' />";
                        echo "<div class='caption'>";
                            echo "<h3><a href='items.php?itemID=" . $item["item_ID"] . "'>" . $item["Name"] . "</a></h3>";
                            echo "<p>" . $item["Description"] . "</p>";
                            echo "<div class='date'>" . $item["add_date"] . "</div>";
                        echo "</div>";
                    echo "</div>";
                echo "</div>";
            }?>

        </div>

    </div>
<?php

include $tmp . 'footer.php';
ob_end_flush();
?>

