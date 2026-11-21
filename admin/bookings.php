
<?php

require_once "../includes/auth_check.php";
require_once "../config/dbconfig.php";

// Update Booking Status
if (isset($_POST['update_status'])) {

    $booking_id = (int) $_POST['booking_id'];
    $new_status = $_POST['status'];

    // Allowed Status
    $allowed_status = ['Pending', 'Confirmed', 'Rejected', 'Cancelled'];

    if ($booking_id > 0 && in_array($new_status, $allowed_status)) {

        $update_sql = "UPDATE bookings
                       SET status = '$new_status'
                       WHERE booking_id = $booking_id";

        if (mysqli_query($conn, $update_sql)) {

            header("Location: bookings.php?updated=1");
            exit;

        } else {

            header("Location: bookings.php?error=1");
            exit;

        }

    }

    header("Location: bookings.php?error=1");
    exit;
}


// Search Booking
$search = "";

if (isset($_GET['search'])) {
    $search = mysqli_real_escape_string($conn, $_GET['search']);
}


// Filter Booking Status
$filter_status = "";

if (isset($_GET['status']) && $_GET['status'] != "") {
    $filter_status = mysqli_real_escape_string($conn, $_GET['status']);
}


// Get All Bookings
$sql = "SELECT bookings.*,
               users.full_name,
               users.email,
               cars.model_name,
               cars.featured_image

        FROM bookings

        LEFT JOIN users
        ON bookings.customer_id = users.user_id

        LEFT JOIN cars
        ON bookings.car_id = cars.car_id

        WHERE (
            bookings.booking_number LIKE '%$search%'
            OR users.full_name LIKE '%$search%'
            OR users.email LIKE '%$search%'
            OR cars.model_name LIKE '%$search%'
        )";


// Status Filter
if ($filter_status != "") {
    $sql .= " AND bookings.status = '$filter_status'";
}

$sql .= " ORDER BY bookings.booking_id DESC";

$result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Manage Bookings - DriveGo</title>

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

        .page-card {
            border: none;
            border-radius: 10px;
            overflow: hidden;
        }

        .page-header {
            background: #142c50;
            color: white;
            padding: 18px 22px;
        }

        .table th {
            white-space: nowrap;
        }

        .car-image {
            width: 75px;
            height: 50px;
            object-fit: cover;
            border-radius: 5px;
        }

        .status-form {
            min-width: 140px;
        }

    </style>

</head>

