<?php
session_start();

if (isset($_POST['NA-submit'])) {
    // Checks if the database connects correctly:
    require 'tdbh.inc.php';
    // Gets the information from the form
    $aTitle = $_POST['title'];
    $aContent = $_POST['content'];
    $cat = $_POST['makeCat'];
    // Checks that no fields are empty
    if (empty($aTitle) || empty($aContent) || empty($cat)) {
        // Sends you back without the database uppdating
        header("Location: ../tPages/makePost.php?error=emptyfields");
        exit();
    } else{
        // The sql-code used to update the row in tha database:
        $sql = "UPDATE articles SET aTitle=?, aContent=?, aeTime=?, cat=? WHERE aid=$_POST[n]";
        $stmt = mysqli_stmt_init($conn);
        // If the sql fails the user gets sent back without the database uppdating
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: ../tPages/index.php?error=sqlerror");
            exit();
        } else {
            // Gets the date of the current edit:
                $aTime = date('Y-m-d H:i:s');
                // Binds the parameters and sends the information into the database
                mysqli_stmt_bind_param($stmt, "ssss", $aTitle, $aContent, $aTime, $cat);
                mysqli_stmt_execute($stmt);

            header("Location: ../tPages/index.php");
            exit();
        }
    }
    // If the user wants to delete the post, a specific button has to be pressed else they will be sent back without anything happening
}  else if(isset($_POST['postDelete'])){
    // Finds the connection
    require 'tdbh.inc.php';
    // The sql code used to delete the post:
    $sql = "DELETE FROM articles WHERE aid=?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: ../tPages/settings.php?error=sqlerror");
        exit();
    } else {
        // Finally deleting the article from the database
        mysqli_stmt_bind_param($stmt, "s", $_GET['id']);
        mysqli_stmt_execute($stmt);
        header("Location: ../tPages/index.php");
        exit();
    }

}




else {
    header("Location: ../tPages/index.php");
    exit();
}
