
<?php

require_once "../includes/auth_check.php";
require_once "../config/dbconfig.php";

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Add Staff - DriveGo</title>

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
        }

        .page-header {
            background: #142c50;
            color: white;
            padding: 18px 22px;
        }

    </style>

</head>

<body>

    <?php require_once "partials/sidebar.php"; ?>

    <div class="main-content">

        <div class="container-fluid">

            <div class="mb-4">
                <h3>Add New Staff</h3>
                <p class="text-muted">Create a new staff account for DriveGo.</p>
            </div>

            <div class="card page-card shadow-sm">

                <div class="page-header">

                    <h5 class="mb-0">
                        <i class='bx bx-user-plus'></i>
                        Staff Information
                    </h5>

                </div>

                <div class="card-body p-4">

                    <form action="save_staff.php" method="POST">

                        <div class="row">

                            <div class="col-md-6 mb-3">

                                <label class="form-label">Full Name</label>

                                <input
                                    type="text"
                                    name="full_name"
                                    class="form-control"
                                    placeholder="Enter staff name"
                                    required>

                            </div>

                            <div class="col-md-6 mb-3">

                                <label class="form-label">Email Address</label>

                                <input
                                    type="email"
                                    name="email"
                                    class="form-control"
                                    placeholder="Enter email address"
                                    required>

                            </div>

                            <div class="col-md-6 mb-3">

                                <label class="form-label">Phone Number</label>

                                <input
                                    type="text"
                                    name="phone"
                                    class="form-control"
                                    placeholder="Enter phone number"
                                    required>

                            </div>

                            <div class="col-md-6 mb-3">

                                <label class="form-label">Password</label>

                                <input
                                    type="password"
                                    name="password"
                                    class="form-control"
                                    placeholder="Enter password"
                                    minlength="6"
                                    required>

                            </div>

                            <div class="col-12 mb-3">

                                <label class="form-label">Address</label>

                                <textarea
                                    name="address"
                                    class="form-control"
                                    rows="3"
                                    placeholder="Enter staff address"
                                    required></textarea>

                            </div>

                        </div>

                        <hr>

                        <button type="submit" class="btn btn-primary">

                            <i class='bx bx-save'></i>
                            Save Staff

                        </button>

                        <a href="staff.php" class="btn btn-secondary">
                            Cancel
                        </a>

                    </form>

                </div>

            </div>

        </div>

    </div>

</body>

</html>
