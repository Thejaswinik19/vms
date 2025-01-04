<?php
require 'db.php';

$service = []; // Initialize the array to avoid undefined errors.

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['service_id'])) {
    $service_id = $_GET['service_id'];

    // Query to fetch service details along with the service name from service_types.
    $stmt = $conn->prepare(
        "SELECT s.*, st.service_name 
         FROM services s
         INNER JOIN service_types st ON s.service_type_id = st.service_id
         WHERE s.service_id = ?"
    );
    $stmt->bind_param("i", $service_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $service = $result->fetch_assoc();
    } else {
        echo "<script>alert('No service found with the provided ID.'); window.location.href='admin_dashboard.php';</script>";
        exit;
    }

    $stmt->close();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_service'])) {
    $service_id = $_POST['service_id'];
    $service_date = $_POST['service_date'];
    $cost = $_POST['cost'];

    $stmt = $conn->prepare("UPDATE services SET service_date = ?, cost = ? WHERE service_id = ?");
    $stmt->bind_param("sdi", $service_date, $cost, $service_id);

    if ($stmt->execute()) {
        echo "<script>alert('Service updated successfully.'); window.location.href='admin_dashboard.php';</script>";
    } else {
        echo "<script>alert('Failed to update service. Error: " . $stmt->error . "');</script>";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Service</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .form-container {
            background-color: #ffffff;
            padding: 20px 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
        }

        h2 {
            text-align: center;
            color: #333333;
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin: 10px 0 5px;
            font-weight: bold;
            color: #555555;
        }

        input[type="date"],
        input[type="number"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #dddddd;
            border-radius: 4px;
            font-size: 16px;
        }

        textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #dddddd;
            border-radius: 4px;
            font-size: 16px;
            resize: vertical;
            height: 100px;
            background-color: #e9ecef;
            color: #6c757d;
        }

        textarea[readonly] {
            cursor: not-allowed;
        }

        button {
            display: block;
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }

        .back-link {
            text-align: center;
            margin-top: 10px;
        }

        .back-link a {
            text-decoration: none;
            color: #4CAF50;
            font-size: 14px;
        }

        .back-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Edit Service</h2>
        <form method="POST">
    <input type="hidden" name="service_id" value="<?= htmlspecialchars($service['service_id'] ?? ''); ?>">

    <label for="service_name">Service Name:</label>
    <input type="text" name="service_name" value="<?= htmlspecialchars($service['service_name'] ?? ''); ?>" readonly>

    <label for="service_date">Service Date:</label>
    <input type="date" name="service_date" value="<?= htmlspecialchars($service['service_date'] ?? ''); ?>" required>

    <label for="cost">Cost:</label>
    <input type="number" name="cost" step="0.01" value="<?= htmlspecialchars($service['cost'] ?? ''); ?>" required>

    <button type="submit" name="edit_service">Update</button>
</form>

        <div class="back-link">
            <a href="admin_dashboard.php">Back to Dashboard</a>
        </div>
    </div>
</body>
</html>
