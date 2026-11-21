
<?php

require_once "../includes/auth_check.php";
require_once "../config/dbconfig.php";


// Get Booking ID
if (!isset($_GET['id'])) {
    die("Booking ID not found!");
}

$booking_id = (int) $_GET['id'];


// Get Booking Details
$sql = "SELECT bookings.*,
               users.full_name,
               users.email,
               users.phone,
               users.address,
               cars.model_name,
               cars.year,
               cars.license_plate,
               cars.daily_rate,
               cars.featured_image,
               brands.brand_name,
               categories.category_name

        FROM bookings

        LEFT JOIN users
        ON bookings.customer_id = users.user_id

        LEFT JOIN cars
        ON bookings.car_id = cars.car_id

        LEFT JOIN brands
        ON cars.brand_id = brands.brand_id

        LEFT JOIN categories
        ON cars.category_id = categories.category_id

        WHERE bookings.booking_id = $booking_id";

$result = mysqli_query($conn, $sql);

if (!$result || mysqli_num_rows($result) == 0) {
    die("Booking not found!");
}

$booking = mysqli_fetch_assoc($result);

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Booking Details - DriveGo</title>

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

        .details-card {
            border: none;
            border-radius: 10px;
            overflow: hidden;
        }

        .card-header-custom {
            background: #142c50;
            color: white;
            padding: 18px 22px;
        }

        .detail-item {
            padding: 12px 0;
            border-bottom: 1px solid #eeeeee;
        }

        .detail-label {
            color: #777;
            font-size: 14px;
        }

        .detail-value {
            font-weight: 600;
            color: #222;
        }

        .car-image {
            width: 100%;
            max-width: 350px;
            height: 210px;
            object-fit: cover;
            border-radius: 8px;
        }

    </style>

</head>

