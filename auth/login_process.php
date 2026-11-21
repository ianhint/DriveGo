
<?php

// Database Connection
require_once "../config/dbconfig.php";

// Functions File
require_once "../includes/functions.php";


// Check Login Form
if (isset($_POST['email']) && isset($_POST['password'])) {

    // Get Email and Password
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];


    // Find User
    $sql = "SELECT users.*, roles.role_name
            FROM users
            JOIN roles ON users.role_id = roles.role_id
            WHERE users.email = '$email'";

    $result = mysqli_query($conn, $sql);


    // Check User
    if (mysqli_num_rows($result) > 0) {

        $user = mysqli_fetch_assoc($result);


        // Check Password
        if (password_verify($password, $user['password'])) {


            // Check Account Status
            if ($user['status'] == "active") {


                // Start Session
                session_start();


                // Store User Information
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['user_name'] = $user['full_name'];
                $_SESSION['user_email'] = $user['email'];
                $_SESSION['role_name'] = $user['role_name'];


                // Redirect Based on Role
                if ($user['role_name'] == "Admin") {

                    redirect("../admin/dashboard.php");

                }

                elseif ($user['role_name'] == "Staff") {

                    redirect("../staff/dashboard.php");

                }

                else {

                    redirect("../customer/dashboard.php");

                }


            } else {

                echo "Your Account is Inactive!";

            }


        } else {

            echo "Wrong Password!";

        }


    } else {

        echo "Email Not Found!";

    }

} else {

    echo "Please Login First!";

}

?>
