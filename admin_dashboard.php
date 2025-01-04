<?php
include('db.php'); // Include the database connection
session_start();

// Check if the admin is logged in
if (!isset($_SESSION['admin'])) {
    header("Location: adminLogin.php");
    exit();
}

// --- Add New Vehicle ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_vehicle'])) {
    // Get the current year
    $currentYear = (int)date("Y");

    // Get data from the form
    $user_id = (int)$_POST['user_id']; // Sanitize and cast user_id
    $make = $_POST['make'];
    $model = $_POST['model'];
    $year = (int)$_POST['year']; // Sanitize and cast year
    $registration_number = $_POST['registration_number'];
    $color = $_POST['color'];
    $mileage = (int)$_POST['mileage']; // Sanitize and cast mileage

    // Validate the year
    if ($year > $currentYear) {
        die("<script>alert('Vehicle year cannot be in the future. Please enter a valid year.'); window.history.back();</script>");
    }

    // Prepare SQL query to insert vehicle details
    $add_vehicle_query = "INSERT INTO vehicles (owner_id, make, model, year, registration_number, color, mileage) VALUES (?, ?, ?, ?, ?, ?, ?)";

    // Prepare statement
    $stmt = $conn->prepare($add_vehicle_query);
    if ($stmt === false) {
        die('MySQL prepare error: ' . $conn->error);
    }

    // Bind parameters
    $stmt->bind_param("isssssi", $user_id, $make, $model, $year, $registration_number, $color, $mileage);

    // Execute query
    if ($stmt->execute()) {
        echo "<script>alert('Vehicle added successfully!'); window.location.href='admin_dashboard.php';</script>";
    } else {
        // Display detailed error message
        echo "<script>alert('Failed to add vehicle. Error: " . $stmt->error . "');</script>";
    }

    $stmt->close();
}



if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_vehicle'])) {
    $vehicle_id = $_POST['vehicle_id']; // Retrieve vehicle ID

    if (!empty($vehicle_id)) {
        // Prepare the SQL statement to delete the vehicle
        $stmt = $conn->prepare("DELETE FROM vehicles WHERE vehicle_id = ?");

        if ($stmt === false) {
            // Output error if the prepare statement fails
            die('MySQL prepare error: ' . $conn->error);
        }

        // Bind parameters: vehicle_id (integer)
        $stmt->bind_param("i", $vehicle_id);

        // Execute the query
        if ($stmt->execute()) {
            // Success message and redirection
            echo "<script>alert('Vehicle deleted successfully.'); window.location.href='admin_dashboard.php';</script>";
        } else {
            // Output error message if deletion fails
            echo "<script>alert('Failed to delete vehicle. Error: " . $stmt->error . "');</script>";
        }

        $stmt->close();
    } else {
        // Error if vehicle_id is missing
        echo "<script>alert('Invalid vehicle ID.');</script>";
    }
}




// Fetch all vehicles for tables and dropdowns

$vehicles_queryy = 
"SELECT * FROM vehicles 
where status= 'Active' 
";
$vehicles_resultt = $conn->query($vehicles_queryy);
$vehicles_lists = $vehicles_resultt->fetch_all(MYSQLI_ASSOC); 


// Fetch all service types for the dropdown
$service_types_result = $conn->query("SELECT service_id, service_name FROM service_types");

// Fetch all users for dropdown
$users_result = $conn->query("SELECT id, username FROM users");








// --- Add New Service ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_service'])) {
    $vehicle_id = $_POST['vehicle_id'];
    $service_type_id = $_POST['service_type'];  // Use service_type_id here
    $service_date = $_POST['service_date'];
    $cost = $_POST['cost'];

    if (!empty($vehicle_id) && !empty($service_type_id) && !empty($service_date)) {
        // Insert new service record
        $stmt = $conn->prepare("INSERT INTO services (vehicle_id, service_type_id, service_date, cost, status,admin_id) VALUES (?, ?, ?, ?, 'Pending',1)");
        $stmt->bind_param("iiss", $vehicle_id, $service_type_id, $service_date, $cost);
        $stmt->execute();
        $stmt->close();
    }
}


