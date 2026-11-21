
<?php

session_start();

require_once "../config/dbconfig.php";

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Create Account - DriveGo</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">

    <link rel="stylesheet" href="../assets/css/frontend.css">

</head>

<body>

<section class="login-page">

    <div class="login-container">

        <div class="login-card">

            <div class="text-center mb-4">

                <i class='bx bx-car' style="font-size: 55px; color: #f97316;"></i>

                <h2 class="fw-bold mt-2">Create Account</h2>

                <p class="text-muted">
                    Register to book your favorite car
                </p>

            </div>

            <form action="register_process.php" method="POST">

                <div class="mb-3">

                    <label class="form-label">Full Name</label>

                    <input type="text"
                           name="full_name"
                           class="form-control"
                           placeholder="Enter your full name"
                           required>

                </div>

                <div class="mb-3">

                    <label class="form-label">Email Address</label>

                    <input type="email"
                           name="email"
                           class="form-control"
                           placeholder="Enter your email"
                           required>

                </div>

                <div class="mb-3">

                    <label class="form-label">Phone Number</label>

                    <input type="text"
                           name="phone"
                           class="form-control"
                           placeholder="Enter your phone number"
                           required>

                </div>

                <div class="mb-3">

                    <label class="form-label">Address</label>

                    <textarea name="address"
                              class="form-control"
                              rows="2"
                              placeholder="Enter your address"
                              required></textarea>

                </div>

                <div class="mb-3">

                    <label class="form-label">Password</label>

                    <input type="password"
                           name="password"
                           class="form-control"
                           placeholder="Create a password"
                           required>

                </div>

                <div class="mb-3">

                    <label class="form-label">Confirm Password</label>

                    <input type="password"
                           name="confirm_password"
                           class="form-control"
                           placeholder="Confirm your password"
                           required>

                </div>

                <button type="submit" class="btn btn-primary w-100 mt-3">

                    Create Account

                    <i class='bx bx-right-arrow-alt'></i>

                </button>

            </form>

            <p class="text-center mt-4 mb-0">

                Already have an account?

                <a href="login.php">Login Here</a>

            </p>

        </div>

    </div>

</section>

</body>
</html>
