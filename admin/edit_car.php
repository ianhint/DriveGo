
<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once "../includes/auth_check.php";
require_once "../config/dbconfig.php";

$error = "";

// Get Car ID
if (!isset($_GET['id'])) {
    die("Car ID not found!");
}

$car_id = (int) $_GET['id'];

// Get Existing Car Information
$sql = "SELECT * FROM cars WHERE car_id = $car_id";
$result = mysqli_query($conn, $sql);

if (!$result || mysqli_num_rows($result) == 0) {
    die("Car not found!");
}

$car = mysqli_fetch_assoc($result);

// Get Brands
$brand_sql = "SELECT * FROM brands ORDER BY brand_name ASC";
$brand_result = mysqli_query($conn, $brand_sql);

// Get Categories
$category_sql = "SELECT * FROM categories ORDER BY category_name ASC";
$category_result = mysqli_query($conn, $category_sql);


// Update Car Information
if (isset($_POST['update_car'])) {

    $model_name = mysqli_real_escape_string($conn, $_POST['model_name']);
    $brand_id = (int) $_POST['brand_id'];
    $category_id = (int) $_POST['category_id'];
    $license_plate = mysqli_real_escape_string($conn, $_POST['license_plate']);
    $year = (int) $_POST['year'];
    $seating_capacity = (int) $_POST['seating_capacity'];
    $fuel_type = mysqli_real_escape_string($conn, $_POST['fuel_type']);
    $transmission = mysqli_real_escape_string($conn, $_POST['transmission']);
    $daily_rate = (float) $_POST['daily_rate'];
    $status = mysqli_real_escape_string($conn, $_POST['status']);

    // Keep Old Image
    $old_image = $car['featured_image'];
    $featured_image = $old_image;

    $new_image_uploaded = false;

    // Check New Image
    if ($_FILES['featured_image']['error'] == UPLOAD_ERR_OK) {

        $image = $_FILES['featured_image'];

        $image_name = $image['name'];
        $image_tmp = $image['tmp_name'];
        $image_size = $image['size'];

        $image_extension = strtolower(pathinfo($image_name, PATHINFO_EXTENSION));

        $allowed_extensions = ['jpg', 'jpeg', 'png', 'webp'];

        if (!in_array($image_extension, $allowed_extensions)) {

            $error = "Only JPG, JPEG, PNG and WEBP images are allowed.";

        } elseif ($image_size > 2000000) {

            $error = "Image size must be less than 2MB.";

        } elseif (getimagesize($image_tmp) == false) {

            $error = "Invalid image file.";

        } else {

            $new_image_name = time() . "_" . basename($image_name);
            $upload_path = "../uploads/cars/" . $new_image_name;

            if (move_uploaded_file($image_tmp, $upload_path)) {

                $featured_image = $new_image_name;
                $new_image_uploaded = true;

            } else {

                $error = "Image upload failed!";
            }
        }

    } elseif ($_FILES['featured_image']['error'] != UPLOAD_ERR_NO_FILE) {

        $error = "There was a problem uploading the image.";
    }


    // Update Database
    if ($error == "") {

        $update_sql = "UPDATE cars SET

            category_id = '$category_id',
            brand_id = '$brand_id',
            model_name = '$model_name',
            license_plate = '$license_plate',
            year = '$year',
            seating_capacity = '$seating_capacity',
            fuel_type = '$fuel_type',
            transmission = '$transmission',
            daily_rate = '$daily_rate',
            featured_image = '$featured_image',
            status = '$status'

            WHERE car_id = '$car_id'";


        if (mysqli_query($conn, $update_sql)) {

            // Delete Old Image if New Image Uploaded
            if ($new_image_uploaded && !empty($old_image)) {

                $old_image_path = "../uploads/cars/" . $old_image;

                if (file_exists($old_image_path)) {
                    unlink($old_image_path);
                }
            }

            header("Location: cars.php");
            exit();

        } else {

            // Delete New Image if Database Update Fails
            if ($new_image_uploaded) {

                $new_image_path = "../uploads/cars/" . $featured_image;

                if (file_exists($new_image_path)) {
                    unlink($new_image_path);
                }
            }

            $error = "Car update failed!";
        }
    }


    // Keep Updated Values in Form
    $car['model_name'] = $model_name;
    $car['brand_id'] = $brand_id;
    $car['category_id'] = $category_id;
    $car['license_plate'] = $license_plate;
    $car['year'] = $year;
    $car['seating_capacity'] = $seating_capacity;
    $car['fuel_type'] = $fuel_type;
    $car['transmission'] = $transmission;
    $car['daily_rate'] = $daily_rate;
    $car['status'] = $status;

    // Keep Old Image if Update Failed
    if (!$new_image_uploaded || $error != "") {
        $car['featured_image'] = $old_image;
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Edit Car - DriveGo</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="assets/css/custom.css">
</head>

<body>

    <?php require_once "partials/sidebar.php"; ?>

    <div class="main-content">

        <div class="container-fluid p-4">

            <h3 class="mb-4">Edit Car</h3>

            <?php if ($error != "") { ?>

                <div class="alert alert-danger">
                    <?php echo htmlspecialchars($error); ?>
                </div>

            <?php } ?>

            <div class="card shadow-sm">

                <div class="card-body">

                    <form action="" method="POST" enctype="multipart/form-data">

                        <div class="row">

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Car Model</label>

                                <input type="text" name="model_name" class="form-control"
                                    value="<?php echo htmlspecialchars($car['model_name']); ?>" required>
                            </div>


                            <div class="col-md-6 mb-3">
                                <label class="form-label">Brand</label>

                                <select name="brand_id" class="form-select" required>

                                    <?php while ($brand = mysqli_fetch_assoc($brand_result)) { ?>

                                        <option value="<?php echo $brand['brand_id']; ?>"
                                            <?php if ($car['brand_id'] == $brand['brand_id']) echo "selected"; ?>>

                                            <?php echo htmlspecialchars($brand['brand_name']); ?>

                                        </option>

                                    <?php } ?>

                                </select>
                            </div>


                            <div class="col-md-6 mb-3">
                                <label class="form-label">Category</label>

                                <select name="category_id" class="form-select" required>

                                    <?php while ($category = mysqli_fetch_assoc($category_result)) { ?>

                                        <option value="<?php echo $category['category_id']; ?>"
                                            <?php if ($car['category_id'] == $category['category_id']) echo "selected"; ?>>

                                            <?php echo htmlspecialchars($category['category_name']); ?>

                                        </option>

                                    <?php } ?>

                                </select>
                            </div>


                            <div class="col-md-6 mb-3">
                                <label class="form-label">License Plate</label>

                                <input type="text" name="license_plate" class="form-control"
                                    value="<?php echo htmlspecialchars($car['license_plate']); ?>" required>
                            </div>


                            <div class="col-md-6 mb-3">
                                <label class="form-label">Year</label>

                                <input type="number" name="year" class="form-control"
                                    value="<?php echo htmlspecialchars($car['year']); ?>" required>
                            </div>


                            <div class="col-md-6 mb-3">
                                <label class="form-label">Seating Capacity</label>

                                <input type="number" name="seating_capacity" class="form-control"
                                    value="<?php echo htmlspecialchars($car['seating_capacity']); ?>" required>
                            </div>


                            <div class="col-md-6 mb-3">
                                <label class="form-label">Fuel Type</label>

                                <select name="fuel_type" class="form-select" required>

                                    <option value="Petrol" <?php if ($car['fuel_type'] == 'Petrol') echo 'selected'; ?>>Petrol</option>

                                    <option value="Diesel" <?php if ($car['fuel_type'] == 'Diesel') echo 'selected'; ?>>Diesel</option>

                                    <option value="Hybrid" <?php if ($car['fuel_type'] == 'Hybrid') echo 'selected'; ?>>Hybrid</option>

                                    <option value="Electric" <?php if ($car['fuel_type'] == 'Electric') echo 'selected'; ?>>Electric</option>

                                </select>
                            </div>


                            <div class="col-md-6 mb-3">
                                <label class="form-label">Transmission</label>

                                <select name="transmission" class="form-select" required>

                                    <option value="Automatic" <?php if ($car['transmission'] == 'Automatic') echo 'selected'; ?>>Automatic</option>

                                    <option value="Manual" <?php if ($car['transmission'] == 'Manual') echo 'selected'; ?>>Manual</option>

                                </select>
                            </div>


                            <div class="col-md-6 mb-3">
                                <label class="form-label">Daily Rent</label>

                                <input type="number" step="0.01" name="daily_rate" class="form-control"
                                    value="<?php echo htmlspecialchars($car['daily_rate']); ?>" required>
                            </div>


                            <div class="col-md-6 mb-3">
                                <label class="form-label">Status</label>

                                <select name="status" class="form-select" required>

                                    <option value="available" <?php if ($car['status'] == 'available') echo 'selected'; ?>>Available</option>

                                    <option value="rented" <?php if ($car['status'] == 'rented') echo 'selected'; ?>>Rented</option>

                                    <option value="maintenance" <?php if ($car['status'] == 'maintenance') echo 'selected'; ?>>Maintenance</option>

                                    <option value="inactive" <?php if ($car['status'] == 'inactive') echo 'selected'; ?>>Inactive</option>

                                </select>
                            </div>


                            <div class="col-md-6 mb-3">

                                <label class="form-label">Current Car Image</label>

                                <?php if (!empty($car['featured_image'])) { ?>

                                    <div class="mb-2">
                                        <img src="../uploads/cars/<?php echo htmlspecialchars($car['featured_image']); ?>"
                                            width="150" alt="Car Image">
                                    </div>

                                <?php } else { ?>

                                    <p>No image available.</p>

                                <?php } ?>

                                <label class="form-label">Change Car Image (Optional)</label>

                                <input type="file" name="featured_image" class="form-control"
                                    accept=".jpg,.jpeg,.png,.webp">

                            </div>

                        </div>


                        <button type="submit" name="update_car" class="btn btn-primary">
                            Update Car
                        </button>

                        <a href="cars.php" class="btn btn-secondary">
                            Cancel
                        </a>

                    </form>

                </div>

            </div>

        </div>

    </div>

</body>

</html>
