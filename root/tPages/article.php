<?php
require "../header.php";
?>
<main class="main">
    <div class="margin">

    </div>
    <div class="container">

        <?php

        require '../tIncludes/tdbh.inc.php';
        if (isset($_GET['n'])) {
            // This gets the information from the selected page and stores the results in an associative array
            $sql = "SELECT uid, aTitle, aContent, aTime, aeTime, cat FROM articles WHERE aid=$_GET[n]";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($result);
            // This gets the relevant username from connected to the article
            $sql = "SELECT uname FROM login WHERE uid = $row[uid]";
            $result = mysqli_query($conn, $sql);
            $row2 = mysqli_fetch_assoc($result);
            // This checks if the user still has an account
            if (empty($row2['uname'])) {
                $row2['uname'] = "DELETED";
            }
            // This checks if the article has the same author as the current logged in user. If this is so, options will be displayed to edit/delete the article
            if (isset($_SESSION['userID']) && $row['uid'] == $_SESSION['userID']) {
                echo '
                <div class="buttonGroup">
    <form action="editPost.php" method="post">
    <input type="submit" value="&#9998;" name="postEdit" class="articleChangeBtn edit">
    <input type="hidden" name="id" value="' . $_GET["n"] . '">
    </form>
    <form action="delete.php" method="post">
    <input type="hidden" name="id" value="' . $_GET["n"] . '">
    <input type="submit" value="&#9760;" name="postDelete" class="articleChangeBtn delete">
    </form>
    </div>
    ';
            }
            // This echoes out the article, formats the date so as to include only year-month-day and formats the content using nl2br
            echo "<h1>" . $row['aTitle'] . "</h1>";
            echo "<h5> Publisher: " . $row2['uname'] . "</h5>";
            echo "<h5> Published: " . date_format(date_create($row['aTime']), 'Y-m-d') . " <br> Last Edited: " . date_format(date_create($row['aeTime']), 'Y-m-d') . "</h5> <br>";
            echo "<p>" . nl2br($row['aContent']) . "</p> <br>";
        } else {
            header('Location: index.php');
            exit();
        }
        ?>


    </div>
</main>


<?php
require "../footer.php"
?>