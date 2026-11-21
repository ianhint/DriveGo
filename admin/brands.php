
<?php

// Admin Authentication
require_once "../includes/auth_check.php";

// Database Connection
require_once "../config/dbconfig.php";


// Get All Brands
$sql = "SELECT * FROM brands ORDER BY brand_id DESC";

$result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Manage Brands - DriveGo</title>

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

        .table-card {
            border: none;
            border-radius: 10px;
        }

        .brand-logo {
            width: 60px;
            height: 50px;
            object-fit: contain;
        }

    </style>

</head>

<body>

    <!-- Sidebar -->
    <?php require_once "partials/sidebar.php"; ?>


    <!-- Main Content -->
    <div class="main-content">

        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">

            <div>

                <h2>Manage Brands</h2>

                <p class="text-muted">
                    Manage all car brands here.
                </p>

            </div>

            <a href="add_brand.php" class="btn btn-primary">

                <i class="bx bx-plus"></i>

                Add New Brand

            </a>

        </div>


        <!-- Brands Table -->
        <div class="card table-card shadow-sm">

            <div class="card-body">

                <h5 class="mb-4">All Brands</h5>

                <div class="table-responsive">

                    <table class="table table-hover align-middle">

                        <thead class="table-light">

                            <tr>

                                <th>Brand ID</th>
                                <th>Brand Logo</th>
                                <th>Brand Name</th>
                                <th>Created At</th>
                                <th>Actions</th>

                            </tr>

                        </thead>


                        <tbody>

                            <?php

                            if ($result && mysqli_num_rows($result) > 0) {

                                while ($brand = mysqli_fetch_assoc($result)) {

                            ?>

                            <tr>

                                <!-- Brand ID -->
                                <td>
                                    <?php echo $brand['brand_id']; ?>
                                </td>


                                <!-- Brand Logo -->
                                <td>

                                    <?php if (!empty($brand['logo'])) { ?>

                                        <img
                                            src="../uploads/brands/<?php echo htmlspecialchars($brand['logo']); ?>"
                                            class="brand-logo"
                                            alt="Brand Logo"
                                        >

                                    <?php } else { ?>

                                        <span class="text-muted">
                                            No Logo
                                        </span>

                                    <?php } ?>

                                </td>


                                <!-- Brand Name -->
                                <td>

                                    <strong>
                                        <?php echo htmlspecialchars($brand['brand_name']); ?>
                                    </strong>

                                </td>


                                <!-- Created At -->
                                <td>
                                    <?php echo htmlspecialchars($brand['created_at']); ?>
                                </td>


                                <!-- Actions -->
                                <td>

                                    <!-- Edit Button -->
                                    <a
                                        href="edit_brand.php?id=<?php echo $brand['brand_id']; ?>"
                                        class="btn btn-sm btn-primary"
                                    >

                                        <i class="bx bx-edit"></i>
                                        Edit

                                    </a>


                                    <!-- Delete Button -->
                                    <form
                                        action="delete_brand.php"
                                        method="POST"
                                        style="display: inline;"
                                        onsubmit="return confirm('Are you sure you want to delete this brand?');"
                                    >

                                        <input
                                            type="hidden"
                                            name="id"
                                            value="<?php echo $brand['brand_id']; ?>"
                                        >

                                        <button
                                            type="submit"
                                            class="btn btn-sm btn-danger"
                                        >

                                            <i class="bx bx-trash"></i>
                                            Delete

                                        </button>

                                    </form>

                                </td>

                            </tr>

                            <?php

                                }

                            } else {

                            ?>

                            <tr>

                                <td colspan="5" class="text-center py-4">

                                    No Brands Found!

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


    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
