
<?php

session_start();

require_once "../config/dbconfig.php";

// Check Customer Login
if (!isset($_SESSION['user_id']) || $_SESSION['role_name'] != "Customer") {
    header("Location: ../auth/login.php");
    exit;
}

// Check Form Submission
if ($_SERVER["REQUEST_METHOD"] != "POST") {
    header("Location: ../frontend/cars.php");
    exit;
}

// Get Form Data
$customer_id = (int) $_SESSION['user_id'];
$car_id = (int) $_POST['car_id'];

$pickup_date = mysqli_real_escape_string($conn, $_POST['pickup_date']);
$return_date = mysqli_real_escape_string($conn, $_POST['return_date']);

$pickup_location = mysqli_real_escape_string($conn, trim($_POST['pickup_location']));
$return_location = mysqli_real_escape_string($conn, trim($_POST['return_location']));

$special_requests = mysqli_real_escape_string($conn, trim($_POST['special_requests']));

// Check Date
$pickup_timestamp = strtotime($pickup_date);
$return_timestamp = strtotime($return_date);

if (!$pickup_timestamp || !$return_timestamp || $pickup_timestamp <= time() || $return_timestamp <= $pickup_timestamp) {
    die("Invalid Booking Dates! <a href='javascript:history.back()'>Go Back</a>");
}

// Calculate Total Days
$total_days = ceil(($return_timestamp - $pickup_timestamp) / 86400);

// Get Car Details
$car_sql = "SELECT * FROM cars WHERE car_id = $car_id";
$car_result = mysqli_query($conn, $car_sql);

if (!$car_result || mysqli_num_rows($car_result) == 0) {
    die("Car Not Found!");
}

$car = mysqli_fetch_assoc($car_result);

// Check Car Availability
if (strtolower(trim($car['status'])) != "available") {
    die("This Car is Not Available!");
}   

// Calculate Total Amount
$total_amount = $total_days * $car['daily_rate'];

// Check Existing Booking
$check_sql = "SELECT * FROM bookings
              WHERE car_id = $car_id
              AND status IN ('Pending', 'Confirmed')
              AND pickup_date < '$return_date'
              AND return_date > '$pickup_date'";

$check_result = mysqli_query($conn, $check_sql);

if (mysqli_num_rows($check_result) > 0) {
    die("Sorry! This Car is Already Booked for Selected Dates.");
}

// Generate Booking Number
$booking_number = "DG" . date("YmdHis") . rand(100, 999);

// Booking Status
$status = "Pending";

// Insert Booking
$sql = "INSERT INTO bookings
        (
            booking_number,
            customer_id,
            car_id,
            pickup_date,
            return_date,
            pickup_location,
            return_location,
            total_days,
            total_amount,
            status,
            special_requests
        )

        VALUES
        (
            '$booking_number',
            $customer_id,
            $car_id,
            '$pickup_date',
            '$return_date',
            '$pickup_location',
            '$return_location',
            $total_days,
            $total_amount,
            '$status',
            '$special_requests'
        )";

$result = mysqli_query($conn, $sql);

if ($result) {

    header("Location: my_bookings.php?success=1");
    exit;

} else {

    echo "Booking Failed: " . mysqli_error($conn);

}

?>
