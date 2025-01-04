<?php
include('db.php');
session_start();

// Check if user is logged in
if (!isset($_SESSION['UserID'])) {
    header("Location: login.php");
    exit();
}

// Handle adding a new vehicle
// Handle adding a new vehicle
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_vehicle'])) {
    $user_id = $_SESSION['UserID'];
    $make = $_POST['make'];
    $model = $_POST['model'];
    $year = $_POST['year'];
    $registration_number = $_POST['registration_number'];
    $color = $_POST['color'];
    $mileage = $_POST['mileage'];

    // Validate the registration number format (e.g., KA03EF2347)
    if (!preg_match('/^[A-Za-z]{2}\d{2}[A-Za-z]{2}\d{4}$/', $registration_number)) {
        echo "<script>alert('Invalid registration number format. Please use the format: KA03EF2347');</script>";
    } else {
        $add_vehicle_query = "INSERT INTO vehicles (owner_id, make, model, year, registration_number, color, mileage) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($add_vehicle_query);

        if ($stmt === false) {
            die('MySQL prepare error: ' . $conn->error);
        }

        $stmt->bind_param("isssssi", $user_id, $make, $model, $year, $registration_number, $color, $mileage);

        if ($stmt->execute()) {
            echo "<script>alert('Vehicle added successfully!'); window.location.href='view_vehicles.php';</script>";
        } else {
            echo "<script>alert('Failed to add vehicle. Please try again.');</script>";
        }
        $stmt->close();
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Vehicle</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color:rgba(90, 228, 212, 0.9);
            color: #fff;
            margin-top: 30px;
        }

        .container {
            background: rgba(255, 255, 255, 0.9);
            color: #333;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
            max-width: 700px;
            margin: auto;
        }

        h2 {
            color:rgb(17, 82, 203);
            font-weight: bold;
            text-align: center;
            margin-bottom: 30px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
        }

        .form-group label {
            font-weight: bold;
        }

        .form-control {
            border-radius: 10px;
            border: 1px solid #ddd;
            padding: 10px;
            font-size: 16px;
        }

        .btn-primary {
            background: #6a11cb;
            border-color: #6a11cb;
            padding: 12px 25px;
            font-size: 16px;
            border-radius: 10px;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background: #4a0ca7;
            border-color: #4a0ca7;
        }

        .btn-secondary {
            background: #444;
            border-color: #444;
            padding: 12px 25px;
            font-size: 16px;
            border-radius: 10px;
            transition: all 0.3s ease;
        }

        .btn-secondary:hover {
            background: #333;
            border-color: #333;
        }

        .form-group i {
            margin-right: 10px;
            color: #6a11cb;
        }

        .text-center a {
            font-size: 20px;
            color:rgb(13, 14, 13);
            text-decoration: none;
        }

        .text-center a:hover {
            text-decoration: underline;
        }

        .form-control:focus {
            box-shadow: 0 0 8px rgba(106, 17, 203, 0.5);
            border-color: #6a11cb;
        }

        small.text-danger {
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Add a New Vehicle</h2>
        <form method="POST">
            <div class="form-group">
                <label for="make"><i class="fas fa-car"></i> Make:</label>
                <select name="make" class="form-control" required>
                    <option value="" disabled selected>Select Make</option>
                    <option value="Toyota">Toyota</option>
                    <option value="Honda">Honda</option>
                    <option value="Ford">Ford</option>
                    <option value="Hyundai">Hyundai</option>
                    <option value="Chevrolet">Chevrolet</option>
                </select>
            </div>
            <div class="form-group">
                <label for="model"><i class="fas fa-pencil-alt"></i> Model:</label>
                <input type="text" name="model" class="form-control" placeholder="Enter Model" required>
            </div>
            <div class="form-group">
                <label for="year"><i class="fas fa-calendar-alt"></i> Year:</label>
                <select name="year" class="form-control" required>
                    <option value="" disabled selected>Select Year</option>
                    <?php
                    $current_year = date('Y');
                    for ($year = $current_year; $year >= 1900; $year--) {
                        echo "<option value='$year'>$year</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="registration_number"><i class="fas fa-id-card"></i> Registration Number:</label>
                <input type="text" name="registration_number" id="registration_number" class="form-control" placeholder="Enter Registration Number (e.g., KA03EF2347)" required>
                <small id="registration_error" class="text-danger" style="display:none;">Invalid registration number format. Please use the format: AB00CD1234</small>
            </div>
            <div class="form-group">
                <label for="color"><i class="fas fa-paint-brush"></i> Color:</label>
                <select name="color" class="form-control" required>
                    <option value="" disabled selected>Select Color</option>
                    <option value="Red">Red</option>
                    <option value="Blue">Blue</option>
                    <option value="Black">Black</option>
                    <option value="White">White</option>
                    <option value="Silver">Silver</option>
                </select>
            </div>
            <div class="form-group">
                <label for="mileage"><i class="fas fa-tachometer-alt"></i> Mileage (in km):</label>
                <input type="number" name="mileage" class="form-control" placeholder="Enter Mileage" min="0" required>
            </div>
            <button type="submit" name="add_vehicle" class="btn btn-primary"><i class="fas fa-plus"></i> Add Vehicle</button>
        </form>
        <div class="mt-4 text-center">
            <a href="view_vehicles.php"><i class="fas fa-arrow-left"></i> Back to Vehicle List</a>
        </div>
    </div>

    <script>
        document.getElementById('registration_number').addEventListener('input', function() {
            var regNumber = this.value;
            var regex = /^[A-Za-z]{2}\d{2}[A-Za-z]{2}\d{4}$/;
            var errorMessage = document.getElementById('registration_error');

            if (regex.test(regNumber)) {
                errorMessage.style.display = 'none';
            } else {
                errorMessage.style.display = 'block';
            }
        });
    </script>
</body>
</html>

