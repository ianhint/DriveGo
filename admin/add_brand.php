
<?php

// Admin Authentication
require_once "../includes/auth_check.php";

// Database Connection
require_once "../config/dbconfig.php";

$message = "";


// Check Form Submit
if (isset($_POST['add_brand'])) {

    // Get Brand Name
    $brand_name = mysqli_real_escape_string($conn, $_POST['brand_name']);

    // Get Logo Information
    $logo_name = $_FILES['logo']['name'];
    $logo_tmp = $_FILES['logo']['tmp_name'];

    // Get File Extension
    $extension = strtolower(pathinfo($logo_name, PATHINFO_EXTENSION));

    // Allowed Extensions
    $allowed = array("jpg", "jpeg", "png", "webp");

    if (empty($brand_name) || empty($logo_name)) {

        $message = "Please enter brand name and select logo.";

    } elseif (!in_array($extension, $allowed)) {

        $message = "Only JPG, PNG and WEBP files are allowed.";

    } else {

        // Create New Logo Name
        $new_logo_name = time() . "_" . basename($logo_name);

        // Upload Folder
        $upload_folder = "../uploads/brands/";

        // Move Logo to Folder
        if (move_uploaded_file($logo_tmp, $upload_folder . $new_logo_name)) {

            // Insert Brand into Database
            $sql = "INSERT INTO brands (brand_name, logo)
                    VALUES ('$brand_name', '$new_logo_name')";

            if (mysqli_query($conn, $sql)) {

                header("Location: brands.php");
                exit();

            } else {

                $message = "Database error!";

            }

        } else {

            $message = "Logo upload failed!";

        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Add New Brand - DriveGo</title>

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

        .form-card .card-header {
            background: #142c50;
            color: white;
            padding: 18px 25px;
            border-radius: 10px 10px 0 0;
        }

        .form-card .card-body {
            padding: 30px;
        }

        .form-label {
            font-weight: 600;
            color: #142c50;
        }

        .form-control {
            padding: 12px;
        }

        .btn-primary {
            background: #0d6efd;
            padding: 10px 25px;
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

            <h2>Add New Brand</h2>

            <p class="text-muted">
                Add a new car brand to your system.
            </p>

        </div>


        <!-- Add Brand Form -->
        <div class="card form-card shadow-sm">

            <!-- Card Header -->
            <div class="card-header">

                <h4 class="mb-0">
                    <i class="bx bxs-purchase-tag"></i>
                    Add New Brand
                </h4>

            </div>


            <!-- Card Body -->
            <div class="card-body">

                <!-- Error Message -->
                <?php if (!empty($message)) { ?>

                    <div class="alert alert-danger">
                        <?php echo $message; ?>
                    </div>

                <?php } ?>


                <!-- Form -->
                <form method="POST" enctype="multipart/form-data">


                    <!-- Brand Name -->
                    <div class="mb-4">

                        <label class="form-label">

                            <i class="bx bxs-purchase-tag"></i>
                            Brand Name

                        </label>

                        <input
                            type="text"
                            name="brand_name"
                            class="form-control"
                            placeholder="Enter Brand Name"
                            required
                        >

                    </div>


                    <!-- Brand Logo -->
                    <div class="mb-4">

                        <label class="form-label">

                            <i class="bx bx-image"></i>
                            Brand Logo

                        </label>

                        <input
                            type="file"
                            name="logo"
                            class="form-control"
                            accept=".jpg,.jpeg,.png,.webp"
                            required
                        >

                        <small class="text-muted">
                            Allowed formats: JPG, JPEG, PNG and WEBP.
                        </small>

                    </div>


                    <!-- Buttons -->
                    <button
                        type="submit"
                        name="add_brand"
                        class="btn btn-primary"
                    >

                        <i class="bx bx-plus"></i>
                        Add Brand

                    </button>


                    <a href="brands.php" class="btn btn-secondary">

                        <i class="bx bx-arrow-back"></i>
                        Back

                    </a>


                </form>

            </div>

        </div>

    </div>


    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
