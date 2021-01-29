<?php
require "../header.php";
?>
<main class="main">
    <div class="margin"></div>
    <section class="signupContainer">
        <div>
        <h1 class="text-center">Signup</h1>
        <p>
            <?php
            // This code checks if there have been an error (errors would have been given from the signup.po.php) and then displays an error-text.
            if (isset($_GET['error'])) {
                if ($_GET['error'] == "emptyfields") {
                    echo '<p class="alert" role="alert">Make sure to fill in all fields!</p>';
                } else if ($_GET['error'] == "invalidmailuser") {
                    echo '<p class="alert" role="alert">Invalid username and e-mail!</p>';
                } else if ($_GET['error'] == "invaliduser") {
                    echo '<p class="alert" role="alert">Invalid username!</p>';
                } else if ($_GET['error'] == "invalidmail") {
                    echo '<p class="alert" role="alert">Invalid e-mail!</p>';
                } else if ($_GET['error'] == "passcheck") {
                    echo '<p class="alert" role="alert">Your passwords do not mach!</p>';
                } else if ($_GET['error'] == "usertaken") {
                    echo '<p class="alert" role="alert">An account with this username already exists!</p>';
                }
            }
            // If the signup was successful then that will be shown with the code below:
            else if (isset($_GET['signup'])) {

                if ($_GET['signup'] == "success") {
                    echo '<p class="alert alert-success" role="alert"> Signup succesfull!';
                }
            }
            ?>
        </p>
        <!-- This is the basic html form for signup: -->
        <form action="../tincludes/tSignUp.inc.php" method="post">
            <div class="form-group justify-content-center d-flex">
                <input type="text" name="user" placeholder="Username..." autocomplete="off">
            </div>
            <div class="form-group justify-content-center d-flex">
                <input type="text" name="mail" placeholder="E-mail..." autocomplete="off">
            </div>
            <div class="form-group justify-content-center d-flex">
                <input type="password" name="pwd" placeholder="Password..." autocomplete="off">
            </div>
            <div class="form-group justify-content-center d-flex">
                <input type="password" name="pwdrep" placeholder="Repeat password..." autocomplete="off">
            </div>
            <div class="form-group justify-content-center d-flex">
                <button type="submit" name="signup-submit" class="signupBtn">Signup</button>
            </div>

        </form>
        </div>
    </section>

</main>
<?php
require "../footer.php"
?>