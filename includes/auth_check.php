
<?php

// Start Session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}


// Check User Login
if (!isset($_SESSION['user_id'])) {

    header("Location: ../login.php");
    exit();

}


// Check Admin Role
if ($_SESSION['role_name'] != "Admin") {

    header("Location: ../index.php");
    exit();

}

?>
