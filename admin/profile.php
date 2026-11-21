
<?php

// Admin Authentication
require_once "../includes/auth_check.php";

// Database Connection
require_once "../config/dbconfig.php";

// Get Admin ID
$admin_id = $_SESSION['user_id'];

$message = "";
$error = "";


// Get Admin Information
$sql = "SELECT * FROM users WHERE user_id = '$admin_id'";

$result = mysqli_query($conn, $sql);

$admin = mysqli_fetch_assoc($result);


// Update Profile
if (isset($_POST['update_profile'])) {

    $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);

    // Check Duplicate Email
    $check_sql = "SELECT user_id FROM users
                  WHERE email = '$email'
                  AND user_id != '$admin_id'";

    $check_result = mysqli_query($conn, $check_sql);

    if (mysqli_num_rows($check_result) > 0) {

        $error = "This email is already registered.";

    } else {

        $profile_image = $admin['profile_image'];

        // Profile Image Upload
        if (!empty($_FILES['profile_image']['name'])) {

            $folder = "../uploads/profiles/";

            if (!is_dir($folder)) {
                mkdir($folder, 0777, true);
            }

            $image_info = getimagesize($_FILES['profile_image']['tmp_name']);

            $image_type = $image_info['mime'] ?? '';

            $allowed_types = [
                'image/jpeg' => 'jpg',
                'image/png' => 'png',
                'image/webp' => 'webp'
            ];

            if ($_FILES['profile_image']['error'] != 0) {

                $error = "Image upload failed.";

            } elseif ($_FILES['profile_image']['size'] > 2 * 1024 * 1024) {

                $error = "Image size must be below 2MB.";

            } elseif (!isset($allowed_types[$image_type])) {

                $error = "Only JPG, PNG and WEBP images are allowed.";

            } else {

                $image_name = uniqid('admin_') . '.' . $allowed_types[$image_type];

                if (move_uploaded_file(
                    $_FILES['profile_image']['tmp_name'],
                    $folder . $image_name
                )) {

                    $profile_image = "uploads/profiles/" . $image_name;

                } else {

                    $error = "Unable to upload profile image.";

                }

            }

        }


        // Update Database
        if ($error == "") {

            $update_sql = "UPDATE users SET
                           full_name = '$full_name',
                           email = '$email',
                           phone = '$phone',
                           address = '$address',
                           profile_image = '$profile_image'
                           WHERE user_id = '$admin_id'";

            if (mysqli_query($conn, $update_sql)) {

                $_SESSION['user_name'] = $full_name;
                $_SESSION['user_email'] = $email;

                $message = "Profile updated successfully!";

            } else {

                $error = "Unable to update profile.";

            }

        }

    }

}


// Change Password
if (isset($_POST['change_password'])) {

    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    if ($new_password != $confirm_password) {

        $error = "New password and confirm password do not match.";

    } elseif (strlen($new_password) < 6) {

        $error = "Password must contain at least 6 characters.";

    } elseif (!password_verify($current_password, $admin['password'])) {

        $error = "Current password is incorrect.";

    } else {

        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

        $password_sql = "UPDATE users
                         SET password = '$hashed_password'
                         WHERE user_id = '$admin_id'";

        if (mysqli_query($conn, $password_sql)) {

            $message = "Password changed successfully!";

        } else {

            $error = "Unable to change password.";

        }

    }

}


// Refresh Admin Information
$result = mysqli_query($conn, $sql);
$admin = mysqli_fetch_assoc($result);


// Profile Image
$image_path = "../" . $admin['profile_image'];

