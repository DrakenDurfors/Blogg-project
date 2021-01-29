<?php
require "../header.php";
?>
<main class="main">
    <div class="margin"></div>
<div class="makeArticle">

<!-- This is the form for creating a new article -->
    <form action="../tincludes/tAddArticle.inc.php" method="post">

        <div class="">
            <h3>Title:</h3>
            <input type="text" class="" name="title" placeholder="" autocomplete="off">
        </div>
        <div class="">
            <h3>Category:</h3>
            <div class="">
                <input type="radio" name="makeCat" id="makeCat1" value="1">
                <label for="makeCat1">School</label>
            </div>
            <div class="">
                <input type="radio" name="makeCat" id="makeCat2" value="2">
                <label for="makeCat2">Worldbuilding</label>
            </div>
            <div class="">
                <input type="radio" name="makeCat" id="makeCat3" value="3">
                <label for="makeCat3">Books</label>
            </div>
            <div class="">
                <input type="radio" name="makeCat" id="makeCat4" value="4">
                <label for="makeCat4">Misc.</label>
            </div>
        </div>
        <div class="">
            <h3>Content:</h3>
            <textarea name="content" class="" id="" cols="60" rows="15"></textarea>
        </div>
        <button type="submit" name="NA-submit" class="create">Create</button>


    </form>



</div>
</main>



<?php
require "../footer.php"
?>