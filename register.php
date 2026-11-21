
<?php
// DriveGo Registration Page
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>DriveGo - Register</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body class="bg-light">

    <div class="container mt-5">

        <div class="row justify-content-center">

            <div class="col-md-6">

                <div class="card shadow">

                    <div class="card-header text-center bg-primary text-white">
                        <h3>DriveGo Registration</h3>
                    </div>

                    <div class="card-body">

                        <!-- Registration Form -->
                        <form action="auth/register_process.php" method="POST">

                            <!-- Full Name -->
                            <div class="mb-3">
                                <label class="form-label">Full Name</label>

                                <input type="text"
                                       name="full_name"
                                       class="form-control"
                                       placeholder="Enter your full name"
                                       required>
                            </div>

                            <!-- Email -->
                            <div class="mb-3">
                                <label class="form-label">Email Address</label>

                                <input type="email"
                                       name="email"
                                       class="form-control"
                                       placeholder="Enter your email"
                                       required>
                            </div>

                            <!-- Phone -->
                            <div class="mb-3">
                                <label class="form-label">Phone Number</label>

                                <input type="text"
                                       name="phone"
                                       class="form-control"
                                       placeholder="Enter your phone number">
                            </div>

                            <!-- Address -->
                            <div class="mb-3">
                                <label class="form-label">Address</label>

                                <textarea name="address"
                                          class="form-control"
                                          rows="3"
                                          placeholder="Enter your address"></textarea>
                            </div>

                            <!-- Password -->
                            <div class="mb-3">
                                <label class="form-label">Password</label>

                                <input type="password"
                                       name="password"
                                       class="form-control"
                                       placeholder="Enter password"
                                       minlength="6"
                                       required>
                            </div>

                            <!-- Confirm Password -->
                            <div class="mb-3">
                                <label class="form-label">Confirm Password</label>

                                <input type="password"
                                       name="confirm_password"
                                       class="form-control"
                                       placeholder="Confirm your password"
                                       required>
                            </div>

                            <!-- Submit Button -->
                            <div class="d-grid">

                                <button type="submit"
                                        name="register"
                                        class="btn btn-primary">
                                    Register
                                </button>

                            </div>

                        </form>

                        <p class="text-center mt-3">
                            Already have an account?
                            <a href="login.php">Login Here</a>
                        </p>

                    </div>

                </div>

            </div>

        </div>

    </div>

</body>
</html>
