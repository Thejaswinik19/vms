<?php
include('db.php');
session_start();

if (!isset($_SESSION['UserID'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['UserID'];
$query = "SELECT * FROM vehicles WHERE owner_id = ?";
$stmt = $conn->prepare($query);

if ($stmt === false) {
    die('MySQL prepare error: ' . $conn->error);
}

$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Vehicles</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
       body {
    
    background-color: #f8f9fa;
    background-image: url('images/yv2.jpg');
    image-resolution: from-image;
    background-repeat: no-repeat;
    background-size: cover;  /* Ensures the background image covers the entire screen */
    background-position: center center;  /* Centers the background image */
    background-attachment: fixed;  /* Keeps the background fixed while scrolling */
    
      /* Sets the default text color for contrast */
     /* Optional: Choose a font that works well with the background */
    margin: 0;
    padding: 0;
    height: 100vh;  /* Ensures the body takes the full height of the viewport */
    display: flex;
    justify-content: center;
    align-items: center;
}

   

        .container {
            margin-bottom: 400px;
        }

        h2 {
            text-align: center;
            font-family:   sans-serif;
            margin-top: 0px;
            margin-bottom: 30px;
            color:rgb(254, 216, 2);
            font-weight: bold;
            text-shadow: 2px 2px 4px rgba(11, 11, 11, 0.2);
        }

        .table {
            border-radius: 10px;
            overflow: hidden;
        }

       
        .table td {
            text-align: center;
            background-color: white;
        }

        .table thead {
            background-color:rgb(36, 65, 96);
            color: white;
        }

        .table tbody tr:hover {
            background-color:rgb(223, 107, 107);
            cursor: pointer;
        }

        .table td {
            vertical-align: middle;
        }

        .btn-warning {
            color: #fff;
            background-color: #ffc107;
            border-color: #ffc107;
        }

        .btn-warning:hover {
            background-color: #e0a800;
            border-color: #d39e00;
        }

        .btn-disabled {
            background-color: #ccc;
            border-color: #ccc;
            cursor: not-allowed;
        }

        
        .text-center{
            font-size: 25px;
            color:rgb(248, 237, 237)!important;
            margin-bottom: 100px;
            font-weight: bold;
        }
        .back-link:hover {
            text-decoration: underline;
        }

        @media (max-width: 768px) {
            .table th, .table td {
                font-size: 14px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Your Vehicles</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Make</th>
                    <th>Model</th>
                    <th>Year</th>
                    <th>Registration Number</th>
                    <th>Color</th>
                    <th>Status</th>
                    <th>Mileage</th>
                    <th>Actions</th> <!-- Add a new column for actions -->
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['make']); ?></td>
                        <td><?php echo htmlspecialchars($row['model']); ?></td>
                        <td><?php echo htmlspecialchars($row['year']); ?></td>
                        <td><?php echo htmlspecialchars($row['registration_number']); ?></td>
                        <td><?php echo htmlspecialchars($row['color']); ?></td>
                        <td><?php echo htmlspecialchars($row['status']); ?></td>
                        <td><?php echo htmlspecialchars($row['mileage']); ?> km</td>
                        <td>
                            <?php if ($row['status'] == 'Inactive'): ?>
                                <!-- If status is inactive, disable the button -->
                                <button class="btn btn-warning btn-sm btn-disabled" disabled>Edit</button>
                            <?php else: ?>
                                <!-- If status is not inactive, show the edit button -->
                                <a href="edit_vehicle.php?vehicle_id=<?php echo $row['vehicle_id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <div class="text-center mt-4">
            <a href="user_dashboard.php" style="color:rgb(248, 249, 250)"><i class="fas fa-arrow-left"></i> Back to Dashboard</a>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
