
<?php

// Admin Authentication
require_once "../includes/auth_check.php";

// Database Connection
require_once "../config/dbconfig.php";

// Functions File
require_once "../includes/functions.php";

// Admin Name
$admin_name = $_SESSION['user_name'];

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>DriveGo Admin Dashboard</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Boxicons -->
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/css/custom.css">

    <style>

        body {
            background: #f4f6fa;
            margin: 0;
        }

        /* Sidebar Position */
        .sidebar-wrapper {
            width: 250px;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            overflow-y: auto;
            overflow-x: hidden;
            z-index: 1000;
        }

        /* Main Content */
        .main-content {
            margin-left: 250px;
            padding: 30px;
        }

        /* Top Header */
        .top-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }

        /* Admin Profile */
        .admin-profile {
            display: flex;
            align-items: center;
            gap: 10px;
            background: #ffffff;
            padding: 8px 15px;
            border-radius: 30px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            cursor: pointer;
        }

        /* Profile Avatar */
        .profile-avatar {
            width: 38px;
            height: 38px;
            background: #14213d;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 17px;
        }

        .admin-name {
            font-weight: 600;
            font-size: 14px;
            color: #333;
        }

        /* Dropdown */
        .dropdown-menu {
            border: none;
            box-shadow: 0 4px 15px rgba(0,0,0,0.12);
            border-radius: 10px;
            padding: 8px;
        }

        .dropdown-item {
            padding: 10px;
            border-radius: 6px;
        }

        .dropdown-item:hover {
            background: #f1f3f8;
        }

        /* Dashboard Cards */
        .dashboard-card {
            border: none;
            border-radius: 10px;
            padding: 20px;
        }

        /* Responsive */
        @media (max-width: 768px) {

            .main-content {
                margin-left: 0;
                padding: 20px;
            }

        }

    </style>

</head>

<body>

    <!-- Sidebar -->
    <?php require_once "partials/sidebar.php"; ?>


    <!-- Main Content -->

    <div class="main-content">

        <!-- Top Header -->

        <div class="top-header">

            <div>
                <h2 class="mb-1">Dashboard</h2>

                <p class="text-muted mb-0">
                    Welcome to DriveGo Admin Panel
                </p>
            </div>


            <!-- Admin Profile -->

            <div class="dropdown">

                <div class="admin-profile"
                     data-bs-toggle="dropdown"
                     aria-expanded="false">

                    <div class="profile-avatar">

                        <?php echo strtoupper(substr($admin_name, 0, 1)); ?>

                    </div>

                    <span class="admin-name">

                        <?php echo htmlspecialchars($admin_name); ?>

                    </span>

                    <i class='bx bx-chevron-down'></i>

                </div>


                <!-- Profile Dropdown Menu -->

                <ul class="dropdown-menu dropdown-menu-end">

                    <li>
                        <h6 class="dropdown-header">
                            Admin Account
                        </h6>
                    </li>

                    <li>
                        <a class="dropdown-item" href="profile.php">

                            <i class='bx bx-user me-2'></i>
                            My Profile

                        </a>
                    </li>

                    <li><hr class="dropdown-divider"></li>

                    <li>
                        <a class="dropdown-item text-danger"
                           href="../logout.php">

                            <i class='bx bx-log-out me-2'></i>
                            Logout

                        </a>
                    </li>

                </ul>

            </div>

        </div>


        <!-- Dashboard Statistics -->

        <div class="row mt-4">

            <div class="col-md-4 mb-3">

                <div class="card dashboard-card shadow-sm">

                    <h5>Total Cars</h5>
                    <h2>3</h2>

                </div>

            </div>


            <div class="col-md-4 mb-3">

                <div class="card dashboard-card shadow-sm">

                    <h5>Total Bookings</h5>
                    <h2>2</h2>

                </div>

            </div>


            <div class="col-md-4 mb-3">

                <div class="card dashboard-card shadow-sm">

                    <h5>Total Users</h5>
                    <h2>4</h2>

                </div>

            </div>

        </div>


        <!-- Welcome Card -->

        <div class="card dashboard-card shadow-sm mt-3">

            <h4>Welcome to DriveGo Admin Panel</h4>

            <p>
                Manage your cars, bookings, customers and other activities
                from this dashboard.
            </p>

        </div>

    </div>


    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
