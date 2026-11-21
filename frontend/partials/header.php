
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>DriveGo - Car Rental</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Boxicons -->
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="../assets/css/frontend.css?v=3">

</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">

        <div class="container">

            <!-- Logo -->
            <a class="navbar-brand fw-bold fs-3" href="index.php">

                <i class='bx bxs-car'></i>
                DriveGo

            </a>


            <!-- Mobile Menu Button -->
            <button
                class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#mainNavbar"
                aria-controls="mainNavbar"
                aria-expanded="false"
                aria-label="Toggle navigation">

                <span class="navbar-toggler-icon"></span>

            </button>


            <!-- Navbar Links -->
            <div class="collapse navbar-collapse" id="mainNavbar">

                <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-3">

                    <li class="nav-item">

                        <a class="nav-link" href="index.php">
                            Home
                        </a>

                    </li>


                    <li class="nav-item">

                        <a class="nav-link" href="cars.php">
                            Our Cars
                        </a>

                    </li>


                    <li class="nav-item">

                        <a class="nav-link" href="about.php">
                            About Us
                        </a>

                    </li>


                    <li class="nav-item">

                        <a class="nav-link" href="contact.php">
                            Contact
                        </a>

                    </li>


                    <li class="nav-item">

                        <a href="../auth/login.php" class="btn btn-primary px-4">
                            Login
                        </a>

                    </li>

                </ul>

            </div>

        </div>

    </nav>
