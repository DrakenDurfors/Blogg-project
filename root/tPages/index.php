<?php
require "../header.php";
?>


<main class="main">


    <div class="margin">

    </div>
    <div class="container">
        <!-- This is the category selector and searchbar form -->
        <div class="categories">
            <form action="index.php" method="get">
                <div class="searchGroup">
                    <input type="text" class="searchbar" name="search" placeholder="Search..." autocomplete="off">
                    <button class="" type="submit" id="button-addon2">&#128269;</button>
                </div> <br>
                <input class="" type="radio" name="category" id="categoryAll" value="0" onclick="this.form.submit();" <?php if (!isset($_GET['category']) || $_GET['category'] == '0') {
                                                                                                                                            echo 'checked';
                                                                                                                                        } ?>>
                <label class="" for="categoryAll">All</label>
                <input class="" type="radio" name="category" id="category1" value="1" onclick="this.form.submit();" <?php if (isset($_GET['category']) && $_GET['category'] == '1') {
                                                                                                                                        echo 'checked';
                                                                                                                                    } ?>>
                <label class="" for="category1">School</label>
                <input class="" type="radio" name="category" id="category2" value="2" onclick="this.form.submit();" <?php if (isset($_GET['category']) && $_GET['category'] == '2') {
                                                                                                                                        echo 'checked';
                                                                                                                                    } ?>>
                <label class="" for="category2">Worldbuilding</label>
                <input class="" type="radio" name="category" id="category3" value="3" onclick="this.form.submit();" <?php if (isset($_GET['category']) && $_GET['category'] == '3') {
                                                                                                                                        echo 'checked';
                                                                                                                                    } ?>>
                <label class="" for="category3">Books</label>
                <input class="" type="radio" name="category" id="category4" value="4" onclick="this.form.submit();" <?php if (isset($_GET['category']) && $_GET['category'] == '4') {
                                                                                                                                        echo 'checked';
                                                                                                                                    } ?>>
                <label class="" for="category4">Misc</label>

            </form>
        </div>
        <hr>

        <!-- This div contains all the articles for the page -->
        <div class="articleDisplayDiv">
            <?php
            require '../tIncludes/tdbh.inc.php';
            // If the user searches for something this will recieve it
            if (isset($_GET['search'])) {
                $search = mysqli_escape_string($conn, $_GET['search']);
            } else {
                $search = "";
            }
            // This will alter the sql query depending on if a chategory was selected or not and then get the wanted articles
            if (!isset($_GET['category']) || $_GET['category'] == '0') {
                $sql = 'SELECT SUBSTRING(aContent,1,100) as short, aid, uid, aTitle, aeTime, cat FROM articles WHERE aTitle LIKE "%' . $search . '%" ORDER BY aeTime DESC';
            } else {
                $sql = 'SELECT SUBSTRING(aContent,1,100) as short, aid, uid, aTitle, aeTime, cat FROM articles WHERE cat = ' . $_GET["category"] . ' AND aTitle LIKE "%' . $search . '%" ORDER BY aeTime DESC';
            }
            // This checks the querry with the database
            $result1 = mysqli_query($conn, $sql);
            // This will fetch and display all posts from the query (stored in an associative array)
            while ($row = mysqli_fetch_array($result1, MYSQLI_ASSOC)) {
                // This recieves the username of the posts author (as this is not saved in the same table)
                $sql2 = "SELECT uname FROM login WHERE uid = $row[uid]";
                $result2 = mysqli_query($conn, $sql2);
                $row2 = mysqli_fetch_assoc($result2);
                // If no author was found (the account was deleted) it will display as "deleted"
                if (empty($row2['uname'])) {
                    $row2['uname'] = "DELETED";
                }
                // This will turn the date from the database (as this will be recieved as a string) into a date format
                $date = date_create($row['aeTime']);
                // In the following code nl2br formats our content so that every new line will register on the page
                echo '
        <div class="articleCard">
        <div class="">
            <h2 class=""> ' . $row['aTitle'] . '</h2>
            <p class="">' . nl2br($row['short']) . '...</p>
            <p> Author: ' . $row2['uname'] . '</p>
            <p> Last Edited: ' . date_format($date, 'Y-m-d') . '</p>
            <a href="article.php?n=' . $row["aid"] . '" class="articleBtn">Go To Article</a>
        </div>
    </div>

        ';
            }

            ?>
        </div>

    </div>
    </div>
    <div class="margin">

    </div>
</main>

<?php
require "../footer.php"
?>