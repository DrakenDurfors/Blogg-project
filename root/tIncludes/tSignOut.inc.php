<?php
// This 'destroys' the session we created when logging in, effectivly logging the user out.
session_start();
session_unset();
session_destroy();
header("Location: ../tPages/index.php");
