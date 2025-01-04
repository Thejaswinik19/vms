<?php
// Initialize variables
$name = $email = $message = "";
$error = $success = "";

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    // Basic Validation
    if (empty($name) || empty($email) || empty($message)) {
        $error = "All fields are required!";
    } else {
        // Prepare email
        $to = "admin@example.com"; // Replace with the recipient email address
        $subject = "New Contact Us Message";
        $body = "You have received a new message from the contact form.\n\n" .
                "Name: " . $name . "\n" .
                "Email: " . $email . "\n" .
                "Message: " . $message;
        $headers = "From: " . $email;

        // Send email
        if (mail($to, $subject, $body, $headers)) {
            $success = "Thank you for contacting us! We will get back to you shortly.";
        } else {
            $error = "There was an error sending your message. Please try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - Vehicle Record Management System</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/contactStyle.css">
</head>
<body>
    <!-- Include Navbar -->
    <?php include('navbar.php'); ?>

    <!-- Contact Form Section -->
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-lg p-4">
                    <h3 class="text-center text-primary mb-4">Contact Us</h3>

                    <!-- Display Success/Error Messages -->
                    <?php if ($error): ?>
                        <div class="alert alert-danger"><?php echo $error; ?></div>
                    <?php elseif ($success): ?>
                        <div class="alert alert-success"><?php echo $success; ?></div>
                    <?php endif; ?>

                    <!-- Contact Form -->
                    <form method="POST" action="contact.php">
                        <div class="form-group">
                            <label for="name"><i class="fas fa-user"></i> Your Name</label>
                            <input type="text" name="name" id="name" class="form-control" placeholder="Enter Your Name" value="<?php echo $name; ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="email"><i class="fas fa-envelope"></i> Your Email</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="Enter Your Email" value="<?php echo $email; ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="message"><i class="fas fa-comments"></i> Your Message</label>
                            <textarea name="message" id="message" class="form-control" rows="5" placeholder="Write your message here..." required><?php echo $message; ?></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary btn-block">Send Message</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Include Footer -->
    <?php include('footer.php'); ?>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
