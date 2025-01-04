<?php
include('db.php');
session_start();

// Check if user is logged in
if (!isset($_SESSION['UserID'])) {
    header("Location: login.php");
    exit();
}

// Get the logged-in user's ID
$user_id = $_SESSION['UserID'];

// Fetch the user details from the database
$query = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($query);

if ($stmt === false) {
    die('MySQL prepare error: ' . $conn->error);
}

$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

// Check if the user exists
if ($result->num_rows === 0) {
    die("User not found.");
}

$user = $result->fetch_assoc();

// Handle form submission for updating profile details
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_profile'])) {
    $full_name = $_POST['full_name'];   // This represents the full name field in the form
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    // Update query to save the changes (ensure not updating the unique username)
    $update_query = "UPDATE users SET username = ?, email = ?, phone = ?, address = ? WHERE id = ?";
    $update_stmt = $conn->prepare($update_query);

    if ($update_stmt === false) {
        die('MySQL prepare error: ' . $conn->error);
    }

    $update_stmt->bind_param("ssssi", $full_name, $email, $phone, $address, $user_id);

    if ($update_stmt->execute()) {
        echo "<script>alert('Profile updated successfully!'); window.location.href='profile.php';</script>";
    } else {
        echo "<script>alert('Failed to update profile. Please try again.');</script>";
    }
    $update_stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"> <!-- Font Awesome -->
    <style>
       body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(135deg, #74ebd5, #ACB6E5); /* Gradient background */
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0;
        }

        .container {
            background-color: #ffffff;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.1);
            max-width: 750px;
            width: 100%;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .container:hover {
            transform: scale(1.05);
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.2);
        }

        h2 {
            color: #3e4e8c;
            text-align: center;
            margin-bottom: 30px;
            font-size: 2.5rem;
            font-weight: bold;
        }

        .form-group label {
            font-weight: bold;
            color: #555;
        }

        .form-group i {
            margin-right: 10px;
        }

        .btn-primary {
            background-color: #5b72b3;
            border-color: #5b72b3;
            font-size: 16px;
            padding: 12px 25px;
            transition: background-color 0.3s ease, transform 0.3s ease;
            border-radius: 30px;
        }

        .btn-primary:hover {
            background-color: #4a60a6;
            border-color: #4a60a6;
            transform: translateY(-3px);
        }

        .btn-secondary {
            font-size: 16px;
            padding: 12px 25px;
            background-color: #f0f4ff;
            border-color: #5b72b3;
            transition: background-color 0.3s ease, transform 0.3s ease;
            border-radius: 30px;
        }

        .btn-secondary:hover {
            background-color: #e2e8f3;
            border-color: #4a60a6;
            transform: translateY(-3px);
        }

        .form-control {
            font-size: 16px;
            padding: 12px;
            border-radius: 8px;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        .form-control:focus {
            border-color: #5b72b3;
            box-shadow: 0 0 10px rgba(91, 114, 179, 0.5);
        }

        .text-center a {
            font-size: 16px;
            text-decoration: none;
            color: #5b72b3;
            transition: color 0.3s ease;
        }

        .text-center a:hover {
            text-decoration: underline;
            color: #3a4e8c;
        }

    </style>
</head>
<body>
    <div class="container">
        <h2>Edit Profile</h2>
        <form method="POST" class="mt-4">
            <div class="form-group">
                <label for="full_name"><i class="fas fa-user"></i> Full Name:</label>
                <input type="text" name="full_name" class="form-control" value="<?php echo htmlspecialchars($user['username']); ?>" required>
            </div>
            <div class="form-group">
                <label for="email"><i class="fas fa-envelope"></i> Email:</label>
                <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($user['email']); ?>" required>
            </div>
            <div class="form-group">
                <label for="phone"><i class="fas fa-phone"></i> Phone:</label>
                <input type="text" name="phone" class="form-control" value="<?php echo htmlspecialchars($user['phone']); ?>" required>
            </div>
            <div class="form-group">
                <label for="address"><i class="fas fa-map-marker-alt"></i> Address:</label>
                <textarea name="address" class="form-control" rows="4" required><?php echo htmlspecialchars($user['address']); ?></textarea>
            </div>
            <button type="submit" name="update_profile" class="btn btn-primary"><i class="fas fa-save"></i> Update Profile</button>
        </form>
        <div class="mt-4 text-center">
            <a href="user_dashboard.php" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Back to Dashboard</a>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
