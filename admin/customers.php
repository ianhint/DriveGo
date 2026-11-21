
<?php

require_once "../includes/auth_check.php";
require_once "../config/dbconfig.php";

// Get All Customers
$sql = "SELECT *
        FROM users
        WHERE role_id = 3
        ORDER BY user_id DESC";

$result = mysqli_query($conn, $sql);

// Total Customers
$total_customers = 0;

if ($result) {
    $total_customers = mysqli_num_rows($result);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Manage Customers - DriveGo</title>

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

    </style>

</head>

<body>

    <?php require_once "partials/sidebar.php"; ?>

    <div class="main-content">

        <div class="container-fluid">

            <!-- Page Heading -->
            <div class="d-flex justify-content-between align-items-center mb-4">

                <h3>Manage Customers</h3>

                <span class="badge bg-primary fs-6">
                    Total Customers: <?php echo $total_customers; ?>
                </span>

            </div>

            <!-- Customer Table -->
            <div class="card page-card shadow-sm">

                <div class="page-header">

                    <h5 class="mb-0">
                        <i class='bx bx-group'></i>
                        All Customers
                    </h5>

                </div>

                <div class="card-body">

                    <div class="table-responsive">

                        <table class="table table-bordered table-hover align-middle">

                            <thead class="table-light">

                                <tr>
                                    <th>ID</th>
                                    <th>Customer Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Address</th>
                                    <th>Status</th>
                                    <th>Joined Date</th>
                                </tr>

                            </thead>

                            <tbody>

                                <?php if ($result && mysqli_num_rows($result) > 0) { ?>

                                    <?php while ($customer = mysqli_fetch_assoc($result)) { ?>

                                        <tr>

                                            <td>
                                                <?php echo $customer['user_id']; ?>
                                            </td>

                                            <td>
                                                <strong>
                                                    <?php echo htmlspecialchars($customer['full_name'] ?? ''); ?>
                                                </strong>
                                            </td>

                                            <td>
                                                <?php echo htmlspecialchars($customer['email'] ?? ''); ?>
                                            </td>

                                            <td>
                                                <?php echo htmlspecialchars($customer['phone'] ?? ''); ?>
                                            </td>

                                            <td>
                                                <?php echo htmlspecialchars($customer['address'] ?? ''); ?>
                                            </td>

                                            <td>

                                                <?php if ($customer['status'] == 'Active') { ?>

                                                    <span class="badge bg-success">
                                                        Active
                                                    </span>

                                                <?php } else { ?>

                                                    <span class="badge bg-secondary">
                                                        <?php echo htmlspecialchars($customer['status'] ?? 'Unknown'); ?>
                                                    </span>

                                                <?php } ?>

                                            </td>

                                            <td>
                                                <?php echo date('d M Y', strtotime($customer['created_at'])); ?>
                                            </td>

                                        </tr>

                                    <?php } ?>

                                <?php } else { ?>

                                    <tr>

                                        <td colspan="7" class="text-center text-muted py-4">
                                            No Customers Found!
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
