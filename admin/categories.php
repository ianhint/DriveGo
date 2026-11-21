
<?php

// Admin Authentication
require_once "../includes/auth_check.php";

// Database Connection
require_once "../config/dbconfig.php";


// Get All Categories
$sql = "SELECT * FROM categories ORDER BY category_id DESC";

$result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Manage Categories - DriveGo</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">

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

        .table-card {
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

        <div class="d-flex justify-content-between align-items-center mb-4">

            <div>

                <h2>Manage Categories</h2>

                <p class="text-muted">
                    Manage all car categories here.
                </p>

            </div>

            <a href="add_category.php" class="btn btn-primary">

                <i class="bx bx-plus"></i>

                Add Category

            </a>

        </div>


        <!-- Categories Table -->
        <div class="card table-card shadow-sm">

            <div class="card-body">

                <h5 class="mb-4">All Categories</h5>

                <div class="table-responsive">

                    <table class="table table-hover align-middle">

                        <thead class="table-light">

                            <tr>

                                <th>Category ID</th>
                                <th>Category Name</th>
                                <th>Description</th>
                                <th>Created At</th>

                            </tr>

                        </thead>

                        <tbody>

                            <?php

                            if ($result && mysqli_num_rows($result) > 0) {

                                while ($category = mysqli_fetch_assoc($result)) {

                            ?>

                            <tr>

                                <td>
                                    <?php echo $category['category_id']; ?>
                                </td>

                                <td>
                                    <strong>
                                        <?php echo htmlspecialchars($category['category_name']); ?>
                                    </strong>
                                </td>

                                <td>
                                    <?php echo htmlspecialchars($category['description'] ?? ''); ?>
                                </td>

                                <td>
                                    <?php echo htmlspecialchars($category['created_at']); ?>
                                </td>

                            </tr>

                            <?php

                                }

                            } else {

                            ?>

                            <tr>

                                <td colspan="4" class="text-center py-4">
                                    No Categories Found!
                                </td>

                            </tr>

                            <?php

                            }

                            ?>

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>

</body>

</html>
