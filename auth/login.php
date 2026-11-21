
<?php

session_start();

// If Already Logged In
if (isset($_SESSION['user_id'])) {

    if ($_SESSION['role_name'] == "Admin") {
        header("Location: ../admin/dashboard.php");
        exit;
    }

    elseif ($_SESSION['role_name'] == "Staff") {
        header("Location: ../staff/dashboard.php");
        exit;
    }

    else {
        header("Location: ../customer/dashboard.php");
        exit;
    }

}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login - DriveGo</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Boxicons -->
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">

    <!-- Frontend CSS -->
    <link rel="stylesheet" href="../assets/css/frontend.css">

</head>

<body class="login-page">


<div class="login-container">

    <div class="login-card">

        <!-- Logo -->

        <div class="login-logo">

            <a href="../frontend/index.php">
                Drive<span>Go</span>
            </a>

        </div>


        <!-- Heading -->

        <div class="login-heading">

            <h2>Welcome Back!</h2>

            <p>Login to continue your journey with DriveGo.</p>

        </div>


        <!-- Login Form -->

        <form action="login_process.php" method="POST">

            <div class="mb-3">

                <label>Email Address</label>

                <div class="login-input">

                    <i class='bx bx-envelope'></i>

                    <input
                        type="email"
                        name="email"
                        placeholder="Enter your email"
                        required
                    >

                </div>

            </div>


            <div class="mb-3">

                <label>Password</label>

                <div class="login-input">

                    <i class='bx bx-lock-alt'></i>

                    <input
                        type="password"
                        name="password"
                        placeholder="Enter your password"
                        required
                    >

                </div>

            </div>


            <button type="submit" class="login-submit-btn">

                Login

                <i class='bx bx-right-arrow-alt'></i>

            </button>

        </form>


        <!-- Back to Home -->

        <div class="login-footer">

            <p>
                Don't have an account?
                <a href="register.php">Create Account</a>
            </p>

            <a href="../frontend/index.php" class="back-home">
                <i class='bx bx-arrow-back'></i>
                Back to Home
            </a>

        </div>

    </div>

</div>


</body>

</html>
