
<?php

require_once "../includes/auth_check.php";
require_once "../config/dbconfig.php";

// Check POST Request
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $booking_id = (int) $_POST['booking_id'];
    $status = $_POST['status'];

    // Allow Only Confirmed or Rejected
    if ($status == 'Confirmed' || $status == 'Rejected') {

        // Check Current Booking Status
        $check_sql = "SELECT status FROM bookings WHERE booking_id = $booking_id";
        $check_result = mysqli_query($conn, $check_sql);

        if ($check_result && mysqli_num_rows($check_result) > 0) {

            $booking = mysqli_fetch_assoc($check_result);

            if ($booking['status'] == 'Pending') {

                $update_sql = "UPDATE bookings
                               SET status = '$status'
                               WHERE booking_id = $booking_id";

                if (mysqli_query($conn, $update_sql)) {

                    header("Location: view_booking.php?id=$booking_id&message=success");
                    exit();

                } else {

                    header("Location: view_booking.php?id=$booking_id&message=error");
                    exit();
                }

            } else {

                header("Location: view_booking.php?id=$booking_id&message=invalid");
                exit();
            }

        } else {

            die("Booking not found!");
        }

    } else {

        die("Invalid booking status!");
    }

} else {

    header("Location: bookings.php");
    exit();
}

?>
