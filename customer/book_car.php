
<?php

session_start();

require_once "../config/dbconfig.php";

// Check Customer Login
if (!isset($_SESSION['user_id']) || $_SESSION['role_name'] != "Customer") {
    header("Location: ../auth/login.php");
    exit;
}

// Check Car ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: ../frontend/cars.php");
    exit;
}

$car_id = (int) $_GET['id'];

// Get Car Details
$sql = "SELECT cars.*, brands.brand_name
        FROM cars
        LEFT JOIN brands ON cars.brand_id = brands.brand_id
        WHERE cars.car_id = $car_id";

$result = mysqli_query($conn, $sql);

if (!$result || mysqli_num_rows($result) == 0) {
    die("Car Not Found!");
}

$car = mysqli_fetch_assoc($result);

// Check Car Availability
if (strtolower(trim($car['status'])) != "available") {
    die("This Car is Not Available!");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Book Car - DriveGo</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">

    <link rel="stylesheet" href="../assets/css/frontend.css">

</head>

<body>

<div class="container py-5">

    <a href="../frontend/car_details.php?id=<?php echo $car_id; ?>"
       class="btn btn-outline-primary mb-4">

        <i class='bx bx-arrow-back'></i> Back to Car Details

    </a>

    <div class="row g-4">

        <!-- Car Information -->

        <div class="col-lg-5">

            <div class="card shadow-sm border-0 p-3">

                <?php if (!empty($car['featured_image'])) { ?>

                    <img
                        src="../uploads/cars/<?php echo htmlspecialchars($car['featured_image']); ?>"
                        class="img-fluid rounded mb-3"
                        style="height:250px; width:100%; object-fit:cover;"
                        alt="Car Image"
                    >

                <?php } ?>

                <h4 class="fw-bold">

                    <?php echo htmlspecialchars($car['brand_name'] ?? ''); ?>

                    <?php echo htmlspecialchars($car['model_name']); ?>

                </h4>

                <h5 class="text-primary">

                    ৳<?php echo number_format($car['daily_rate'], 2); ?> / Day

                </h5>

                <p class="text-muted mb-0">
                    Complete the form to book this car.
                </p>

            </div>

        </div>


        <!-- Booking Form -->

        <div class="col-lg-7">

            <div class="card shadow-sm border-0 p-4">

                <h3 class="fw-bold mb-4">Booking Information</h3>

                <form action="booking_process.php" method="POST">

                    <input type="hidden" name="car_id"
                           value="<?php echo $car_id; ?>">

                    <div class="mb-3">

                        <label class="form-label">Pickup Date & Time</label>

                        <input type="datetime-local"
                               name="pickup_date"
                               class="form-control"
                               required>

                    </div>

                    <div class="mb-3">

                        <label class="form-label">Return Date & Time</label>

                        <input type="datetime-local"
                               name="return_date"
                               class="form-control"
                               required>

                    </div>

                    <div class="mb-3">

                        <label class="form-label">Pickup Location</label>

                        <input type="text"
                               name="pickup_location"
                               class="form-control"
                               placeholder="Enter pickup location"
                               required>

                    </div>

                    <div class="mb-3">

                        <label class="form-label">Return Location</label>

                        <input type="text"
                               name="return_location"
                               class="form-control"
                               placeholder="Enter return location"
                               required>

                    </div>

                    <div class="mb-3">

                        <label class="form-label">Special Requests</label>

                        <textarea name="special_requests"
                                  class="form-control"
                                  rows="3"
                                  placeholder="Any special requirements?"></textarea>

                    </div>

                    <button type="submit" class="btn btn-primary btn-lg w-100">

                        Confirm Booking
                        <i class='bx bx-right-arrow-alt'></i>

                    </button>

                </form>

            </div>

        </div>

    </div>

</div>

</body>
</html>
