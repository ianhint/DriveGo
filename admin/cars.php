
<?php

// Admin Authentication
require_once "../includes/auth_check.php";

// Database Connection
require_once "../config/dbconfig.php";


// Get All Cars
$sql = "SELECT cars.*,
               categories.category_name,
               brands.brand_name

        FROM cars

        LEFT JOIN categories
        ON cars.category_id = categories.category_id

        LEFT JOIN brands
        ON cars.brand_id = brands.brand_id

        ORDER BY cars.car_id DESC";

$result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Manage Cars - DriveGo</title>

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

        .car-image {
            width: 75px;
            height: 50px;
            object-fit: cover;
            border-radius: 5px;
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

        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">

            <div>

                <h2>Manage Cars</h2>

                <p class="text-muted">
                    Manage all your rental cars here.
                </p>

            </div>

            <a href="add_car.php" class="btn btn-primary">

                <i class="bx bx-plus"></i>
                Add New Car

            </a>

        </div>


        <!-- Success / Error Message -->
        <?php if (isset($_GET['delete'])) { ?>

            <?php if ($_GET['delete'] == "success") { ?>

                <div class="alert alert-success">
                    Car deleted successfully!
                </div>

            <?php } elseif ($_GET['delete'] == "error") { ?>

                <div class="alert alert-danger">
                    Unable to delete car. It may be linked to existing bookings.
                </div>

            <?php } elseif ($_GET['delete'] == "notfound") { ?>

                <div class="alert alert-warning">
                    Car not found!
                </div>

            <?php } ?>

        <?php } ?>


        <!-- Cars Table -->
        <div class="card table-card shadow-sm">

            <div class="card-body">

                <h5 class="mb-4">All Cars</h5>

                <div class="table-responsive">

                    <table class="table table-hover align-middle">

                        <thead class="table-light">

                            <tr>

                                <th>Image</th>
                                <th>Car Model</th>
                                <th>Brand</th>
                                <th>Category</th>
                                <th>Year</th>
                                <th>Daily Rent</th>
                                <th>Status</th>
                                <th>Actions</th>

                            </tr>

                        </thead>


                        <tbody>

                            <?php

                            if ($result && mysqli_num_rows($result) > 0) {

                                while ($car = mysqli_fetch_assoc($result)) {

                            ?>

                            <tr>

                                <!-- Car Image -->
                                <td>

                                    <?php if (!empty($car['featured_image'])) { ?>

                                        <img
                                            src="../uploads/cars/<?php echo htmlspecialchars($car['featured_image']); ?>"
                                            class="car-image"
                                            alt="Car Image"
                                        >

                                    <?php } else { ?>

                                        <span class="text-muted">
                                            No Image
                                        </span>

                                    <?php } ?>

                                </td>


                                <!-- Car Model -->
                                <td>

                                    <strong>
                                        <?php echo htmlspecialchars($car['model_name']); ?>
                                    </strong>

                                </td>


                                <!-- Brand -->
                                <td>
                                    <?php echo htmlspecialchars($car['brand_name'] ?? 'N/A'); ?>
                                </td>


                                <!-- Category -->
                                <td>
                                    <?php echo htmlspecialchars($car['category_name'] ?? 'N/A'); ?>
                                </td>


                                <!-- Year -->
                                <td>
                                    <?php echo htmlspecialchars($car['year']); ?>
                                </td>


                                <!-- Daily Rent -->
                                <td>
                                    ৳<?php echo number_format($car['daily_rate'], 2); ?>
                                </td>


                                <!-- Status -->
                                <td>

                                    <?php

                                    $status_class = "bg-info";

                                    if ($car['status'] == "available") {

                                        $status_class = "bg-success";

                                    } elseif ($car['status'] == "rented") {

                                        $status_class = "bg-warning text-dark";

                                    } elseif ($car['status'] == "maintenance") {

                                        $status_class = "bg-danger";

                                    } elseif ($car['status'] == "inactive") {

                                        $status_class = "bg-secondary";

                                    }

                                    ?>

                                    <span class="badge <?php echo $status_class; ?>">

                                        <?php echo htmlspecialchars(ucfirst($car['status'])); ?>

                                    </span>

                                </td>


                                <!-- Actions -->
                                <td>

                                    <!-- View Button -->
                                    <a
                                        href="view_car.php?id=<?php echo $car['car_id']; ?>"
                                        class="btn btn-sm btn-info text-white"
                                        title="View Car"
                                    >

                                        <i class="bx bx-show"></i>

                                    </a>


                                    <!-- Edit Button -->
                                    <a
                                        href="edit_car.php?id=<?php echo $car['car_id']; ?>"
                                        class="btn btn-sm btn-warning"
                                        title="Edit Car"
                                    >

                                        <i class="bx bx-edit"></i>

                                    </a>


                                    <!-- Delete Button -->
                                    <form
                                        action="delete_car.php"
                                        method="POST"
                                        style="display:inline;"
                                        onsubmit="return confirm('Are you sure you want to delete this car?');"
                                    >

                                        <input
                                            type="hidden"
                                            name="id"
                                            value="<?php echo $car['car_id']; ?>"
                                        >

                                        <button
                                            type="submit"
                                            class="btn btn-sm btn-danger"
                                            title="Delete Car"
                                        >

                                            <i class="bx bx-trash"></i>

                                        </button>

                                    </form>

                                </td>

                            </tr>

                            <?php

                                }

                            } else {

                            ?>

                                <tr>

                                    <td colspan="8" class="text-center py-4">
                                        No Cars Found!
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