// Fetch all services for tables
// Fetch all services with vehicle details and service type
$services_result = $conn->query("
    SELECT services.*, vehicles.registration_number, service_types.service_name AS service_type 
    FROM services 
    JOIN vehicles ON services.vehicle_id = vehicles.vehicle_id
    JOIN service_types ON services.service_type_id = service_types.service_id
");

$services = $services_result->fetch_all(MYSQLI_ASSOC);

// Handle status update
// Handle status update
// Handle status update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_status'])) {
    $service_id = $_POST['service_id'];
    $status = $_POST['status']; // New status value

    // Debugging - Check the values being passed
    error_log("Service ID: $service_id");
    error_log("New Status: $status");

    // Check if both service_id and status are provided
    if (!empty($service_id) && !empty($status)) {
        if ($status === 'Completed') {
            // If status is 'Completed', include logic to update last_service_date and next_service_due
            $query = "
                UPDATE services
                SET 
                    status = ?,
                    last_service_date = service_date,
                    next_service_due = DATE_ADD(service_date, INTERVAL (
                        SELECT service_interval_days
                        FROM service_types
                        WHERE service_types.service_id = services.service_type_id
                    ) DAY)
                WHERE service_id = ?";
        } else {
            // Otherwise, just update the status
            $query = "UPDATE services SET status = ? WHERE service_id = ?";
        }

        // Prepare SQL query
        $stmt = $conn->prepare($query);

        if ($stmt === false) {
            // Output error if the prepare statement fails
            die('MySQL prepare error: ' . $conn->error);
        }

        // Bind parameters: status (string) and service_id (integer)
        $stmt->bind_param("si", $status, $service_id);

        // Execute the query
        if ($stmt->execute()) {
            // Success message and redirection
            echo "<script>alert('Service status updated successfully.'); window.location.href='admin_dashboard.php';</script>";
        } else {
            // Output the error from execution if it fails
            echo "<script>alert('Failed to update service status. Error: " . $stmt->error . "');</script>";
        }

        $stmt->close();
    } else {
        // Check if the required parameters are missing
        echo "<script>alert('Invalid service ID or status.');</script>";
    }
}




if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_service'])) {
    // Get the service_id from the form submission
    $service_id = $_POST['service_id'];

    // Prepare the DELETE statement to remove the service
    $stmt = $conn->prepare("DELETE FROM services WHERE service_id = ?");
    $stmt->bind_param("i", $service_id);

    // Execute the query and handle success or failure
    if ($stmt->execute()) {
        echo "<script>alert('Service deleted successfully.'); window.location.href='admin_dashboard.php';</script>";
    } else {
        echo "<script>alert('Failed to delete the service. Error: " . $stmt->error . "');</script>";
    }

    $stmt->close();
    $conn->close();
}





// --- Search Vehicle Services ---

$search_results = [];
$vehicle_details = [];