<body>

    <?php require_once "partials/sidebar.php"; ?>

    <div class="main-content">

        <div class="container-fluid">

            <!-- Page Heading -->

            <div class="d-flex justify-content-between align-items-center mb-4">

                <h3>Manage Bookings</h3>

                <span class="badge bg-primary fs-6">

                    Total Bookings:

                    <?php echo $result ? mysqli_num_rows($result) : 0; ?>

                </span>

            </div>


            <!-- Success Message -->

            <?php if (isset($_GET['updated'])) { ?>

                <div class="alert alert-success">
                    Booking Status Updated Successfully!
                </div>

            <?php } ?>


            <!-- Error Message -->

            <?php if (isset($_GET['error'])) { ?>

                <div class="alert alert-danger">
                    Unable to Update Booking Status!
                </div>

            <?php } ?>


            <div class="card page-card shadow-sm">

                <div class="page-header">

                    <h5 class="mb-0">

                        <i class='bx bx-calendar-check'></i>

                        All Bookings

                    </h5>

                </div>

                <div class="card-body">


                    <!-- Search and Filter -->

                    <form method="GET" class="row g-3 mb-4">

                        <div class="col-md-5">

                            <input
                                type="text"
                                name="search"
                                class="form-control"
                                placeholder="Search booking, customer or car..."
                                value="<?php echo htmlspecialchars($search); ?>">

                        </div>

                        <div class="col-md-3">

                            <select name="status" class="form-select">

                                <option value="">All Status</option>

                                <option value="Pending" <?php if ($filter_status == 'Pending') echo 'selected'; ?>>
                                    Pending
                                </option>

                                <option value="Confirmed" <?php if ($filter_status == 'Confirmed') echo 'selected'; ?>>
                                    Confirmed
                                </option>

                                <option value="Rejected" <?php if ($filter_status == 'Rejected') echo 'selected'; ?>>
                                    Rejected
                                </option>

                                <option value="Cancelled" <?php if ($filter_status == 'Cancelled') echo 'selected'; ?>>
                                    Cancelled
                                </option>

                            </select>

                        </div>

                        <div class="col-md-2">

                            <button type="submit" class="btn btn-primary w-100">

                                <i class='bx bx-search'></i>

                                Search

                            </button>

                        </div>

                        <div class="col-md-2">

                            <a href="bookings.php" class="btn btn-secondary w-100">
                                Reset
                            </a>

                        </div>

                    </form>


                    <!-- Booking Table -->

                    <div class="table-responsive">

                        <table class="table table-bordered table-hover align-middle">

                            <thead class="table-light">

                                <tr>

                                    <th>Booking No.</th>
                                    <th>Customer</th>
                                    <th>Car</th>
                                    <th>Pickup Date</th>
                                    <th>Return Date</th>
                                    <th>Total Amount</th>
                                    <th>Status</th>
                                    <th>Action</th>

                                </tr>

                            </thead>

                            <tbody>

                                <?php if ($result && mysqli_num_rows($result) > 0) { ?>

                                    <?php while ($booking = mysqli_fetch_assoc($result)) { ?>

                                        <tr>

                                            <td>
                                                <?php echo htmlspecialchars($booking['booking_number']); ?>
                                            </td>

                                            <td>

                                                <strong>
                                                    <?php echo htmlspecialchars($booking['full_name'] ?? 'Unknown'); ?>
                                                </strong>

                                                <br>

                                                <small class="text-muted">
                                                    <?php echo htmlspecialchars($booking['email'] ?? ''); ?>
                                                </small>

                                            </td>

                                            <td>

                                                <?php if (!empty($booking['featured_image'])) { ?>

                                                    <img
                                                        src="../uploads/cars/<?php echo htmlspecialchars($booking['featured_image']); ?>"
                                                        class="car-image"
                                                        alt="Car">

                                                <?php } ?>

                                                <br>

                                                <?php echo htmlspecialchars($booking['model_name'] ?? 'Unknown'); ?>

                                            </td>

                                            <td>
                                                <?php echo date('d M Y', strtotime($booking['pickup_date'])); ?>
                                            </td>

                                            <td>
                                                <?php echo date('d M Y', strtotime($booking['return_date'])); ?>
                                            </td>

                                            <td>
                                                ৳<?php echo number_format($booking['total_amount'], 2); ?>
                                            </td>


                                            <!-- Booking Status -->

                                            <td>

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

                                            </td>


                                            <!-- Action -->

                                            <td>

                                                <div class="d-flex flex-column gap-2">

                                                    <a
                                                        href="view_booking.php?id=<?php echo $booking['booking_id']; ?>"
                                                        class="btn btn-sm btn-primary">

                                                        <i class='bx bx-show'></i>

                                                        View

                                                    </a>


                                                    <!-- Update Status Form -->

                                                    <form method="POST" class="status-form">

                                                        <input
                                                            type="hidden"
                                                            name="booking_id"
                                                            value="<?php echo $booking['booking_id']; ?>">

                                                        <select
                                                            name="status"
                                                            class="form-select form-select-sm mb-2">

                                                            <option value="Pending"
                                                                <?php if ($status == 'Pending') echo 'selected'; ?>>
                                                                Pending
                                                            </option>

                                                            <option value="Confirmed"
                                                                <?php if ($status == 'Confirmed') echo 'selected'; ?>>
                                                                Confirmed
                                                            </option>

                                                            <option value="Rejected"
                                                                <?php if ($status == 'Rejected') echo 'selected'; ?>>
                                                                Rejected
                                                            </option>

                                                            <option value="Cancelled"
                                                                <?php if ($status == 'Cancelled') echo 'selected'; ?>>
                                                                Cancelled
                                                            </option>

                                                        </select>

                                                        <button
                                                            type="submit"
                                                            name="update_status"
                                                            class="btn btn-sm btn-success w-100"
                                                            onclick="return confirm('Are you sure you want to update this booking status?');">

                                                            Update Status

                                                        </button>

                                                    </form>

                                                </div>

                                            </td>

                                        </tr>

                                    <?php } ?>

                                <?php } else { ?>

                                    <tr>

                                        <td colspan="8" class="text-center text-muted py-4">
                                            No Bookings Found!
                                        </td>

                                    </tr>

                                <?php } ?>

                            </tbody>

                        </table>

                    </div>

                </div>

            </div>

        </div>

    </div>

</body>

</html>
