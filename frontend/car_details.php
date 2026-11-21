
<?php

session_start();


require_once "../config/dbconfig.php";

// Get Car ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: cars.php");
    exit;
}

$car_id = (int) $_GET['id'];

// Get Car Details
$sql = "SELECT cars.*,
               brands.brand_name,
               categories.category_name
        FROM cars
        LEFT JOIN brands
        ON cars.brand_id = brands.brand_id
        LEFT JOIN categories
        ON cars.category_id = categories.category_id
        WHERE cars.car_id = $car_id";

$result = mysqli_query($conn, $sql);

if (!$result || mysqli_num_rows($result) == 0) {
    require_once "partials/header.php";

    echo '<div class="container text-center py-5">
            <h2>Car Not Found!</h2>
            <a href="cars.php" class="btn btn-primary mt-3">
                Back to Cars
            </a>
          </div>';

    require_once "partials/footer.php";
    exit;
}

$car = mysqli_fetch_assoc($result);

require_once "partials/header.php";

?>

<!-- Car Details Section -->

<section class="car-details-section">

    <div class="container">

        <a href="cars.php" class="back-link">
            <i class='bx bx-arrow-back'></i> Back to Cars
        </a>

        <div class="row g-5 mt-2">

            <!-- Car Image -->

            <div class="col-lg-7">

                <?php if (!empty($car['featured_image'])) { ?>

                    <img
                        src="../uploads/cars/<?php echo htmlspecialchars($car['featured_image']); ?>"
                        class="details-main-image"
                        alt="Car Image"
                    >

                <?php } else { ?>

                    <div class="details-image-placeholder">
                        <i class='bx bx-car'></i>
                    </div>

                <?php } ?>

            </div>

            <!-- Car Information -->

            <div class="col-lg-5">

                <span class="car-category">
                    <?php echo htmlspecialchars($car['category_name'] ?? 'Car'); ?>
                </span>

                <h2 class="details-car-title">
                    <?php echo htmlspecialchars($car['brand_name'] ?? ''); ?>
                    <?php echo htmlspecialchars($car['model_name']); ?>
                </h2>

                <h3 class="details-price">
                    ৳<?php echo number_format($car['daily_rate'], 2); ?>
                    <small>/ Day</small>
                </h3>

                <p class="text-muted mt-3">
                    Enjoy a comfortable and reliable journey with this vehicle.
                </p>

                <!-- Car Specifications -->

                <div class="details-info-box">

                    <div>
                        <span>Brand</span>
                        <strong>
                            <?php echo htmlspecialchars($car['brand_name'] ?? 'N/A'); ?>
                        </strong>
                    </div>

                    <div>
                        <span>Model</span>
                        <strong>
                            <?php echo htmlspecialchars($car['model_name']); ?>
                        </strong>
                    </div>

                    <div>
                        <span>Year</span>
                        <strong>
                            <?php echo htmlspecialchars($car['year']); ?>
                        </strong>
                    </div>

                    <div>
                        <span>Seating Capacity</span>
                        <strong>
                            <?php echo htmlspecialchars($car['seating_capacity']); ?> Seats
                        </strong>
                    </div>

                    <div>
                        <span>Fuel Type</span>
                        <strong>
                            <?php echo htmlspecialchars($car['fuel_type']); ?>
                        </strong>
                    </div>

                    <div>
                        <span>Transmission</span>
                        <strong>
                            <?php echo htmlspecialchars($car['transmission']); ?>
                        </strong>
                    </div>

                    <div>
                        <span>Category</span>
                        <strong>
                            <?php echo htmlspecialchars($car['category_name'] ?? 'N/A'); ?>
                        </strong>
                    </div>

                    <div>
                        <span>Availability</span>
                        <strong>
                            <?php echo htmlspecialchars($car['status']); ?>
                        </strong>
                    </div>

                </div>

                <!-- Book Button -->

               
<?php if (isset($_SESSION['user_id']) && $_SESSION['role_name'] == "Customer") { ?>

    <a href="../customer/book_car.php?id=<?php echo $car['car_id']; ?>"
       class="btn btn-primary btn-lg w-100 mt-4">

        Book This Car
        <i class='bx bx-right-arrow-alt'></i>

    </a>

<?php } else { ?>

    <a href="http://localhost/project/DriveGo/auth/login.php"
       class="btn btn-primary btn-lg w-100 mt-4">

        Login to Book This Car
        <i class='bx bx-right-arrow-alt'></i>

    </a>

<?php } ?>


            </div>

        </div>

    </div>

</section>

<?php require_once "partials/footer.php"; ?>
