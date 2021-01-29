<?php
session_start();

if (isset($_POST['NA-submit'])) {
    // Checks if the database connects correctly:
    require 'tdbh.inc.php';
    // Gets the information from the form
    $aTitle = $_POST['title'];
    $aContent = $_POST['content'];
    $uId = $_SESSION['userID'];
    $cat = $_POST['makeCat'];
    // Checkar att input-fälten inte är tomma
    if (empty($aTitle) || empty($aContent) || empty($cat)) {
        header("Location: ../tPages/makePost.php?error=emptyfields");
        exit();
    } else if(true){
        // Skickar in den nya informationen in i databasen
        $sql = "INSERT INTO articles (uid, aTitle, aContent, aTime, aeTime, cat) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: ../tPages/makePost.php?error=sqlerror");
            exit();
        } else {
            // Hämtar dagens datum:
                $aTime = date('Y-m-d H:i:s');
                // Skickar in sql-koden in i databasen:
                mysqli_stmt_bind_param($stmt, "ssssss", $uId, $aTitle, $aContent, $aTime, $aTime, $cat);
                mysqli_stmt_execute($stmt);

            header("Location: ../tPages/makePost.php?create=success");
            exit();
        }
    }
} else {
    header("Location: ../tPages/makePost.php");
    exit();
}
