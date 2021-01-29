<?php
if (isset($_POST['signup-submit'])) {
    // Checks if the database connects correctly:
    require 'tdbh.inc.php';
    // Gets the information from the form
    $username = $_POST['user'];
    $email = $_POST['mail'];
    $password = $_POST['pwd'];
    $passwordRepeat = $_POST['pwdrep'];

    // These are all error-handlers that make sure the user does the correct thing.
    // checks if any of the form fields are empty, thats what the "empty()" does, checks if the thing is empty
    if (empty($username) || empty($email) || empty($password) || empty($passwordRepeat)) {
        // These headers send you back to the signup form with an error/success message
        header("Location: ../tPages/signUp.php?error=emptyfields&user=" . $username . "&mail=" . $email);
        exit();
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL) && !preg_match("/^[a-öA-Ö0-9]*$/", $username)) {
        header("Location: ../tPages/signUp.php?error=invalidmailuser");
        exit();
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: ../tPages/signUp.php?error=invalidmail&user =" . $username);
        exit();
    } else if (!preg_match("/^[a-öA-Ö0-9]*$/", $username)) {
        header("Location: ../tPages/signUp.php?error=invaliduser&mail =" . $email);
        exit();
    } else if ($password !== $passwordRepeat) {
        header("Location: ../tPages/signUp.php?error=passcheck&mail=" . $email . "&user=" . $username);
        exit();
    } else {
        // $sql is a vaiable where I store sql-code
        $sql = "SELECT uname FROM login WHERE uname=?";
        // this initialises a statement using $conn
        $stmt = mysqli_stmt_init($conn);
        // checks if the sql was succesfully sent.
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: ../tPages/signUp.php?error=sqlerror");
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
                header("Location: ../tPages/signUp.php?error=usertaken&mail=" . $email);
                exit();
            } else {
                // And finally we put in the values into the database (saftly)
                $sql = "INSERT INTO login (uname, umail, upass) VALUES (?, ?, ?)";
                $stmt = mysqli_stmt_init($conn);
                if (!mysqli_stmt_prepare($stmt, $sql)) {
                    header("Location: ../tPages/signUp.php?error=sqlerror");
                    exit();
                } else {
                    // This hashes the password before sending it into the database so that a hacker cant see all the passwords.
                    $hashedPwd = password_hash($password, PASSWORD_DEFAULT);
                    mysqli_stmt_bind_param($stmt, "sss", $username, $email, $hashedPwd);
                    mysqli_stmt_execute($stmt);
                    header("Location: ../tPages/signUp.php?signup=success");
                    exit();
                }
            }
        }
    }
    // ends the statement and connection, making sure the webbsite uses ass little as possible.
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
} else {
    // If the user tries to get to this php-file without pressing the correct button, the user will be thrown back to signup
    header("Location: ../pages/registrera.php");
    exit();
}
