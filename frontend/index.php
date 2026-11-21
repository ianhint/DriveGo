
<?php

require_once "../config/dbconfig.php";
require_once "partials/header.php";

// Get Featured Cars
$sql = "SELECT cars.*,
               brands.brand_name,
               categories.category_name

        FROM cars

        LEFT JOIN brands
        ON cars.brand_id = brands.brand_id

        LEFT JOIN categories
        ON cars.category_id = categories.category_id

        WHERE cars.status = 'Available'

        ORDER BY cars.car_id DESC
        LIMIT 6";

$result = mysqli_query($conn, $sql);

?>

<!-- Hero Section -->
<section class="hero-section">

    <div class="container">

        <div class="row align-items-center">

            <div class="col-lg-7">

                <span class="hero-tag">
                    YOUR JOURNEY STARTS HERE
                </span>

                <h1>
                    Find Your Perfect Car
                    <span>For Every Journey</span>
                </h1>

                <p>
                    Explore our collection of quality cars and enjoy
                    a comfortable, reliable and affordable rental experience.
                </p>

                <div class="mt-4">

                    <a href="cars.php" class="btn btn-primary btn-lg px-4">
                        Explore Cars
                        <i class='bx bx-right-arrow-alt'></i>
                    </a>

                    <a href="about.php" class="btn btn-outline-light btn-lg px-4 ms-2">
                        Learn More
                    </a>

                </div>

            </div>

        </div>

    </div>

</section>


<!-- Search Section -->
<section class="search-section">

    <div class="container">

        <div class="search-box shadow">

            <h4 class="mb-4">Find Your Rental Car</h4>

            <form action="cars.php" method="GET">

                <div class="row g-3">

                    <div class="col-md-4">

                        <label class="form-label">Car Model</label>

                        <input
                            type="text"
                            name="search"
                            class="form-control"
                            placeholder="Search car model">

                    </div>

                    <div class="col-md-4">

                        <label class="form-label">Pickup Date</label>

                        <input
                            type="date"
                            name="pickup_date"
                            class="form-control">

                    </div>

                    <div class="col-md-4">

                        <label class="form-label">Return Date</label>

                        <input
                            type="date"
                            name="return_date"
                            class="form-control">

                    </div>

                    <div class="col-12 text-end">

                        <button type="submit" class="btn btn-primary px-5">

                            <i class='bx bx-search'></i>
                            Search Cars

                        </button>

                    </div>

                </div>

            </form>

        </div>

    </div>

</section>


<!-- Featured Cars -->
<section class="featured-section">

    <div class="container">

        <div class="section-heading text-center">

            <span>OUR COLLECTION</span>

            <h2>Featured Cars</h2>

            <p>
                Choose from our collection of comfortable and reliable vehicles.
            </p>

        </div>

        <div class="row g-4">

            <?php if ($result && mysqli_num_rows($result) > 0) { ?>

                <?php while ($car = mysqli_fetch_assoc($result)) { ?>

                    <div class="col-md-6 col-lg-4">

                        <div class="car-card">

                            <?php if (!empty($car['featured_image'])) { ?>

                                <img
                                    src="../uploads/cars/<?php echo htmlspecialchars($car['featured_image']); ?>"
                                    alt="Car Image"
                                    class="car-card-image">

                            <?php } else { ?>

                                <div class="car-image-placeholder">
                                    <i class='bx bx-car'></i>
                                </div>

                            <?php } ?>

                            <div class="car-card-body">

                                <span class="car-category">
                                    <?php echo htmlspecialchars($car['category_name'] ?? 'Car'); ?>
                                </span>

                                <h5>
                                    <?php echo htmlspecialchars($car['brand_name'] ?? ''); ?>
                                    <?php echo htmlspecialchars($car['model_name']); ?>
                                </h5>

                                <div class="car-info">

                                    <span>
                                        <i class='bx bx-calendar'></i>
                                        <?php echo htmlspecialchars($car['year']); ?>
                                    </span>

                                    <span>
                                        <i class='bx bx-user'></i>
                                        <?php echo htmlspecialchars($car['seating_capacity']); ?> Seats
                                    </span>

                                    <span>
                                        <i class='bx bx-gas-pump'></i>
                                        <?php echo htmlspecialchars($car['fuel_type']); ?>
                                    </span>

                                </div>

                                <div class="car-card-footer">

                                    <div>
                                        <strong>
                                            ৳<?php echo number_format($car['daily_rate'], 2); ?>
                                        </strong>
                                        <small>/ Day</small>
                                    </div>

                                    <a
                                        href="car_details.php?id=<?php echo $car['car_id']; ?>"
                                        class="btn btn-primary btn-sm">

                                        View Details

                                    </a>

                                </div>

                            </div>

                        </div>

                    </div>

                <?php } ?>

            <?php } else { ?>

                <div class="col-12 text-center">

                    <p class="text-muted">
                        No available cars found!
                    </p>

                </div>

            <?php } ?>

        </div>

        <div class="text-center mt-5">

            <a href="cars.php" class="btn btn-outline-primary btn-lg">
                View All Cars
                <i class='bx bx-right-arrow-alt'></i>
            </a>

        </div>

    </div>

</section>


<!-- Why Choose Us -->
<section class="why-section">

    <div class="container">

        <div class="section-heading text-center">

            <span>WHY DRIVEGO</span>

            <h2>Why Choose Us?</h2>

            <p>
                We make your journey easier, safer and more comfortable.
            </p>

        </div>

        <div class="row g-4">

            <div class="col-md-4">

                <div class="why-card">

                    <i class='bx bx-car'></i>

                    <h5>Quality Vehicles</h5>

                    <p>
                        Choose from our collection of well-maintained vehicles.
                    </p>

                </div>

            </div>

            <div class="col-md-4">

                <div class="why-card">

                    <i class='bx bx-wallet'></i>

                    <h5>Affordable Pricing</h5>

                    <p>
                        Enjoy reliable car rental services at reasonable prices.
                    </p>

                </div>

            </div>

            <div class="col-md-4">

                <div class="why-card">

                    <i class='bx bx-support'></i>

                    <h5>Customer Support</h5>

                    <p>
                        Our team is here to help you throughout your journey.
                    </p>

                </div>

            </div>

        </div>

    </div>

</section>


<!-- Call To Action -->
<section class="cta-section">

    <div class="container text-center">

        <h2>Ready For Your Next Journey?</h2>

        <p>
            Find your perfect car and start your journey with DriveGo today.
        </p>

        <a href="cars.php" class="btn btn-primary btn-lg px-5">
            Book Your Car
        </a>

    </div>

</section>


<?php require_once "partials/footer.php"; ?>
