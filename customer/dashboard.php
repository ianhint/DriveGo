
<?php

session_start();

// Check Customer Login
if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit;
}

// Check Customer Role
if ($_SESSION['role_name'] != "Customer") {
    header("Location: ../auth/login.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Customer Dashboard - DriveGo</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">

    <link rel="stylesheet" href="../assets/css/frontend.css">

</head>

<body>

    <div class="container py-5">

        <div class="d-flex justify-content-between align-items-center mb-5">

            <div>
                <h2 class="fw-bold">Customer Dashboard</h2>

                <p class="text-muted">
                    Welcome to DriveGo!
                </p>
            </div>

            <a href="../auth/logout.php" class="btn btn-danger">
                Logout
                <i class='bx bx-log-out'></i>
            </a>

        </div>

        <div class="card shadow-sm p-4">

            <h4>
                Hello, <?php echo htmlspecialchars($_SESSION['user_name']); ?>!
            </h4>

            <p class="text-muted mb-0">
                Your account login was successful.
                Welcome to your DriveGo Customer Dashboard.
            </p>

        </div>

        <div class="row g-4 mt-3">

            <div class="col-md-4">

                <div class="card shadow-sm p-4 h-100">

                    <i class='bx bx-car fs-1 text-primary'></i>

                    <h5 class="mt-3">Explore Cars</h5>

                    <p>Find your favorite rental car.</p>

                    <a href="../frontend/cars.php" class="btn btn-primary">
                        View Cars
                    </a>

                </div>

            </div>

            <div class="col-md-4">

                <div class="card shadow-sm p-4 h-100">

                    <i class='bx bx-calendar-check fs-1 text-primary'></i>

                    <h5 class="mt-3">My Bookings</h5>

                    <p>Check your car booking details.</p>

                    <a href="my_bookings.php" class="btn btn-primary">
                        My Bookings
                    </a>

                </div>

            </div>

            <div class="col-md-4">

                <div class="card shadow-sm p-4 h-100">

                    <i class='bx bx-user fs-1 text-primary'></i>

                    <h5 class="mt-3">My Profile</h5>

                    <p>View your personal information.</p>

                    <a href="profile.php" class="btn btn-primary">
                        My Profile
                    </a>

                </div>

            </div>

        </div>

    </div>

</body>

</html>
