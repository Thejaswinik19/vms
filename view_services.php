<?php
include('db.php');
session_start();

if (!isset($_SESSION['UserID'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['UserID'];

$query = "SELECT s.service_id, s.vehicle_id, s.service_date, st.service_name, s.status ,s.next_service_due
          FROM services s 
          JOIN vehicles v ON s.vehicle_id = v.vehicle_id 
          JOIN service_types st ON s.service_type_id = st.service_id
          WHERE v.owner_id = ?";
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
    <title>View Services</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
  body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    padding-top: 20px;
    color: #444;
    position: relative;
    overflow: hidden;
    background-image: url('images/vs.jpg'); /* Replace with your background image */
    background-size:contain;
    
    background-attachment: fixed;
   background-repeat: ;
    z-index: -1; 
}

        .container {
            background-color: rgba(255, 255, 255, 0.85); /* Lighter semi-transparent background */
            padding: 30px;
            border-radius: 30px;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
            max-width: 1200px;
            margin: 0 auto;
            margin-top: 50px;
        }

        h2 {
            color:rgb(4, 23, 4); /* Fresh green color */
            font-size: 2.5rem;
            font-weight: bold;
            text-align: center;
            margin-bottom: 20px;
            letter-spacing: 1px;
        }

        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }

        th, td {
            text-align: center;
            vertical-align: middle;
            padding: 12px;
        }

        th {
            background-color:rgb(41, 65, 127); /* Green header background */
            color: white;
            font-size: 1.1rem;
        }

        td {
            background-color: #f9f9f9;
            font-size: 1rem;
        }

        td.status-column {
            width: 200px;
            color: #333;
        }

        .status {
            font-weight: bold;
            font-size: 18px;
            color: #333;
        }

        .btn-back {
            background-color:rgb(46, 62, 75); /* Blue button */
            color: white;
            border-radius: 50px;
            padding: 12px 25px;
            text-decoration: none;
            display: inline-block;
            margin-bottom: 20px;
            font-size: 1rem;
        }

        .btn-back:hover {
            background-color:rgb(126, 142, 157); /* Darker blue on hover */
            transform: translateY(-2px);
        }

        .btn-back i {
            margin-right: 8px;
        }

        /* Hover effect on the table rows */
        tr:hover {
            background-color: #e1f5fe;
            cursor: pointer;
        }

        /* Optional text effects for headings */
        h2:hover {
            color: #388E3C; /* Darker green on hover */
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Back to Dashboard Button -->
        <a href="user_dashboard.php" class="btn-back">
            <i class="fas fa-home"></i> Back to Dashboard
        </a>

        <h2 class="text-center">Your Services</h2>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Service ID</th>
                    <th>Vehicle ID</th>
                    <th>Date</th>
                    
                    <th>Service Type</th>
                    <th>Status</th>
                    <th>Next Service Date</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['service_id']); ?></td>
                        <td><?php echo htmlspecialchars($row['vehicle_id']); ?></td>
                        <td><?php echo htmlspecialchars($row['service_date']); ?></td>
                        
                        <td><?php echo htmlspecialchars($row['service_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['status']); ?></td>
                        <td><?php echo htmlspecialchars($row['next_service_due']); ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
   

    <!-- Optional Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
