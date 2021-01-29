<?php
require "../header.php";
?>
<main class="main">
    <div class="margin"></div>

    <div class="deleteContainer">
        <div>
            <form action="../tIncludes/tEditArticle.inc.php" method="post">
                <div>
                    <!-- This form is a check for if the user is sure that it wants the article to get deleted -->
                    <label for="del">Are you sure?</label>
                    <input type="submit" value="&#9760;" id="del" class="articleChangeBtn delete" name="postDelete">
                    <input type="hidden" name="id" value="<?php echo $_POST["id"]; ?>">
                </div>
            </form>
            <br>
            <!-- This sends the user back to the article of whish it originated -->
            <a href="article.php?n=<?php echo $_POST["id"]; ?>" class="articleBtn">&larr; Back </a>
        </div>
    </div>

</main>
<?php
require "../footer.php"
?>