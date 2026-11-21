
<?php

// Admin Authentication
require_once "../includes/auth_check.php";

// Database Connection
require_once "../config/dbconfig.php";


// Check Form Submit
if (isset($_POST['id'])) {

    // Get Car ID
    $id = intval($_POST['id']);


    // Get Car Information
    $sql = "SELECT * FROM cars WHERE car_id = $id";

    $result = mysqli_query($conn, $sql);

    $car = mysqli_fetch_assoc($result);


    // Check Car
    if ($car) {

        // Delete Car from Database
        $sql = "DELETE FROM cars WHERE car_id = $id";

        if (mysqli_query($conn, $sql)) {

            // Delete Car Image
            if (!empty($car['featured_image'])) {

                $image_path = "../uploads/cars/" . $car['featured_image'];

                if (file_exists($image_path)) {

                    unlink($image_path);

                }

            }

            // Redirect Success
            header("Location: cars.php?delete=success");
            exit();

        } else {

            // Database Error
            header("Location: cars.php?delete=error");
            exit();

        }

    } else {

        // Car Not Found
        header("Location: cars.php?delete=notfound");
        exit();

    }

}


// Redirect if ID is missing
header("Location: cars.php");
exit();

?>
