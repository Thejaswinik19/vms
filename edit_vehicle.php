<?php
include('db.php');
session_start();

// Check if user is logged in
if (!isset($_SESSION['UserID'])) {
    header("Location: login.php");
    exit();
}

// Get the vehicle_id from the URL
if (!isset($_GET['vehicle_id'])) {
    die('Vehicle ID is required.');
}

$vehicle_id = $_GET['vehicle_id'];
$user_id = $_SESSION['UserID'];

// Fetch the vehicle details from the database
$query = "SELECT * FROM vehicles WHERE vehicle_id = ? AND owner_id = ?";
$stmt = $conn->prepare($query);

if ($stmt === false) {
    die('MySQL prepare error: ' . $conn->error);
}

$stmt->bind_param("ii", $vehicle_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();

// Check if the vehicle exists
if ($result->num_rows === 0) {
    die("Vehicle not found or you don't have permission to edit it.");
}

$vehicle = $result->fetch_assoc();

// Handle form submission for updating vehicle details
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_vehicle'])) {
    $make = $_POST['make'];
    $model = $_POST['model'];
    $year = $_POST['year'];
    $registration_number = $_POST['registration_number'];
    $color = $_POST['color'];
    $mileage = $_POST['mileage'];

    // Update query to save the changes
    $update_query = "UPDATE vehicles SET make = ?, model = ?, year = ?, registration_number = ?, color = ?, mileage = ? WHERE vehicle_id = ? AND owner_id = ?";
    $update_stmt = $conn->prepare($update_query);

    if ($update_stmt === false) {
        die('MySQL prepare error: ' . $conn->error);
    }

    $update_stmt->bind_param("ssisssii", $make, $model, $year, $registration_number, $color, $mileage, $vehicle_id, $user_id);

    if ($update_stmt->execute()) {
        echo "<script>alert('Vehicle updated successfully!'); window.location.href='view_vehicles.php';</script>";
    } else {
        echo "<script>alert('Failed to update vehicle. Please try again.');</script>";
    }
    $update_stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Vehicle</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
<style>
     body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color:rgb(105, 168, 167);
            padding-top: 20px;
        }

        .container {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            max-width: 800px;
            margin: auto;
        }

        h2 {
            text-align: center;
            color:rgb(19, 53, 89);
            font-size: 2rem;
            font-weight: bold;
            margin-bottom: 30px;
        }

        .form-group label {
            font-weight: bold;
           
        }

        .form-control {
            border-radius: 5px;
            padding: 10px;
            font-size: 1rem;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }

        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 10px rgba(0, 123, 255, 0.3);
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            padding: 10px 20px;
            font-size: 1.1rem;
            border-radius: 50px;
            box-shadow: 0 4px 10px rgba(0, 123, 255, 0.2);
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }

        .btn-secondary {
            background-color: #6c757d;
            border-color: #6c757d;
            padding: 10px 20px;
            font-size: 1.1rem;
            border-radius: 5px;
            box-shadow: 0 4px 10px rgba(108, 117, 125, 0.2);
        }

        .btn-secondary:hover {
            background-color: #495057;
            border-color: #495057;
        }

        .form-group i {
            margin-right: 10px;
            color: #007bff;
        }

        .form-group select,
        .form-group input {
            background-color: #f9f9f9;
            
        }

        .form-group select option {
            background-color: #f9f9f9;
        }

        .back-button {
            display: flex;
            justify-content: center;
            margin-top: 30px;
            border-radius: 50px;
        }

        .back-button a {
            text-decoration: none;
        }

        /* Add hover effect to form fields */
        .form-group:hover {
            background-color: #f1f8ff;
        }
</style>
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Edit Vehicle</h2>
        <form method="POST" class="mt-4">
            <div class="form-group">
                <label for="make"><i class="fas fa-car"></i> Make:</label>
                <select name="make" class="form-control" required>
                    <option value="" disabled>Select Make</option>
                    <option value="Toyota" <?php echo $vehicle['make'] == 'Toyota' ? 'selected' : ''; ?>>Toyota</option>
                    <option value="Honda" <?php echo $vehicle['make'] == 'Honda' ? 'selected' : ''; ?>>Honda</option>
                    <option value="Ford" <?php echo $vehicle['make'] == 'Ford' ? 'selected' : ''; ?>>Ford</option>
                    <option value="Hyundai" <?php echo $vehicle['make'] == 'Hyundai' ? 'selected' : ''; ?>>Hyundai</option>
                    <option value="Chevrolet" <?php echo $vehicle['make'] == 'Chevrolet' ? 'selected' : ''; ?>>Chevrolet</option>
                </select>
            </div>
            <div class="form-group">
                <label for="model"><i class="fas fa-pencil-alt"></i> Model:</label>
                <input type="text" name="model" class="form-control" value="<?php echo htmlspecialchars($vehicle['model']); ?>" required>
            </div>
            <div class="form-group">
                <label for="year"><i class="fas fa-calendar-alt"></i> Year:</label>
                <select name="year" class="form-control" required>
                    <option value="" disabled>Select Year</option>
                    <?php
                    $current_year = date('Y');
                    for ($year = $current_year; $year >= 1900; $year--) {
                        echo "<option value='$year' " . ($vehicle['year'] == $year ? 'selected' : '') . ">$year</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="registration_number"><i class="fas fa-id-card"></i> Registration Number:</label>
                <input type="text" name="registration_number" class="form-control" value="<?php echo htmlspecialchars($vehicle['registration_number']); ?>" required>
            </div>
            <div class="form-group">
                <label for="color"><i class="fas fa-paint-brush"></i> Color:</label>
                <select name="color" class="form-control" required>
                    <option value="" disabled>Select Color</option>
                    <option value="Red" <?php echo $vehicle['color'] == 'Red' ? 'selected' : ''; ?>>Red</option>
                    <option value="Blue" <?php echo $vehicle['color'] == 'Blue' ? 'selected' : ''; ?>>Blue</option>
                    <option value="Black" <?php echo $vehicle['color'] == 'Black' ? 'selected' : ''; ?>>Black</option>
                    <option value="White" <?php echo $vehicle['color'] == 'White' ? 'selected' : ''; ?>>White</option>
                    <option value="Silver" <?php echo $vehicle['color'] == 'Silver' ? 'selected' : ''; ?>>Silver</option>
                </select>
            </div>
            <div class="form-group">
                <label for="mileage"><i class="fas fa-tachometer-alt"></i> Mileage (in km):</label>
                <input type="number" name="mileage" class="form-control" value="<?php echo htmlspecialchars($vehicle['mileage']); ?>" min="0" required>
            </div>
            <button type="submit" name="update_vehicle" class="btn btn-primary"><i class="fas fa-save"></i> Update Vehicle</button>
        </form>
        <div class="mt-4">
            <a href="view_vehicles.php" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Back to Vehicle List</a>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
