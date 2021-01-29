<?php
session_start();

if (isset($_POST['CUSub'])) { //Här kommer användarnamnet ändras:
    // Checks if the database connects correctly:
    require 'tdbh.inc.php';
    // Gets the information from the form
    $username = $_POST['username'];
    $password = $_POST['passconf'];

    // These are all error-handlers that make sure the user does the correct thing.
    // checks if any of the form fields are empty, thats what the "empty()" does, checks if the thing is empty
    if (empty($username) || empty($password)) {
        // These headers send you back to the signup form with an error/success message
        header("Location: ../tPages/settings.php?error=emptyfields");
        exit();
    } else if (!preg_match("/^[a-öA-Ö0-9]*$/", $username)) {
        header("Location: ../tPages/settings.php?error=invaliduser");
        exit();
    } else {
        // $sql is a vaiable where I store sql-code
        $sql = "SELECT uname FROM login WHERE uname=?";
        // this initialises a statement using $conn
        $stmt = mysqli_stmt_init($conn);
        // checks if the sql was succesfully sent.
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: ../tPages/settings.php?error=sqlerror");
            exit();
        } else {
            // As you can see on line 37 the username isnt added immedietly due to safty concerns. the code below sends the $username into the code.
            mysqli_stmt_bind_param($stmt, "s", $username);
            // This line executes the statement and stores the values (username) from the database. This is for checking that 2 accounts dont have the same username
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);
            $resultCheck = mysqli_stmt_num_rows($stmt);
            // If the code above finds a row in the database that has the username the user inputed, you will be sent back with an error message
            if ($resultCheck > 0) {
                header("Location: ../tPages/settings.php?error=usertaken");
                exit();
            } else {
                // Gets the password from the database to campare against the password the user provided
                $sql = "SELECT upass FROM login WHERE uid=$_SESSION[userID]";
                $result = mysqli_query($conn, $sql);
                $passC = mysqli_fetch_assoc($result);

                if (password_verify($password, $passC['upass'])) {

                    // And finally we put in the values into the database (saftly)
                    $sql = "UPDATE login SET uname=? WHERE uid=$_SESSION[userID]";
                    $stmt = mysqli_stmt_init($conn);
                    if (!mysqli_stmt_prepare($stmt, $sql)) {
                        header("Location: ../tPages/settings.php?error=sqlerror");
                        exit();
                    } else {
                        mysqli_stmt_bind_param($stmt, "s", $username);
                        mysqli_stmt_execute($stmt);
                        header("Location: ../tPages/settings.php?change=success");
                        exit();
                    }
                }
            }
        }
    }
    // ends the statement and connection, making sure the webbsite uses ass little as possible.
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
} else if (isset($_POST['CMSub'])) { // This will change the e-mail of an account
    // Checks if the database connects correctly:
    require 'tdbh.inc.php';
    // Gets the information from the form
    $mail = $_POST['mail'];
    $password = $_POST['passconf'];

    // These are all error-handlers that make sure the user does the correct thing.
    // checks if any of the form fields are empty, thats what the "empty()" does, checks if the thing is empty
    if (empty($mail) || empty($password)) {
        // These headers send you back to the signup form with an error/success message
        header("Location: ../tPages/settings.php?error=emptyfields");
        exit();
    } else if (!filter_var($mail, FILTER_VALIDATE_EMAIL)) { // Checks that it is a valid email
        header("Location: ../tPages/settings.php?error=invalidmail");
        exit();
    } else {
        // $sql is a vaiable where I store sql-code
        $sql = "SELECT umail FROM login WHERE umail=?";
        // this initialises a statement using $conn
        $stmt = mysqli_stmt_init($conn);
        // checks if the sql was succesfully sent.
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: ../tPages/settings.php?error=sqlerror");
            exit();
        } else {
            // As you can see on line 37 the username isnt added immedietly due to safty concerns. the code below sends the $username into the code.
            mysqli_stmt_bind_param($stmt, "s", $mail);
            // This line executes the statement and stores the values (username) from the database. This is for checking that 2 accounts dont have the same username
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);
            $resultCheck = mysqli_stmt_num_rows($stmt);
            // If the code above finds a row in the database that has the username the user inputed, you will be sent back with an error message
            if ($resultCheck > 0) {
                header("Location: ../tPages/settings.php?error=mailtaken");
                exit();
            } else {
                // Gets the password from the database to campare against the password the user provided
                $sql = "SELECT upass FROM login WHERE uid=$_SESSION[userID]";
                $result = mysqli_query($conn, $sql);
                $passC = mysqli_fetch_assoc($result);

                if (password_verify($password, $passC['upass'])) {

                    // And finally we put in the values into the database (saftly)
                    $sql = "UPDATE login SET umail=? WHERE uid=$_SESSION[userID]";
                    $stmt = mysqli_stmt_init($conn);
                    if (!mysqli_stmt_prepare($stmt, $sql)) {
                        header("Location: ../tPages/settings.php?error=sqlerror");
                        exit();
                    } else {
                        mysqli_stmt_bind_param($stmt, "s", $mail);
                        mysqli_stmt_execute($stmt);
                        header("Location: ../tPages/settings.php?change=success");
                        exit();
                    }
                }
            }
        }
    }
    // ends the statement and connection, making sure the webbsite uses ass little as possible.
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
} else if (isset($_POST['CPSub'])) { // This will change the password of the user
    // Checks if the database connects correctly:
    require 'tdbh.inc.php';
    // Gets the information from the form
    $newPassword = $_POST['pass1'];
    $passwordVerify = $_POST['pass2'];
    $password = $_POST['passconf'];

    // These are all error-handlers that make sure the user does the correct thing.
    // checks if any of the form fields are empty, thats what the "empty()" does, checks if the thing is empty
    if (empty($newPassword) || empty($password) || empty($passwordVerify)) {
        // These headers send you back to the signup form with an error/success message
        header("Location: ../tPages/settings.php?error=emptyfields");
        exit();
    } else if ($newPassword !== $passwordVerify) {
        header("Location: ../tPages/settings.php?error=passcheck");
        exit();
    } else {
        // Gets the password from the database to campare against the password the user provided
        $sql = "SELECT upass FROM login WHERE uid=$_SESSION[userID]";
        $result = mysqli_query($conn, $sql);
        $passC = mysqli_fetch_assoc($result);

        if (password_verify($password, $passC['upass'])) {

            // And finally we put in the values into the database (saftly)
            $sql = "UPDATE login SET upass=? WHERE uid=$_SESSION[userID]";
            $stmt = mysqli_stmt_init($conn);
            if (!mysqli_stmt_prepare($stmt, $sql)) {
                header("Location: ../tPages/settings.php?error=sqlerror");
                exit();
            } else {
                // Hashes the new password and sends it in
                $newHashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
                mysqli_stmt_bind_param($stmt, "s", $newHashedPassword);
                mysqli_stmt_execute($stmt);
                header("Location: ../tPages/settings.php?change=success");
                exit();
            }
        } else {
            header("Location: ../tPages/settings.php?error=wrongpwd");
            exit();
        }
    }
} else if (isset($_POST['CDSub'])) { // This will delete the account
    // Checks if the database connects correctly:
    require 'tdbh.inc.php';
    // Gets the information from the form
    $Verify = $_POST['check'];
    $password = $_POST['passconf'];

    // These are all error-handlers that make sure the user does the correct thing.
    // checks if any of the form fields are empty, thats what the "empty()" does, checks if the thing is empty
    if (empty($Verify) || empty($password)) {
        // These headers send you back to the signup form with an error/success message
        header("Location: ../tPages/settings.php?error=emptyfields");
        exit();
    } else {
        // Gets the password from the database to campare against the password the user provided
        $sql = "SELECT upass FROM login WHERE uid=$_SESSION[userID]";
        $result = mysqli_query($conn, $sql);
        $passC = mysqli_fetch_assoc($result);

        if (password_verify($password, $passC['upass'])) {

            // And finally we put in the values into the database (saftly)
            $sql = "DELETE FROM login WHERE uid=?";
            $stmt = mysqli_stmt_init($conn);
            if (!mysqli_stmt_prepare($stmt, $sql)) {
                header("Location: ../tPages/settings.php?error=sqlerror");
                exit();
            } else {
                mysqli_stmt_bind_param($stmt, "s", $_SESSION['userID']);
                mysqli_stmt_execute($stmt);
                session_unset();
                session_destroy();
                header("Location: ../tPages/index.php");
                exit();
            }
        } else {
            header("Location: ../tPages/settings.php?error=wrongpwd");
            exit();
        }
    }
} else {
    header("Location: ../tPages/index.php");
}
