
<?php

require_once "../config/dbconfig.php";

// Search Value
$search = "";

if (isset($_GET['search'])) {
    $search = mysqli_real_escape_string($conn, $_GET['search']);
}

// Pickup and Return Date
$pickup_date = "";
$return_date = "";

if (isset($_GET['pickup_date'])) {
    $pickup_date = $_GET['pickup_date'];
}

if (isset($_GET['return_date'])) {
    $return_date = $_GET['return_date'];
}

$error = "";

// Check Date
if ($pickup_date != "" && $return_date != "") {

    if (strtotime($pickup_date) < strtotime(date("Y-m-d"))) {
        $error = "Pickup date cannot be in the past.";
    }
    elseif (strtotime($return_date) <= strtotime($pickup_date)) {
        $error = "Return date must be after pickup date.";
    }
}
elseif ($pickup_date != "" || $return_date != "") {
    $error = "Please select both pickup and return dates.";
}

// Base SQL
$sql = "SELECT cars.*,
               brands.brand_name,
               categories.category_name

        FROM cars

        LEFT JOIN brands
        ON cars.brand_id = brands.brand_id

        LEFT JOIN categories
        ON cars.category_id = categories.category_id

        WHERE cars.status = 'Available'";

// Search by Brand or Model
if ($search != "") {

    $sql .= " AND (
        cars.model_name LIKE '%$search%'
        OR brands.brand_name LIKE '%$search%'
    )";
}

// Check Booking Date Availability
if ($error == "" && $pickup_date != "" && $return_date != "") {

    $pickup_date = mysqli_real_escape_string($conn, $pickup_date);
    $return_date = mysqli_real_escape_string($conn, $return_date);

    $sql .= " AND cars.car_id NOT IN (

        SELECT car_id
        FROM bookings

        WHERE status IN ('Pending', 'Confirmed')

        AND NOT (
            return_date <= '$pickup_date'
            OR pickup_date >= '$return_date'
        )

    )";
}

// Latest Cars First
$sql .= " ORDER BY cars.car_id DESC";

// Get Cars
$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Database Error: " . mysqli_error($conn));
}

// Header
require_once "partials/header.php";

?>

<!-- Page Header -->
<section class="cars-page-header">
    <div class="container">
        <h1>Explore Our Cars</h1>
        <p>Find the perfect car for your journey</p>
    </div>
</section>


<!-- Search Section -->
<section class="container my-5">

    <form action="cars.php" method="GET" class="search-box">

        <div class="row g-3 align-items-end">

            <div class="col-md-4">
                <label>Search Car</label>
                <input
                    type="text"
                    name="search"
                    class="form-control"
                    placeholder="Brand or Model Name"
                    value="<?php echo htmlspecialchars($search); ?>"
                >
            </div>

            <div class="col-md-3">
                <label>Pickup Date</label>
                <input
                    type="date"
                    name="pickup_date"
                    class="form-control"
                    min="<?php echo date('Y-m-d'); ?>"
                    value="<?php echo htmlspecialchars($pickup_date); ?>"
                >
            </div>

            <div class="col-md-3">
                <label>Return Date</label>
                <input
                    type="date"
                    name="return_date"
                    class="form-control"
                    min="<?php echo date('Y-m-d'); ?>"
                    value="<?php echo htmlspecialchars($return_date); ?>"
                >
            </div>

            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">
                    Search
                </button>
            </div>

        </div>

    </form>

</section>


<!-- Cars Listing -->
<section class="cars-listing-section">

    <div class="container">

        <div class="section-heading">
            <h2>Our Available Cars</h2>
            <p>Choose your favorite car and enjoy your journey.</p>
        </div>

        <?php if ($error != "") { ?>

            <div class="alert alert-danger">
                <?php echo htmlspecialchars($error); ?>
            </div>

        <?php } else { ?>

            <div class="row g-4">

                <?php if (mysqli_num_rows($result) > 0) { ?>

                    <?php while ($car = mysqli_fetch_assoc($result)) { ?>

                        <div class="col-lg-4 col-md-6">

                            <div class="car-card">

                                <div class="car-image">

                                    <img
                                        src="../uploads/cars/<?php echo htmlspecialchars($car['featured_image']); ?>"
                                        alt="<?php echo htmlspecialchars($car['model_name']); ?>"
                                    >

                                </div>

                                <div class="car-info">

                                    <h3>
                                        <?php echo htmlspecialchars($car['brand_name'] . " " . $car['model_name']); ?>
                                    </h3>

                                    <p>
                                        <?php echo htmlspecialchars($car['category_name']); ?>
                                    </p>

                                    <div class="car-details">

                                        <span>
                                            <?php echo htmlspecialchars($car['year']); ?>
                                        </span>

                                        <span>
                                            <?php echo htmlspecialchars($car['seating_capacity']); ?> Seats
                                        </span>

                                        <span>
                                            <?php echo htmlspecialchars($car['fuel_type']); ?>
                                        </span>

                                        <span>
                                            <?php echo htmlspecialchars($car['transmission']); ?>
                                        </span>

                                    </div>

                                    <div class="car-card-footer">

                                        <div class="car-price">
                                            ৳<?php echo number_format($car['daily_rate']); ?>
                                            <small>/ Day</small>
                                        </div>

                                        <a
                                            href="car_details.php?id=<?php echo $car['car_id']; ?>"
                                            class="btn btn-primary"
                                        >
                                            View Details
                                        </a>

                                    </div>

                                </div>

                            </div>

                        </div>

                    <?php } ?>

                <?php } else { ?>

                    <div class="col-12 text-center">

                        <h4>No Cars Found!</h4>

                        <p>
                            No available cars match your search.
                            Please try another search.
                        </p>

                        <a href="cars.php" class="btn btn-primary">
                            View All Cars
                        </a>

                    </div>

                <?php } ?>

            </div>

        <?php } ?>

    </div>

</section>


<?php

require_once "partials/footer.php";

?>
