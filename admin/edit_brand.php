
<?php

// Admin Authentication
require_once "../includes/auth_check.php";

// Database Connection
require_once "../config/dbconfig.php";

$message = "";

// Get Brand ID
$id = intval($_GET['id']);

// Get Brand Information
$sql = "SELECT * FROM brands WHERE brand_id = $id";

$result = mysqli_query($conn, $sql);

$brand = mysqli_fetch_assoc($result);

// Check Brand
if (!$brand) {
    die("Brand not found!");
}


// Update Brand
if (isset($_POST['update_brand'])) {

    // Get Brand Name
    $brand_name = mysqli_real_escape_string($conn, $_POST['brand_name']);

    // Keep Old Logo
    $new_logo_name = $brand['logo'];

    // Check New Logo
    if ($_FILES['logo']['error'] != 4) {

        $logo_name = $_FILES['logo']['name'];
        $logo_tmp = $_FILES['logo']['tmp_name'];

        // Get Extension
        $extension = strtolower(pathinfo($logo_name, PATHINFO_EXTENSION));

        // Allowed Extensions
        $allowed = array("jpg", "jpeg", "png", "webp");

        if (!in_array($extension, $allowed)) {

            $message = "Only JPG, PNG and WEBP files are allowed.";

        } else {

            // Create New File Name
            $new_logo_name = time() . "_" . basename($logo_name);

            // Upload Logo
            if (!move_uploaded_file($logo_tmp, "../uploads/brands/" . $new_logo_name)) {

                $message = "Logo upload failed!";

            }

        }

    }


    // Update Database
    if (empty($message)) {

        $sql = "UPDATE brands SET
                brand_name = '$brand_name',
                logo = '$new_logo_name'
                WHERE brand_id = $id";

        if (mysqli_query($conn, $sql)) {

            // Delete Old Logo if New Logo Uploaded
            if ($new_logo_name != $brand['logo'] && !empty($brand['logo'])) {

                $old_logo = "../uploads/brands/" . $brand['logo'];

                if (file_exists($old_logo)) {
                    unlink($old_logo);
                }

            }

            header("Location: brands.php");
            exit();

        } else {

            $message = "Database update failed!";

        }

    }

}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Edit Brand - DriveGo</title>

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

        .brand-logo {
            width: 100px;
            height: 80px;
            object-fit: contain;
            border: 1px solid #ddd;
            padding: 5px;
            border-radius: 5px;
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

            <h2>Edit Brand</h2>

            <p class="text-muted">
                Update your car brand information.
            </p>

        </div>


        <!-- Edit Brand Form -->
        <div class="card form-card shadow-sm">

            <div class="card-header">

                <h4 class="mb-0">
                    <i class="bx bx-edit"></i>
                    Edit Brand
                </h4>

            </div>


            <div class="card-body">

                <!-- Error Message -->
                <?php if (!empty($message)) { ?>

                    <div class="alert alert-danger">
                        <?php echo $message; ?>
                    </div>

                <?php } ?>


                <form method="POST" enctype="multipart/form-data">

                    <!-- Brand Name -->
                    <div class="mb-4">

                        <label class="form-label">
                            Brand Name
                        </label>

                        <input
                            type="text"
                            name="brand_name"
                            class="form-control"
                            value="<?php echo htmlspecialchars($brand['brand_name']); ?>"
                            required
                        >

                    </div>


                    <!-- Current Logo -->
                    <div class="mb-3">

                        <label class="form-label">
                            Current Brand Logo
                        </label>

                        <div>

                            <?php if (!empty($brand['logo'])) { ?>

                                <img
                                    src="../uploads/brands/<?php echo htmlspecialchars($brand['logo']); ?>"
                                    class="brand-logo"
                                    alt="Brand Logo"
                                >

                            <?php } else { ?>

                                <span class="text-muted">No Logo</span>

                            <?php } ?>

                        </div>

                    </div>


                    <!-- New Logo -->
                    <div class="mb-4">

                        <label class="form-label">
                            Upload New Logo (Optional)
                        </label>

                        <input
                            type="file"
                            name="logo"
                            class="form-control"
                            accept=".jpg,.jpeg,.png,.webp"
                        >

                        <small class="text-muted">
                            Leave empty if you do not want to change the logo.
                        </small>

                    </div>


                    <!-- Buttons -->
                    <button
                        type="submit"
                        name="update_brand"
                        class="btn btn-primary"
                    >

                        <i class="bx bx-save"></i>
                        Update Brand

                    </button>


                    <a href="brands.php" class="btn btn-secondary">

                        <i class="bx bx-arrow-back"></i>
                        Back

                    </a>

                </form>

            </div>

        </div>

    </div>

</body>

</html>
