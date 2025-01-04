<?php
require 'db.php';

// Check if 'vehicle_id' is provided in the GET request
if (isset($_GET['vehicle_id']) && is_numeric($_GET['vehicle_id'])) {
    $vehicle_id = (int) $_GET['vehicle_id']; // Ensure it's an integer

    // Prepare the SQL query to fetch the vehicle and its associated user
    $stmt = $conn->prepare("
        SELECT u.id, u.username, u.email, u.phone, u.address
        FROM vehicles v
        JOIN users u ON v.owner_id = u.id
        WHERE v.vehicle_id = ?
    ");

    if ($stmt === false) {
        die('MySQL prepare error: ' . $conn->error); // Debugging output
    }

    // Bind the vehicle_id parameter
    $stmt->bind_param("i", $vehicle_id);

    // Execute the query
    $stmt->execute();

    // Get the result
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc(); // Fetch user details
    } else {
        // If no user is found for the vehicle, show a message
        echo "<script>alert('User not found for this vehicle.'); window.location.href='admin_dashboard.php';</script>";
        exit;
    }

    $stmt->close();
} else {
    // Redirect or show an error for invalid or missing vehicle_id
    echo "<script>alert('Invalid request. Please select a vehicle to view its user details.'); window.location.href='admin_dashboard.php';</script>";
    exit;
}
?>

    <!DOCTYPE html>
<html>
<head>
    <title>View User</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
   
</head>
<body>
    <div class="container">
        <h2><i class="fas fa-user"></i> User Details</h2>
        <table>
            <tr>
                <th><i class="fas fa-user"></i> Username</th>
                <td><?= htmlspecialchars($user['username']); ?></td>
            </tr>
            <tr>
                <th><i class="fas fa-envelope"></i> Email</th>
                <td><?= htmlspecialchars($user['email']); ?></td>
            </tr>
            <tr>
                <th><i class="fas fa-phone"></i> Phone</th>
                <td><?= htmlspecialchars($user['phone']); ?></td>
            </tr>
            <tr>
                <th><i class="fas fa-map-marker-alt"></i> Address</th>
                <td><?= htmlspecialchars($user['address']); ?></td>
            </tr>
        </table>
        <a href="admin_dashboard.php"><i class="fas fa-arrow-left"></i> Back to Dashboard</a>
    </div>
</body>
</html>

