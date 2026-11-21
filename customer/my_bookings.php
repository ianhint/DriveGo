
<?php

session_start();

require_once "../config/dbconfig.php";

// Check Login
if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit;
}

// Check Customer Role
if ($_SESSION['role_name'] != "Customer") {
    header("Location: ../auth/login.php");
    exit;
}

// Get Customer Bookings
$customer_id = (int) $_SESSION['user_id'];

$sql = "SELECT bookings.*,
               cars.model_name,
               cars.featured_image,
               brands.brand_name

        FROM bookings

        LEFT JOIN cars
        ON bookings.car_id = cars.car_id

        LEFT JOIN brands
        ON cars.brand_id = brands.brand_id

        WHERE bookings.customer_id = $customer_id

        ORDER BY bookings.booking_id DESC";

$result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>My Bookings - DriveGo</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">

    <link rel="stylesheet" href="../assets/css/frontend.css">

</head>

<body>

<div class="container py-5">

    <!-- Header -->

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h2 class="fw-bold">My Bookings</h2>

            <p class="text-muted">
                View all your car rental bookings
            </p>

        </div>

        <a href="dashboard.php" class="btn btn-outline-primary">
            Back to Dashboard
        </a>

    </div>


    <!-- Booking List -->

    <?php if ($result && mysqli_num_rows($result) > 0) { ?>

        <div class="row g-4">

            <?php while ($booking = mysqli_fetch_assoc($result)) { ?>

                <div class="col-lg-6">

                    <div class="card shadow-sm border-0 p-3 h-100">

                        <div class="row g-3">

                            <!-- Car Image -->

                            <div class="col-md-5">

                                <?php if (!empty($booking['featured_image'])) { ?>

                                    <img
                                        src="../uploads/cars/<?php echo htmlspecialchars($booking['featured_image']); ?>"
                                        class="img-fluid rounded"
                                        style="width:100%; height:180px; object-fit:cover;"
                                        alt="Car Image"
                                    >

                                <?php } else { ?>

                                    <div class="bg-light rounded d-flex justify-content-center align-items-center"
                                         style="height:180px;">

                                        <i class='bx bx-car fs-1'></i>

                                    </div>

                                <?php } ?>

                            </div>


                            <!-- Booking Information -->

                            <div class="col-md-7">

                                <h5 class="fw-bold">

                                    <?php echo htmlspecialchars($booking['brand_name'] ?? ''); ?>

                                    <?php echo htmlspecialchars($booking['model_name'] ?? ''); ?>

                                </h5>

                                <p class="mb-1">
                                    <strong>Booking No:</strong>
                                    <?php echo htmlspecialchars($booking['booking_number']); ?>
                                </p>

                                <p class="mb-1">
                                    <strong>Pickup:</strong>
                                    <?php echo htmlspecialchars($booking['pickup_date']); ?>
                                </p>

                                <p class="mb-1">
                                    <strong>Return:</strong>
                                    <?php echo htmlspecialchars($booking['return_date']); ?>
                                </p>

                                <p class="mb-1">
                                    <strong>Total Amount:</strong>
                                    ৳<?php echo number_format($booking['total_amount'], 2); ?>
                                </p>

                                <p class="mb-0">

                                    <strong>Status:</strong>

                                    <?php echo htmlspecialchars($booking['status']); ?>

                                </p>

                            </div>

                        </div>

                    </div>

                </div>

            <?php } ?>

        </div>

    <?php } else { ?>

        <div class="text-center bg-light rounded p-5">

            <i class='bx bx-calendar-x fs-1 text-secondary'></i>

            <h4 class="mt-3">No Bookings Found!</h4>

            <p class="text-muted">
                You have not booked any car yet.
            </p>

            <a href="../frontend/cars.php" class="btn btn-primary">
                Explore Cars
            </a>

        </div>

    <?php } ?>

</div>

</body>
</html>
