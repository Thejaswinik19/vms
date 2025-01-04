<?php
// Include the database connection file
include('db.php');
session_start();

// Check if the user is logged in
if (!isset($_SESSION['UserID'])) {
    header("Location: login.php");
    exit();
}

// Get the username of the logged-in user
$user_id = $_SESSION['UserID'];
$sql = "SELECT username FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$username = $user['username'];

// Count the number of pending services for the user
$pending_query = "
    SELECT COUNT(*) AS pending_count 
    FROM services s
    JOIN vehicles v ON s.vehicle_id = v.vehicle_id
    WHERE v.owner_id = ? AND s.status = 'pending'
";
$stmt = $conn->prepare($pending_query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$pending_result = $stmt->get_result();
$pending_count = $pending_result->fetch_assoc()['pending_count'];



$stmt->bind_param("i", $user_id);
$stmt->execute();
$recent_activities = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="css/userdashboard.css">
  
</head>
<body>
    <div class="container mt-5">
        <h2><i class="fas fa-user-circle"></i> Welcome, <?php echo htmlspecialchars($username); ?>!</h2>

        <!-- User Actions -->
        <div class="btn-group mt-3" role="group">
            <a href="add_vehicle.php" class="btn btn-primary"><i class="fas fa-car"></i> Add Vehicle</a>
            <a href="view_vehicles.php" class="btn btn-success"><i class="fas fa-list"></i> View Vehicles</a>
            <a href="view_services.php" class="btn btn-info">
                <i class="fas fa-tools"></i> View Services
                <?php if ($pending_count > 0): ?>
                    <span class="badge badge-danger"><?php echo $pending_count; ?></span>
                <?php endif; ?>
            </a>
            <a href="profile.php" class="btn btn-warning"><i class="fas fa-user-edit"></i> Edit Profile</a>
            <a href="logout.php" class="btn btn-danger"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </div>

       

        

       <!-- Tips Section -->
<div class="card mt-4">
    <div class="card-header">
        <h5><i class="fas fa-lightbulb" ></i> Tips & Recommendations</h5>
    </div>
    <div class="card-body">
        <ul>
            <li><i class="fas fa-oil-can"></i> <strong>Oil Changes:</strong> Change your engine oil every 5,000-7,000 miles or as recommended by the manufacturer.</li>
            <li><i class="fas fa-battery-full"></i> <strong>Battery Health:</strong> Test your vehicle's battery every 6 months to avoid unexpected breakdowns.</li>
            <li><i class="fas fa-road"></i> <strong>Brake Maintenance:</strong> Check your brakes regularly, especially if you hear squeaking or grinding noises.</li>
            <li><i class="fas fa-gas-pump"></i> <strong>Fuel Efficiency:</strong> Maintain a steady speed and avoid unnecessary idling to improve fuel efficiency.</li>
            <li><i class="fas fa-tachometer-alt"></i> <strong>Engine Check:</strong> If your engine light is on, don't delay; schedule a diagnostic check immediately.</li>
            <li><i class="fas fa-snowflake"></i> <strong>Air Conditioning:</strong> Run your air conditioning periodically to keep the system in good condition, even in winter.</li>
            <li><i class="fas fa-file-alt"></i> <strong>Service Records:</strong> Keep a log of all service activities for resale value and warranty purposes.</li>
        </ul>
        <p><a href="maintenance_guide.php">Read our complete vehicle maintenance guide</a> for more detailed information.</p>
    </div>
</div>
<?php include('footer.php'); ?>

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
