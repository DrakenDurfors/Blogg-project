<?php
require "../header.php";
// This makes sure that the user arrived from the page and not came here by any other means
if (isset($_POST['postEdit'])) {
    require "../tIncludes/tdbh.inc.php";
    // Gets the relevant information from the database about the page the user edits
    $sql = "SELECT uid, aTitle, aContent, aTime, aeTime, cat FROM articles WHERE aid=$_POST[id]";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
?>
    <main class="main">
        <div class="margin"></div>
        <div class="makeArticle">
            <!-- Fills in the information from the article into the editable fields -->
            <form action="../tincludes/tEditArticle.inc.php" method="post">
                <input type="hidden" name="n" value="<?php echo $_POST['id'] ?>">
                <div class="">
                    <h3>Title:</h3>
                    <input type="text" class="" name="title" value="<?php echo $row['aTitle']; ?>" autocomplete="off">
                </div>
                <div class="">
                    <h3>Category:</h3>
                    <div class="">
                        <input type="radio" name="makeCat" id="makeCat1" value="1" <?php if ($row['cat'] == '1') {
                                                                                        echo 'checked';
                                                                                    } ?>>
                        <label for="makeCat1">School</label>
                    </div>
                    <div class="">
                        <input type="radio" name="makeCat" id="makeCat2" value="2" <?php if ($row['cat'] == '2') {
                                                                                        echo 'checked';
                                                                                    } ?>>
                        <label for="makeCat2">Worldbuilding</label>
                    </div>
                    <div class="">
                        <input type="radio" name="makeCat" id="makeCat3" value="3" <?php if ($row['cat'] == '3') {
                                                                                        echo 'checked';
                                                                                    } ?>>
                        <label for="makeCat3">Books</label>
                    </div>
                    <div class="">
                        <input type="radio" name="makeCat" id="makeCat4" value="4" <?php if ($row['cat'] == '4') {
                                                                                        echo 'checked';
                                                                                    } ?>>
                        <label for="makeCat4">Misc.</label>
                    </div>
                </div>
                <div class="">
                    <h3>Content:</h3>
                    <textarea name="content" class="" cols="60" rows="15"><?php echo $row['aContent']; ?></textarea>
                </div>
                <button type="submit" name="NA-submit" class="create">Edit</button>


            </form>



        </div>

    </main>

    <?php
} else {
    header("Location: ../tPages/index.php");
    exit();
}
require "../footer.php"
    ?>