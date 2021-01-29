<?php
require "../header.php";
require "../tIncludes/tdbh.inc.php";
?>
<main class="main settingsMain">
    <div class="margin"></div>
    <div class="accountContainer">

        <section class="accountSettings">
            <?php
            // This will get the user name and email and then display them
            $sql = "SELECT umail, uname FROM login WHERE uid = $_SESSION[userID] LIMIT 1";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($result);
            echo "<h2>Username:<br> " . $row['uname'] . "</h2>";
            echo "<h2>E-mail:<br> " . $row['umail'] . "</h2>";
            echo '<hr> <br>';
            // This part shows what the user wants to change based on the input given. 
            if (!isset($_GET['s'])) {
                // This is the selection menu of the things the user can change
                echo '
        <a href="settings.php?s=u">Change Username</a> <br>
        <a href="settings.php?s=m">Change E-mail</a> <br>
        <a href="settings.php?s=p">Change Password</a> <br>
        <a href="settings.php?s=d" class="text-white bg-danger">Delete Account</a>
        ';
            } else if ($_GET['s'] == 'u') {
                // This is the form for changeing the username
                echo '<form action="../tIncludes/tAccountChange.inc.php" method="POST">
            <div class="form-group">
                <label for="username">Change Username:</label> 
                <input type="text" class="form-control" name="username" id="username" value="' . $row["uname"] . '" required autocomplete="off">
            </div> <br>
            <div class="form-group">
                <label for="username">Confirm With Password:</label> 
                <input type="password" class="form-control" name="passconf" id="passconf" required>
            </div> <br>
            <input type="submit" value="Confirm Change" name="CUSub" class="articleChangeBtn edit ">
        </form> <br>
            <a href="settings.php">Back</a>
            ';
            } else if ($_GET['s'] == 'm') {
                // This is the code for changeing the email of the user
                echo '<form action="../tIncludes/tAccountChange.inc.php" method="POST">
            <div class="form-group">
                <label for="mail">Change E-mail:</label> 
                <input type="text" class="form-control" name="mail" id="mail" value="' . $row["umail"] . '" required autocomplete="off">
            </div> <br>
            <div class="form-group">
                <label for="username">Confirm With Password:</label> 
                <input type="password" class="form-control" name="passconf" id="passconf" required>
            </div> <br>
            <input type="submit" value="Confirm Change" name="CMSub" class="articleChangeBtn edit ">
            </form> <br>
            <a href="settings.php">Back</a>
            ';
            } else if ($_GET['s'] == 'p') {
                // This is the form for changeing the password
                echo '<form action="../tIncludes/tAccountChange.inc.php" method="POST">
            <div class="form-group">
                <label for="passconf">Old Password:</label> 
                <input type="password" class="form-control" name="passconf" id="passconf" required>
            </div> <br>
            <div class="form-group">
                <label for="pass1">New Password:</label> 
                <input type="password" class="form-control" name="pass1" id="pass1" required autocomplete="off">
            </div> <br>
            <div class="form-group">
                <label for="pass2">Confirm New Password:</label> 
                <input type="password" class="form-control" name="pass2" id="pass2" required autocomplete="off">
            </div> <br>
            <input type="submit" value="Confirm Change" name="CPSub" class="articleChangeBtn edit ">

        </form>
            <a href="settings.php">Back</a>
            ';
            } else if ($_GET['s'] == 'd') {
                // This is the form for deleting the account
                echo '<form action="../tIncludes/tAccountChange.inc.php" method="POST">
            <div class="form-group">
                <label for="passconf">Enter Password:</label> 
                <input type="password" class="form-control" name="passconf" id="passconf" required>
            </div> <br>
            <div class="form-group">
                <input type="radio" name="check" id="check" required>
                <label for="check">Are you sure?</label> 
                </div> <br>
            <input type="submit" value="Confirm Delete" name="CDSub" class="articleChangeBtn delete ">

        </form> <br>
            <a href="settings.php">Back</a>
            ';
            }

            ?>

        </section>
        <section class="accountPosts articleDisplayDiv">
            <?php
            require '../tIncludes/tdbh.inc.php';
            // This will get all the posts made by this specific user in order of when it was posted
            $sql = 'SELECT SUBSTRING(aContent,1,100) as short, aid, uid, aTitle, aeTime, cat FROM articles WHERE uid=' . $_SESSION["userID"] . ' ORDER BY aeTime DESC';
            // This checks the querry with the database
            $result1 = mysqli_query($conn, $sql);
            // This will fetch and display all posts from the query (stored in an associative array)
            while ($row = mysqli_fetch_array($result1, MYSQLI_ASSOC)) {
                // This recieves the username of the posts author (as this is not saved in the same table)
                $sql2 = "SELECT uname FROM login WHERE uid = $row[uid]";
                $result2 = mysqli_query($conn, $sql2);
                $row2 = mysqli_fetch_assoc($result2);
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
        </section>

    </div>

</main>

<?php
require "../footer.php"
?>