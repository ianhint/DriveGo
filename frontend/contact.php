
<?php

require_once "../config/dbconfig.php";

$success = "";
$error = "";

if (isset($_POST['send_message'])) {

    $name = mysqli_real_escape_string($conn, trim($_POST['full_name']));
    $email = mysqli_real_escape_string($conn, trim($_POST['email']));
    $subject = mysqli_real_escape_string($conn, trim($_POST['subject']));
    $message = mysqli_real_escape_string($conn, trim($_POST['message']));

    if ($name == "" || $email == "" || $subject == "" || $message == "") {

        $error = "Please fill in all fields.";

    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

        $error = "Please enter a valid email address.";

    } else {

        $sql = "INSERT INTO contact_messages
                (full_name, email, subject, message)

                VALUES
                ('$name', '$email', '$subject', '$message')";

        if (mysqli_query($conn, $sql)) {

            $success = "Your message has been sent successfully!";

        } else {

            $error = "Something went wrong. Please try again.";

        }

    }

}

require_once "partials/header.php";

?>

<section class="contact-hero">

    <div class="container text-center">

        <span>GET IN TOUCH</span>

        <h1>Contact Us</h1>

        <p>We would love to hear from you.</p>

    </div>

</section>


<section class="contact-section">

    <div class="container">

        <div class="row g-5">

            <div class="col-lg-5">

                <h2>Let's Talk</h2>

                <p class="text-muted">
                    Have questions about our cars or rental services?
                    Send us a message.
                </p>

                <div class="contact-info">

                    <i class='bx bx-envelope'></i>

                    <div>
                        <h6>Email</h6>
                        <p>support@drivego.com</p>
                    </div>

                </div>

                <div class="contact-info">

                    <i class='bx bx-phone'></i>

                    <div>
                        <h6>Phone</h6>
                        <p>+880 1234-567890</p>
                    </div>

                </div>

                <div class="contact-info">

                    <i class='bx bx-map'></i>

                    <div>
                        <h6>Address</h6>
                        <p>Dhaka, Bangladesh</p>
                    </div>

                </div>

            </div>


            <div class="col-lg-7">

                <div class="contact-form-box">

                    <h3>Send Us a Message</h3>

                    <?php if ($success != "") { ?>

                        <div class="alert alert-success">
                            <?php echo htmlspecialchars($success); ?>
                        </div>

                    <?php } ?>

                    <?php if ($error != "") { ?>

                        <div class="alert alert-danger">
                            <?php echo htmlspecialchars($error); ?>
                        </div>

                    <?php } ?>


                    <form method="POST" action="contact.php">

                        <div class="mb-3">

                            <label class="form-label">Full Name</label>

                            <input
                                type="text"
                                name="full_name"
                                class="form-control"
                                required>

                        </div>


                        <div class="mb-3">

                            <label class="form-label">Email Address</label>

                            <input
                                type="email"
                                name="email"
                                class="form-control"
                                required>

                        </div>


                        <div class="mb-3">

                            <label class="form-label">Subject</label>

                            <input
                                type="text"
                                name="subject"
                                class="form-control"
                                required>

                        </div>


                        <div class="mb-3">

                            <label class="form-label">Message</label>

                            <textarea
                                name="message"
                                class="form-control"
                                rows="5"
                                required></textarea>

                        </div>


                        <button
                            type="submit"
                            name="send_message"
                            class="btn btn-primary px-5">

                            Send Message
                            <i class='bx bx-send'></i>

                        </button>

                    </form>

                </div>

            </div>

        </div>

    </div>

</section>


<?php require_once "partials/footer.php"; ?>
