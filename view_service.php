<?php
require 'db.php'; // Include database connection

if (isset($_GET['vehicle_id'])) {
    $vehicle_id = $_GET['vehicle_id'];

    // Fetch services associated with the vehicle
    $query = "
        SELECT services.*, service_types.service_name
        FROM services
        JOIN service_types ON services.service_type_id = service_types.service_id
        WHERE services.vehicle_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $vehicle_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $services = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
} else {
    echo "<script>alert('Invalid request.'); window.location.href='admin_dashboard.php';</script>";
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>View Services</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <div class="container">
        <h2>Services for Vehicle ID: <?= htmlspecialchars($vehicle_id); ?></h2>
        <?php if (!empty($services)): ?>
            <table>
                <thead>
                    <tr>
                        <th>Service Name</th>
                        <th>Service Date</th>
                        <th>Cost</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($services as $service): ?>
                        <tr>
                            <td><?= htmlspecialchars($service['service_name']); ?></td>
                            <td><?= htmlspecialchars($service['service_date']); ?></td>
                            <td><?= htmlspecialchars($service['cost']); ?></td>
                            <td><?= htmlspecialchars($service['status']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p style="text-align: center; color: #888;">No services found for this vehicle.</p>
        <?php endif; ?>
        <a href="admin_dashboard.php">Back to Dashboard</a>
    </div>
</body>
</html>
