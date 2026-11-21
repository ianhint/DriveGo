
<?php

require_once "../includes/auth_check.php";
require_once "../config/dbconfig.php";

// Check Form Submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Get Form Data
    $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);

    // Password
    $password = sha1($_POST['password']);

    // Check Existing Email
    $check_sql = "SELECT user_id FROM users WHERE email = '$email'";
    $check_result = mysqli_query($conn, $check_sql);

    if (mysqli_num_rows($check_result) > 0) {

        echo "<script>
                alert('This email already exists!');
                window.location.href = 'add_staff.php';
              </script>";
        exit();

    }

    // Insert Staff
    $sql = "INSERT INTO users
            (role_id, full_name, email, phone, password, address, status)
            VALUES
            (2, '$full_name', '$email', '$phone', '$password', '$address', 'Active')";

    if (mysqli_query($conn, $sql)) {

        echo "<script>
                alert('Staff added successfully!');
                window.location.href = 'staff.php';
              </script>";

    } else {

        echo "Error: " . mysqli_error($conn);

    }

} else {

    header("Location: staff.php");
    exit();

}

?>