if (isset($_POST['search_vehicle'])) {
    $registration_number = $_POST['registration_number'];

    // Prepare statement to fetch vehicle details
    $stmt_vehicle = $conn->prepare("
        SELECT * FROM vehicles
        WHERE registration_number = ?
    ");
    $stmt_vehicle->bind_param("s", $registration_number);
    $stmt_vehicle->execute();
    $vehicle_details = $stmt_vehicle->get_result()->fetch_assoc();
    $stmt_vehicle->close();

    // Prepare statement to fetch associated services
    $stmt_services = $conn->prepare("
        SELECT services.*, service_types.service_name, service_types.description
        FROM services
        JOIN vehicles ON services.vehicle_id = vehicles.vehicle_id
        JOIN service_types ON services.service_type_id = service_types.service_id
        WHERE vehicles.registration_number = ?
    ");
    $stmt_services->bind_param("s", $registration_number);
    $stmt_services->execute();
    $search_results = $stmt_services->get_result()->fetch_all(MYSQLI_ASSOC);
    $stmt_services->close();
}





$limit = 5; // Number of records per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Fetch vehicles with pagination
$total_vehicles_query = "SELECT COUNT(*) AS total FROM vehicles";
$total_vehicles_result = $conn->query($total_vehicles_query);
$total_vehicles = $total_vehicles_result->fetch_assoc()['total'];
$total_pages = ceil($total_vehicles / $limit);

$vehicles_query = "SELECT * FROM vehicles LIMIT $offset, $limit";
$vehicles_result = $conn->query($vehicles_query);
$vehicles = $vehicles_result->fetch_all(MYSQLI_ASSOC);

// Fetch services with pagination
$total_services_query = "SELECT COUNT(*) AS total FROM services";
$total_services_result = $conn->query($total_services_query);
$total_services = $total_services_result->fetch_assoc()['total'];
$total_service_pages = ceil($total_services / $limit);

$services_query = "
    SELECT services.*, vehicles.registration_number, service_types.service_name AS service_type 
    FROM services 
    JOIN vehicles ON services.vehicle_id = vehicles.vehicle_id
    JOIN service_types ON services.service_type_id = service_types.service_id
    LIMIT $offset, $limit";
$services_result = $conn->query($services_query);
$services = $services_result->fetch_all(MYSQLI_ASSOC);

// Export Vehicles to CSV
if (isset($_POST['export_vehicles'])) {
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="vehicles.csv"');
    $output = fopen('php://output', 'w');
    fputcsv($output, ['Registration Number', 'Model', 'Year', 'Mileage', 'Color']);
    $vehicles_export_query = "SELECT registration_number, model, year, mileage, color FROM vehicles";
    $vehicles_export_result = $conn->query($vehicles_export_query);
    while ($row = $vehicles_export_result->fetch_assoc()) {
        fputcsv($output, $row);
    }
    fclose($output);
    exit();
}

// Export Services to CSV
if (isset($_POST['export_services'])) {
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="services.csv"');
    $output = fopen('php://output', 'w');
    fputcsv($output, ['Vehicle', 'Service Type', 'Service Date', 'Cost', 'Status']);
    $services_export_query = "
        SELECT vehicles.registration_number, service_types.service_name, services.service_date, services.cost, services.status 
        FROM services 
        JOIN vehicles ON services.vehicle_id = vehicles.vehicle_id
        JOIN service_types ON services.service_type_id = service_types.service_id";
    $services_export_result = $conn->query($services_export_query);
    while ($row = $services_export_result->fetch_assoc()) {
        fputcsv($output, $row);
    }
    fclose($output);
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="css/dashboardStyle.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    
</head>
<body>
<div class="container">
    <h1>Admin Dashboard</h1>
    
    <button onclick="showSection('add_vehicle')">
        <i class="fas fa-plus-circle"></i> Add New Vehicle
    </button>
    <button onclick="showSection('vehicles')">
        <i class="fas fa-car"></i> View Vehicles
    </button>
    <button onclick="showSection('add_service')">
        <i class="fas fa-cogs"></i> Add New Service
    </button>
    <button onclick="showSection('services')">
        <i class="fas fa-wrench"></i> View Services
    </button>
    <button onclick="showSection('search_services')">
        <i class="fas fa-search"></i> Search Vehicle Services
    </button>
    <button onclick="window.location.href='adminLogout.php';">
        <i class="fas fa-sign-out-alt"></i> Logout
    </button>

    <!-- Add Vehicle -->
    <div id="add_vehicle" class="section">
    <form method="POST">
    <label>Select User</label>
    <select name="user_id" required>
        <?php foreach ($users_result as $user): ?>
            <option value="<?= $user['id']; ?>"><?= htmlspecialchars($user['username']); ?></option>
        <?php endforeach; ?>
    </select>

    <label>Make</label>
    <select name="make" required>
        <option value="Toyota">Toyota</option>
        <option value="Ford">Ford</option>
        <option value="Honda">Honda</option>
        <option value="BMW">BMW</option>
        <option value="Mercedes">Mercedes</option>
        <option value="Chevrolet">Chevrolet</option>
        <option value="Nissan">Nissan</option>
        <option value="Volkswagen">Volkswagen</option>
        <option value="Hyundai">Hyundai</option>
        <option value="Other">Other</option>
    </select>

    <label>Model</label>
    <input type="text" name="model" required>

    <label>Year</label>
    <input type="number" name="year" required>

    <label>Registration Number</label>
    <input type="text" name="registration_number" required>

    <label>Color</label>
    <select name="color" required>
        <option value="Red">Red</option>
        <option value="Blue">Blue</option>
        <option value="Green">Green</option>
        <option value="Black">Black</option>
        <option value="White">White</option>
        <option value="Silver">Silver</option>
        <option value="Gray">Gray</option>
        <option value="Yellow">Yellow</option>
        <option value="Other">Other</option>
    </select>

    <label>Mileage</label>
    <input type="number" name="mileage" required>

    <button type="submit" name="add_vehicle">Add Vehicle</button>
</form>
</div>



    <!-- Vehicles Table -->
    <div id="vehicles" class="section">
    <h2>Vehicles</h2>
    <form method="POST">
            <button type="submit" name="export_vehicles">Export to CSV</button>
        </form>
    <table>
        <thead>
            <tr>
                <th>Registration Number</th>
                <th>Model</th>
                <th>Year</th>
                <th>Mileage</th>
                <th>Color</th> <!-- New column for color -->
                <th>Actions</th> <!-- New column for actions -->
            </tr>
        </thead>
        <tbody>
            <?php foreach ($vehicles as $vehicle): ?>
                <tr>
                    <td><?= htmlspecialchars($vehicle['registration_number']); ?></td>
                    <td><?= htmlspecialchars($vehicle['model']); ?></td>
                    <td><?= htmlspecialchars($vehicle['year']); ?></td>
                    <td><?= htmlspecialchars($vehicle['mileage'] ?? 'N/A'); ?> km</td>
                    <td><?= htmlspecialchars($vehicle['color'] ?? 'N/A'); ?></td> <!-- Display color -->
                    <td>
                        <!-- View User -->
                        <a href="view_user.php?vehicle_id=<?= $vehicle['vehicle_id']; ?>" style="color: blue; text-decoration: none; margin-right: 10px;">View User</a>

                        <!-- View Service -->
                        <a href="view_service.php?vehicle_id=<?= $vehicle['vehicle_id']; ?>" style="color: green; text-decoration: none; margin-right: 10px;">View Service</a>

                        <!-- Delete Form -->
                        <form method="POST" style="display: inline-block;" onsubmit="return confirm('Are you sure you want to delete this vehicle?');">
                            <input type="hidden" name="vehicle_id" value="<?= $vehicle['vehicle_id']; ?>"> <!-- Pass the vehicle ID -->
                            <button type="submit" name="delete_vehicle" >Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="pagination">
            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <a href="?page=<?= $i; ?>" class="<?= $i === $page ? 'active' : ''; ?>">Page <?= $i; ?></a>
            <?php endfor; ?>
        </div>
</div>





<div id="add_service" class="section">
    <h2>Add New Service</h2>
    <form method="POST">
        <label>Select Vehicle</label>
        <select name="vehicle_id" required>
            <?php foreach ($vehicles_lists as $vehicle): ?>
                <option value="<?= $vehicle['vehicle_id']; ?>"><?= htmlspecialchars($vehicle['registration_number']); ?></option>
            <?php endforeach; ?>
        </select>



        <label>Select Service Type</label>
        <select name="service_type" required>
            <?php foreach ($service_types_result as $service_type): ?>
                <option value="<?= $service_type['service_id']; ?>"><?= htmlspecialchars($service_type['service_name']); ?></option>
            <?php endforeach; ?>
        </select>

        <label>Service Date</label>
        <input type="date" name="service_date" required>

        <label>Cost</label>
        <input type="number" step="0.01" name="cost" required>

        <button type="submit" name="add_service">Add Service</button>
    </form>
</div>


   <!-- Services Table -->
<!-- Services Table -->
<div id="services" class="section">
    <h2>Services</h2>
    <form method="POST">
            <button type="submit" name="export_services">Export to CSV</button>
        </form></thead>
    <table>
        <thead>
            <tr>
                <th>Vehicle</th>
                <th>Service Type</th>
                <th>Service Date</th>
                <th>Cost</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($services as $service): ?>
                <tr>
                    <td><?= htmlspecialchars($service['registration_number']); ?></td>
                    <td><?= htmlspecialchars($service['service_type']); ?></td>
                    <td><?= htmlspecialchars($service['service_date']); ?></td>
                    <td><?= htmlspecialchars($service['cost']); ?></td>
                    <td><?= htmlspecialchars($service['status']); ?></td>
                    <td>
                        <!-- Update Status Form -->
                        <form method="POST" style="display: inline-block;">
    <input type="hidden" name="service_id" value="<?= $service['service_id']; ?>">
    <select name="status" required <?= $service['status'] === 'Completed' ? 'disabled' : ''; ?>>
        <option value="Pending" <?= $service['status'] === 'Pending' ? 'selected' : ''; ?>>Pending</option>
        <option value="Completed" <?= $service['status'] === 'Completed' ? 'selected' : ''; ?>>Completed</option>
    </select>
    <button 
        type="submit" 
        name="update_status" 
        <?= $service['status'] === 'Completed' ? 'disabled' : ''; ?>
    >
        Update
    </button>
</form>

                        <!-- Delete Form -->
                        <form method="POST" style="display: inline-block;" onsubmit="return confirm('Are you sure you want to delete this service?');">
                            <input type="hidden" name="service_id" value="<?= $service['service_id']; ?>">
                            <button type="submit" name="delete_service" >Delete</button>
                        </form>

                        <!-- Edit Form -->
                        <form method="GET" action="edit_service.php" style="display: inline-block;">
                            <input type="hidden" name="service_id" value="<?= $service['service_id']; ?>">
                            <button type="submit" name="edit_service">Edit</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="pagination">
            <?php for ($i = 1; $i <= $total_service_pages; $i++): ?>
                <a href="?page=<?= $i; ?>" class="<?= $i === $page ? 'active' : ''; ?>">Page <?= $i; ?></a>
            <?php endfor; ?>
        </div>
</div>




    <!-- Search Vehicle Services -->
    <div id="search_services" class="section">
    <h2 style="color:white;">Search Vehicle Services</h2>
    <form method="POST">
        <label>Enter Registration Number</label>
        <input type="text" name="registration_number" required>
        <button type="submit" name="search_vehicle">Search</button>
    </form>

    <?php if (!empty($vehicle_details)): ?>
        <h3 style="color: white;">Vehicle Information</h3>
        <table>
            <thead>
                <tr>
                    <th>Make</th>
                    <th>Model</th>
                    <th>Year</th>
                    <th>Color</th>
                    <th>Mileage</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?= htmlspecialchars($vehicle_details['make']); ?></td>
                    <td><?= htmlspecialchars($vehicle_details['model']); ?></td>
                    <td><?= htmlspecialchars($vehicle_details['year']); ?></td>
                    <td><?= htmlspecialchars($vehicle_details['color']); ?></td>
                    <td><?= htmlspecialchars($vehicle_details['mileage']); ?></td>
                    <td><?= htmlspecialchars($vehicle_details['status']); ?></td>
                </tr>
            </tbody>
        </table>
    <?php endif; ?>

    <?php if (!empty($search_results)): ?>
        <h3 style="color: white;">Service Information</h3>
        <table>
            <thead>
                <tr>
                    <th>Service Name</th>
                    <th>Service Date</th>
                    <th>Cost</th>
                    <th>Details</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($search_results as $result): ?>
                    <tr>
                        <td><?= htmlspecialchars($result['service_name']); ?></td>
                        <td><?= htmlspecialchars($result['service_date']); ?></td>
                        <td><?= htmlspecialchars($result['cost']); ?></td>
                        <td><?= htmlspecialchars($result['description']); ?></td>
                        <td><?= htmlspecialchars($result['status']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php elseif (isset($_POST['search_vehicle'])): ?>
        <p>No service information found for this vehicle.</p>
    <?php endif; ?>
</div>

</div>

<script>
function showSection(id) {
    document.querySelectorAll('.section').forEach(section => section.style.display = 'none');
    document.getElementById(id).style.display = 'block';
}
</script>
</body>
</html>