<body>

    <?php require_once "partials/sidebar.php"; ?>


    <div class="main-content">

        <div class="container-fluid">

            <div class="d-flex justify-content-between align-items-center mb-4">

                <h3>Booking Details</h3>

                <a href="bookings.php" class="btn btn-secondary">
                    <i class='bx bx-arrow-back'></i>
                    Back to Bookings
                </a>

            </div>


            <!-- Booking Information -->

            <div class="card details-card shadow-sm mb-4">

                <div class="card-header-custom">

                    <h5 class="mb-0">
                        <i class='bx bx-calendar-check'></i>
                        Booking Information
                    </h5>

                </div>


                <div class="card-body">

                    <div class="row">

                        <div class="col-md-6">

                            <div class="detail-item">
                                <div class="detail-label">Booking Number</div>

                                <div class="detail-value">
                                    <?php echo htmlspecialchars($booking['booking_number']); ?>
                                </div>
                            </div>


                            <div class="detail-item">
                                <div class="detail-label">Pickup Date</div>

                                <div class="detail-value">
                                    <?php echo date('d M Y, h:i A', strtotime($booking['pickup_date'])); ?>
                                </div>
                            </div>


                            <div class="detail-item">
                                <div class="detail-label">Return Date</div>

                                <div class="detail-value">
                                    <?php echo date('d M Y, h:i A', strtotime($booking['return_date'])); ?>
                                </div>
                            </div>


                            <div class="detail-item">
                                <div class="detail-label">Total Days</div>

                                <div class="detail-value">
                                    <?php echo htmlspecialchars($booking['total_days']); ?> Days
                                </div>
                            </div>

                        </div>


                        <div class="col-md-6">

                            <div class="detail-item">
                                <div class="detail-label">Total Amount</div>

                                <div class="detail-value text-success">
                                    ৳<?php echo number_format($booking['total_amount'], 2); ?>
                                </div>
                            </div>


                            <div class="detail-item">
                                <div class="detail-label">Pickup Location</div>

                                <div class="detail-value">
                                    <?php echo htmlspecialchars($booking['pickup_location']); ?>
                                </div>
                            </div>


                            <div class="detail-item">
                                <div class="detail-label">Return Location</div>

                                <div class="detail-value">
                                    <?php echo htmlspecialchars($booking['return_location']); ?>
                                </div>
                            </div>


                            <div class="detail-item">
                                <div class="detail-label">Booking Status</div>

                                <div class="detail-value">

                                    <?php

                                    $status = $booking['status'];

                                    if ($status == 'Pending') {
                                        $badge = 'bg-warning text-dark';
                                    } elseif ($status == 'Confirmed') {
                                        $badge = 'bg-success';
                                    } elseif ($status == 'Rejected') {
                                        $badge = 'bg-danger';
                                    } else {
                                        $badge = 'bg-secondary';
                                    }

                                    ?>

                                    <span class="badge <?php echo $badge; ?>">
                                        <?php echo htmlspecialchars($status); ?>
                                    </span>

                                </div>
                            </div>

                        </div>

                    </div>

                </div>

            </div>


            <!-- Customer Information -->

            <div class="card details-card shadow-sm mb-4">

                <div class="card-header-custom">

                    <h5 class="mb-0">
                        <i class='bx bx-user'></i>
                        Customer Information
                    </h5>

                </div>


                <div class="card-body">

                    <div class="row">

                        <div class="col-md-6">

                            <div class="detail-item">
                                <div class="detail-label">Customer Name</div>

                                <div class="detail-value">
                                    <?php echo htmlspecialchars($booking['full_name'] ?? 'Unknown'); ?>
                                </div>
                            </div>


                            <div class="detail-item">
                                <div class="detail-label">Email</div>

                                <div class="detail-value">
                                    <?php echo htmlspecialchars($booking['email'] ?? 'Not available'); ?>
                                </div>
                            </div>

                        </div>


                        <div class="col-md-6">

                            <div class="detail-item">
                                <div class="detail-label">Phone</div>

                                <div class="detail-value">
                                    <?php echo htmlspecialchars($booking['phone'] ?? 'Not available'); ?>
                                </div>
                            </div>


                            <div class="detail-item">
                                <div class="detail-label">Address</div>

                                <div class="detail-value">
                                    <?php echo htmlspecialchars($booking['address'] ?? 'Not available'); ?>
                                </div>
                            </div>

                        </div>

                    </div>

                </div>

            </div>


            <!-- Car Information -->

            <div class="card details-card shadow-sm mb-4">

                <div class="card-header-custom">

                    <h5 class="mb-0">
                        <i class='bx bx-car'></i>
                        Car Information
                    </h5>

                </div>


                <div class="card-body">

                    <div class="row align-items-center">

                        <div class="col-md-5">

                            <?php if (!empty($booking['featured_image'])) { ?>

                                <img
                                    src="../uploads/cars/<?php echo htmlspecialchars($booking['featured_image']); ?>"
                                    class="car-image"
                                    alt="Car Image">

                            <?php } else { ?>

                                <p class="text-muted">No car image available.</p>

                            <?php } ?>

                        </div>


                        <div class="col-md-7">

                            <div class="detail-item">
                                <div class="detail-label">Car Model</div>

                                <div class="detail-value">
                                    <?php echo htmlspecialchars($booking['model_name'] ?? 'Unknown'); ?>
                                </div>
                            </div>


                            <div class="detail-item">
                                <div class="detail-label">Brand</div>

                                <div class="detail-value">
                                    <?php echo htmlspecialchars($booking['brand_name'] ?? 'Unknown'); ?>
                                </div>
                            </div>


                            <div class="detail-item">
                                <div class="detail-label">Category</div>

                                <div class="detail-value">
                                    <?php echo htmlspecialchars($booking['category_name'] ?? 'Unknown'); ?>
                                </div>
                            </div>


                            <div class="detail-item">
                                <div class="detail-label">Year</div>

                                <div class="detail-value">
                                    <?php echo htmlspecialchars($booking['year'] ?? ''); ?>
                                </div>
                            </div>


                            <div class="detail-item">
                                <div class="detail-label">License Plate</div>

                                <div class="detail-value">
                                    <?php echo htmlspecialchars($booking['license_plate'] ?? ''); ?>
                                </div>
                            </div>


                            <div class="detail-item">
                                <div class="detail-label">Daily Rent</div>

                                <div class="detail-value">
                                    ৳<?php echo number_format($booking['daily_rate'], 2); ?>
                                </div>
                            </div>

                        </div>

                    </div>

                </div>

            </div>


            <!-- Special Requests -->

            <div class="card details-card shadow-sm mb-4">

                <div class="card-header-custom">

                    <h5 class="mb-0">
                        <i class='bx bx-message-detail'></i>
                        Special Requests
                    </h5>

                </div>


                <div class="card-body">

                    <?php if (!empty($booking['special_requests'])) { ?>

                        <?php echo nl2br(htmlspecialchars($booking['special_requests'])); ?>

                    <?php } else { ?>

                        <p class="text-muted mb-0">
                            No special requests.
                        </p>

                    <?php } ?>

                </div>

            </div>


            <a href="bookings.php" class="btn btn-secondary">
                <i class='bx bx-arrow-back'></i>
                Back to Bookings
            </a>


        </div>

    </div>

</body>

</html>
