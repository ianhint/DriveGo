
<?php

// Admin Authentication
require_once "../includes/auth_check.php";

// Database Connection
require_once "../config/dbconfig.php";


// Success and Error Message
$message = "";


// Get All Brands
$brand_sql = "SELECT * FROM brands ORDER BY brand_name ASC";
$brand_result = mysqli_query($conn, $brand_sql);


// Get All Categories
$category_sql = "SELECT * FROM categories ORDER BY category_name ASC";
$category_result = mysqli_query($conn, $category_sql);


// Form Submit
if (isset($_POST['add_car'])) {

    // Get Form Data
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


    // Image Upload
    $image_name = "";

    if (isset($_FILES['featured_image']) && $_FILES['featured_image']['error'] == 0) {

        $image = $_FILES['featured_image'];

        $allowed_types = ['jpg', 'jpeg', 'png', 'webp'];

        $image_extension = strtolower(pathinfo($image['name'], PATHINFO_EXTENSION));

        if (!in_array($image_extension, $allowed_types)) {

            $message = "Only JPG, JPEG, PNG and WEBP images are allowed!";

        } elseif ($image['size'] > 2 * 1024 * 1024) {

            $message = "Image size must be less than 2MB!";

        } elseif (getimagesize($image['tmp_name']) === false) {

            $message = "Invalid image file!";

        } else {

            // Create Unique Image Name
            $image_name = time() . "_" . basename($image['name']);

            // Upload Folder
            $upload_path = "../uploads/cars/" . $image_name;

            // Move Image to Folder
            if (!move_uploaded_file($image['tmp_name'], $upload_path)) {

                $message = "Image upload failed!";

            }

        }

    } else {

        $message = "Please select a car image!";

    }


    // Insert Car Data
    if ($message == "") {

        $sql = "INSERT INTO cars
                (category_id, brand_id, model_name, license_plate,
                 year, seating_capacity, fuel_type, transmission,
                 daily_rate, featured_image, status)

                VALUES
                ('$category_id', '$brand_id', '$model_name', '$license_plate',
                 '$year', '$seating_capacity', '$fuel_type', '$transmission',
                 '$daily_rate', '$image_name', '$status')";


        if (mysqli_query($conn, $sql)) {

            header("Location: cars.php");
            exit();

        } else {

            $message = "Car could not be added: " . mysqli_error($conn);

        }

    }

}

?>


<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Add New Car - DriveGo</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Boxicons -->
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/css/custom.css">


    <style>

        body {
            background: #f4f6fa;
            margin: 0;
        }

        .sidebar-wrapper {
            width: 250px;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            overflow-y: auto;
            overflow-x: hidden;
            z-index: 1000;
        }

        .main-content {
            margin-left: 250px;
            padding: 30px;
        }

        .form-card {
            border: none;
            border-radius: 10px;
        }

        .form-label {
            font-weight: 600;
        }

    </style>

</head>


