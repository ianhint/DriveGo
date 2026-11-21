
<?php

// Start Session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}


// Redirect Function
function redirect($page)
{
    header("Location: " . $page);
    exit();
}


// Check Login
function checkLogin()
{
    if (isset($_SESSION['user_id'])) {
        return true;
    } else {
        return false;
    }
}


// Check Admin
function checkAdmin()
{
    if (isset($_SESSION['role_name']) && $_SESSION['role_name'] == "Admin") {
        return true;
    } else {
        return false;
    }
}


// Check Staff
function checkStaff()
{
    if (isset($_SESSION['role_name']) && $_SESSION['role_name'] == "Staff") {
        return true;
    } else {
        return false;
    }
}


// Check Customer
function checkCustomer()
{
    if (isset($_SESSION['role_name']) && $_SESSION['role_name'] == "Customer") {
        return true;
    } else {
        return false;
    }
}

?>
