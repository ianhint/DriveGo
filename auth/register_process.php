
<?php

require_once "../config/dbconfig.php";

// Check Form Submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Get Form Data
    $full_name = mysqli_real_escape_string($conn, trim($_POST['full_name']));
    $email = mysqli_real_escape_string($conn, trim($_POST['email']));
    $phone = mysqli_real_escape_string($conn, trim($_POST['phone']));
    $address = mysqli_real_escape_string($conn, trim($_POST['address']));

    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Check Password
    if ($password !== $confirm_password) {
        die("Password and Confirm Password do not match! <a href='register.php'>Go Back</a>");
    }

    // Check Password Length
    if (strlen($password) < 6) {
        die("Password must be at least 6 characters! <a href='register.php'>Go Back</a>");
    }

    // Check Existing Email
    $check_sql = "SELECT * FROM users WHERE email = '$email'";
    $check_result = mysqli_query($conn, $check_sql);

    if (mysqli_num_rows($check_result) > 0) {
        die("Email already exists! <a href='register.php'>Go Back</a>");
    }

    // Hash Password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Customer Role
    $role_id = 3;

    // Account Status
    $status = "active";

    // Insert User
    $sql = "INSERT INTO users
            (role_id, full_name, email, phone, password, address, status)

            VALUES
            (
                $role_id,
                '$full_name',
                '$email',
                '$phone',
                '$hashed_password',
                '$address',
                '$status'
            )";

    $result = mysqli_query($conn, $sql);

    if ($result) {

        echo "
        <div style='text-align:center; margin-top:100px; font-family:Arial;'>

            <h2>Registration Successful!</h2>

            <p>Your account has been created successfully.</p>

            <a href='login.php'>Login Now</a>

        </div>
        ";

    } else {

        echo "Registration Failed: " . mysqli_error($conn);

    }

} else {

    header("Location: register.php");
    exit;

}

?>
