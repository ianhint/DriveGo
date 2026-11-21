
<?php

// Database Configuration

$host = "localhost";
$username = "root";
$password = "";
$database = "car_rental_db";

// Create Database Connection

$conn = mysqli_connect($host, $username, $password, $database);

// Check Connection

if (!$conn) {
    die("Database Connection Failed: " . mysqli_connect_error());
}

?>
