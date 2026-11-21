
<?php

// Admin Authentication
require_once "../includes/auth_check.php";

// Database Connection
require_once "../config/dbconfig.php";

// Get Brand ID
$id = intval($_POST['id']);

// Get Brand Information
$sql = "SELECT * FROM brands WHERE brand_id = $id";

$result = mysqli_query($conn, $sql);

$brand = mysqli_fetch_assoc($result);


// Check Brand
if ($brand) {

    // Delete Brand from Database
    $sql = "DELETE FROM brands WHERE brand_id = $id";

    if (mysqli_query($conn, $sql)) {

        // Delete Brand Logo
        if (!empty($brand['logo'])) {

            $logo_path = "../uploads/brands/" . $brand['logo'];

            if (file_exists($logo_path)) {

                unlink($logo_path);

            }

        }

    }

}

// Back to Brands Page
header("Location: brands.php");
exit();

?>
