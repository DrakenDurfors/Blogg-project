<?php
session_start();
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Family Life</title>

    <link rel="stylesheet" href="../css/styles.css">
</head>

<body>


    <div class="Bnavbar">
        <ul class="Bnavlist">
            <li class="BnavListItem"><a href="index.php">Home</a></li>
            <?php
            // If the user is logged in then the calendar item will be displayed
            if (isset($_SESSION['userID'])) {
                echo '<li class="BnavListItem"><a href="makePost.php">Create post</a></li>';
                echo '<li class="BnavListItem"><a href="settings.php">Settings</a></li>';
            }
            ?>
        </ul>
        <h1>Blogg</h1>


        <div class="loginReg">
            <?php
            // This is where you log in/out or sign up. 
            if (isset($_SESSION['userID'])) {
                echo  '<form action="../tIncludes/tSignOut.inc.php" class="BloginForm" method="POST">
        <input type="submit" value="Logout" class="BloginBtn" name="logout-submit">
        </form>';
            } else {
                echo '<form action="../tincludes/tSignIn.inc.php" class="BloginForm" method="POST">
        <input type="text" name="mailuser" class="BloginInputField" placeholder="Username/E-mail..." autocomplete="off">
        <input type="password" name="pwd" class="BloginInputField" placeholder="Password..." autocomplete="off">
        <input type="submit" value="Login" class="BloginBtn" name="login-submit">
        <button><a href="signUp.php" class="regButt BloginBtn">Sign Up</a></button>
        </form>';
            }
            ?>


        </div>
    </div>
    <br>
<hr>