<body>


    <!-- Sidebar -->

    <?php require_once "partials/sidebar.php"; ?>


    <!-- Main Content -->

    <div class="main-content">


        <!-- Page Header -->

        <div class="mb-4">

            <h2>Add New Car</h2>

            <p class="text-muted">
                Add a new rental car to your system.
            </p>

        </div>


        <!-- Add Car Form -->

        <div class="card form-card shadow-sm">

            <div class="card-body p-4">

                <h5 class="mb-4">Car Information</h5>


                <!-- Error Message -->

                <?php if ($message != "") { ?>

                    <div class="alert alert-danger">

                        <?php echo htmlspecialchars($message); ?>

                    </div>

                <?php } ?>


                <form method="POST" enctype="multipart/form-data">


                    <div class="row">


                        <!-- Car Model -->

                        <div class="col-md-6 mb-3">

                            <label class="form-label">Car Model</label>

                            <input type="text"
                                   name="model_name"
                                   class="form-control"
                                   placeholder="Example: Toyota Corolla Axio"
                                   required>

                        </div>


                        <!-- Brand -->

                        <div class="col-md-6 mb-3">

                            <label class="form-label">Brand</label>

                            <select name="brand_id" class="form-select" required>

                                <option value="">Select Brand</option>

                                <?php while ($brand = mysqli_fetch_assoc($brand_result)) { ?>

                                    <option value="<?php echo $brand['brand_id']; ?>">

                                        <?php echo htmlspecialchars($brand['brand_name']); ?>

                                    </option>

                                <?php } ?>

                            </select>

                        </div>


                        <!-- Category -->

                        <div class="col-md-6 mb-3">

                            <label class="form-label">Category</label>

                            <select name="category_id" class="form-select" required>

                                <option value="">Select Category</option>

                                <?php while ($category = mysqli_fetch_assoc($category_result)) { ?>

                                    <option value="<?php echo $category['category_id']; ?>">

                                        <?php echo htmlspecialchars($category['category_name']); ?>

                                    </option>

                                <?php } ?>

                            </select>

                        </div>


                        <!-- License Plate -->

                        <div class="col-md-6 mb-3">

                            <label class="form-label">License Plate</label>

                            <input type="text"
                                   name="license_plate"
                                   class="form-control"
                                   placeholder="DHAKA-METRO-GA-11-2233"
                                   required>

                        </div>


                        <!-- Year -->

                        <div class="col-md-6 mb-3">

                            <label class="form-label">Manufacturing Year</label>

                            <input type="number"
                                   name="year"
                                   class="form-control"
                                   min="1900"
                                   max="2100"
                                   required>

                        </div>


                        <!-- Seating Capacity -->

                        <div class="col-md-6 mb-3">

                            <label class="form-label">Seating Capacity</label>

                            <input type="number"
                                   name="seating_capacity"
                                   class="form-control"
                                   min="1"
                                   required>

                        </div>


                        <!-- Fuel Type -->

                        <div class="col-md-6 mb-3">

                            <label class="form-label">Fuel Type</label>

                            <select name="fuel_type" class="form-select" required>

                                <option value="">Select Fuel Type</option>
                                <option value="Petrol">Petrol</option>
                                <option value="Diesel">Diesel</option>
                                <option value="Hybrid">Hybrid</option>
                                <option value="Electric">Electric</option>

                            </select>

                        </div>


                        <!-- Transmission -->

                        <div class="col-md-6 mb-3">

                            <label class="form-label">Transmission</label>

                            <select name="transmission" class="form-select" required>

                                <option value="">Select Transmission</option>
                                <option value="Automatic">Automatic</option>
                                <option value="Manual">Manual</option>

                            </select>

                        </div>


                        <!-- Daily Rate -->

                        <div class="col-md-6 mb-3">

                            <label class="form-label">Daily Rent (৳)</label>

                            <input type="number"
                                   name="daily_rate"
                                   class="form-control"
                                   min="1"
                                   step="0.01"
                                   required>

                        </div>


                        <!-- Status -->

                        <div class="col-md-6 mb-3">

                            <label class="form-label">Car Status</label>

                            <select name="status" class="form-select" required>

                                <option value="available" selected>Available</option>
                                <option value="rented">Rented</option>
                                <option value="maintenance">Maintenance</option>
                                <option value="inactive">Inactive</option>

                            </select>

                        </div>


                        <!-- Car Image -->

                        <div class="col-md-12 mb-4">

                            <label class="form-label">Car Image</label>

                            <input type="file"
                                   name="featured_image"
                                   class="form-control"
                                   accept=".jpg,.jpeg,.png,.webp"
                                   required>

                            <small class="text-muted">
                                JPG, JPEG, PNG or WEBP. Maximum size 2MB.
                            </small>

                        </div>


                    </div>


                    <!-- Buttons -->

                    <button type="submit" name="add_car" class="btn btn-primary">

                        <i class="bx bx-save"></i>

                        Save Car

                    </button>


                    <a href="cars.php" class="btn btn-secondary">

                        Cancel

                    </a>


                </form>


            </div>

        </div>


    </div>


</body>

</html>