if (empty($admin['profile_image']) || !file_exists($image_path)) {
    $image_path = "";
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Admin Profile - DriveGo</title>

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

        .profile-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }

        .profile-card {
            border: none;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.05);
        }

        .profile-avatar {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            background: #14213d;
            color: white;
            font-size: 45px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: auto;
        }

        .form-label {
            font-weight: 600;
            color: #333;
        }

        .btn-primary {
            background: #14213d;
            border: none;
        }

        .btn-primary:hover {
            background: #20375f;
        }

        @media(max-width: 768px) {

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


        <!-- Header -->

        <div class="profile-header">

            <div>

                <h2>My Profile</h2>

                <p class="text-muted">
                    Manage your admin account information.
                </p>

            </div>

            <a href="dashboard.php" class="btn btn-outline-dark">

                <i class='bx bx-arrow-back'></i>
                Dashboard

            </a>

        </div>


        <!-- Messages -->

        <?php if ($message != "") { ?>

            <div class="alert alert-success">

                <?php echo $message; ?>

            </div>

        <?php } ?>


        <?php if ($error != "") { ?>

            <div class="alert alert-danger">

                <?php echo $error; ?>

            </div>

        <?php } ?>


        <div class="row">


            <!-- Profile Information -->

            <div class="col-lg-7 mb-4">

                <div class="card profile-card">

                    <h4 class="mb-4">Personal Information</h4>


                    <form method="POST" enctype="multipart/form-data">


                        <!-- Profile Picture -->

                        <div class="text-center mb-4">

                            <?php if ($image_path != "") { ?>

                                <img src="<?php echo htmlspecialchars($image_path); ?>"
                                     class="profile-avatar"
                                     id="previewImage">

                            <?php } else { ?>

                                <div class="profile-avatar" id="avatarText">

                                    <?php echo strtoupper(substr($admin['full_name'], 0, 1)); ?>

                                </div>

                                <img src=""
                                     class="profile-avatar d-none"
                                     id="previewImage">

                            <?php } ?>


                            <div class="mt-3">

                                <label class="form-label">
                                    Profile Picture
                                </label>

                                <input type="file"
                                       name="profile_image"
                                       class="form-control"
                                       accept="image/jpeg,image/png,image/webp"
                                       onchange="previewProfile(event)">

                                <small class="text-muted">
                                    JPG, PNG or WEBP. Maximum 2MB.
                                </small>

                            </div>

                        </div>


                        <!-- Full Name -->

                        <div class="mb-3">

                            <label class="form-label">
                                Full Name
                            </label>

                            <input type="text"
                                   name="full_name"
                                   class="form-control"
                                   value="<?php echo htmlspecialchars($admin['full_name']); ?>"
                                   required>

                        </div>


                        <!-- Email -->

                        <div class="mb-3">

                            <label class="form-label">
                                Email Address
                            </label>

                            <input type="email"
                                   name="email"
                                   class="form-control"
                                   value="<?php echo htmlspecialchars($admin['email']); ?>"
                                   required>

                        </div>


                        <!-- Phone -->

                        <div class="mb-3">

                            <label class="form-label">
                                Phone Number
                            </label>

                            <input type="text"
                                   name="phone"
                                   class="form-control"
                                   value="<?php echo htmlspecialchars($admin['phone'] ?? ''); ?>">

                        </div>


                        <!-- Address -->

                        <div class="mb-3">

                            <label class="form-label">
                                Address
                            </label>

                            <textarea name="address"
                                      class="form-control"
                                      rows="3"><?php echo htmlspecialchars($admin['address'] ?? ''); ?></textarea>

                        </div>


                        <button type="submit"
                                name="update_profile"
                                class="btn btn-primary px-4">

                            <i class='bx bx-save'></i>
                            Update Profile

                        </button>


                    </form>

                </div>

            </div>



            <!-- Password Change -->

            <div class="col-lg-5 mb-4">

                <div class="card profile-card">

                    <h4 class="mb-4">

                        <i class='bx bx-lock-alt'></i>
                        Change Password

                    </h4>


                    <form method="POST">


                        <div class="mb-3">

                            <label class="form-label">
                                Current Password
                            </label>

                            <input type="password"
                                   name="current_password"
                                   class="form-control"
                                   required>

                        </div>


                        <div class="mb-3">

                            <label class="form-label">
                                New Password
                            </label>

                            <input type="password"
                                   name="new_password"
                                   class="form-control"
                                   minlength="6"
                                   required>

                        </div>


                        <div class="mb-3">

                            <label class="form-label">
                                Confirm New Password
                            </label>

                            <input type="password"
                                   name="confirm_password"
                                   class="form-control"
                                   minlength="6"
                                   required>

                        </div>


                        <button type="submit"
                                name="change_password"
                                class="btn btn-primary px-4">

                            <i class='bx bx-key'></i>
                            Change Password

                        </button>


                    </form>

                </div>


                <!-- Account Information -->

                <div class="card profile-card mt-4">

                    <h5>Account Information</h5>

                    <p class="mb-2">
                        <strong>Admin ID:</strong>
                        <?php echo $admin['user_id']; ?>
                    </p>

                    <p class="mb-2">
                        <strong>Status:</strong>
                        <span class="badge bg-success">
                            <?php echo htmlspecialchars($admin['status']); ?>
                        </span>
                    </p>

                    <p class="mb-0">
                        <strong>Account Created:</strong>
                        <?php echo date('d M Y', strtotime($admin['created_at'])); ?>
                    </p>

                </div>

            </div>


        </div>


    </div>


    <!-- Bootstrap JS -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


    <!-- Image Preview -->

    <script>

        function previewProfile(event) {

            let image = document.getElementById('previewImage');

            let avatar = document.getElementById('avatarText');

            image.src = URL.createObjectURL(event.target.files[0]);

            image.classList.remove('d-none');

            if (avatar) {
                avatar.classList.add('d-none');
            }

        }

    </script>


</body>

</html>
