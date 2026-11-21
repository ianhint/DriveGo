
<?php

// Admin Authentication
require_once "../includes/auth_check.php";

// Database Connection
require_once "../config/dbconfig.php";


// Error Message
$error = "";


// Add Category
if (isset($_POST['add_category'])) {

    // Get Form Data
    $category_name = mysqli_real_escape_string($conn, $_POST['category_name']);

    $description = mysqli_real_escape_string($conn, $_POST['description']);


    // Check Category Name
    if (empty($category_name)) {

        $error = "Category name is required!";

    } else {

        // Insert Category
        $sql = "INSERT INTO categories (category_name, description)
                VALUES ('$category_name', '$description')";


        if (mysqli_query($conn, $sql)) {

            header("Location: categories.php");
            exit();

        } else {

            $error = "Category could not be added!";

        }

    }

}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Add Category - DriveGo</title>

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

    </style>

</head>

<body>

    <!-- Sidebar -->
    <?php require_once "partials/sidebar.php"; ?>


    <!-- Main Content -->
    <div class="main-content">

        <div class="mb-4">

            <h2>Add New Category</h2>

            <p class="text-muted">
                Create a new car category.
            </p>

        </div>


        <!-- Error Message -->
        <?php if ($error != "") { ?>

            <div class="alert alert-danger">
                <?php echo htmlspecialchars($error); ?>
            </div>

        <?php } ?>


        <!-- Add Category Form -->
        <div class="card form-card shadow-sm">

            <div class="card-body p-4">

                <form action="" method="POST">

                    <!-- Category Name -->
                    <div class="mb-3">

                        <label class="form-label">
                            Category Name
                        </label>

                        <input
                            type="text"
                            name="category_name"
                            class="form-control"
                            placeholder="Enter category name"
                            required
                        >

                    </div>


                    <!-- Description -->
                    <div class="mb-3">

                        <label class="form-label">
                            Description
                        </label>

                        <textarea
                            name="description"
                            class="form-control"
                            rows="4"
                            placeholder="Enter category description"
                        ></textarea>

                    </div>


                    <!-- Buttons -->
                    <button type="submit" name="add_category" class="btn btn-primary">

                        <i class="bx bx-plus"></i>

                        Add Category

                    </button>


                    <a href="categories.php" class="btn btn-secondary">

                        Cancel

                    </a>

                </form>

            </div>

        </div>

    </div>

</body>

</html>
