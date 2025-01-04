<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vehicle Maintenance Guide</title>
    <style>
        /* General Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            font-family: 'Poppins', sans-serif; 
           background-color: burlywood;
            color: #f1f1f1;
            line-height: 1.6;
        }

        h1 {
            text-align: center;
            margin-top: 30px;
            color: black;
            font-size: 2.5rem;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }

        .container {
            max-width: 1100px;
            margin: 0 auto;
            padding: 20px;
            border-radius: 50px;
        }

        .maintenance-item, .road-safety-item {
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin: 20px 0;
            padding: 20px;
            transition: transform 0.3s ease-in-out;
        }

        .maintenance-item:hover, .road-safety-item:hover {
            transform: scale(1.05);
        }

        .maintenance-header, .safety-header {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
        }

        .maintenance-icon, .road-safety-icon {
            font-size: 3rem;
            margin-right: 20px;
        }

        .maintenance-title, .safety-title {
            font-size: 1.8rem;
            font-weight: bold;
            color: #333;
        }

        .maintenance-description, .safety-description {
            font-size: 1rem;
            color: #333;
            line-height: 1.6;
            margin-bottom: 15px;
        }

        .maintenance-details, .road-safety-details {
            display: none;
            font-size: 1rem;
            color: #333;
            padding: 10px;
            background-color: #f0f0f0;
            border-radius: 5px;
        }

        .show-more-btn, .show-safety-btn {
            cursor: pointer;
            color: #007bff;
            font-weight: bold;
            text-decoration: underline;
            display: block;
            margin-top: 10px;
            text-align: center;
        }

        .show-more-btn:hover, .show-safety-btn:hover {
            color: #0056b3;
        }

        .back-to-dashboard {
            display: flex;
            align-items: center;
            margin-top: 30px;
            justify-content: center;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            font-size: 1.2rem;
            border: none;
            border-radius: 50px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .back-to-dashboard i {
            margin-right: 10px;
            font-size: 1.5rem;
        }

        .back-to-dashboard:hover {
            background-color:rgb(102, 142, 104);
        }

        .road-safety-section {
            background-color: rgba(158, 233, 88, 0.9);
            border-radius: 8px;
            padding: 20px;
            margin-top: 40px;
            display: none;
            animation: fadeIn 1s ease-in-out;
        }

        .road-safety-section h2 {
            color: #333;
            text-align: center;
            font-size: 2rem;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .road-safety-item {
            background-color: rgba(0, 123, 255, 0.1);
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            transition: transform 0.3s ease;
        }

        .road-safety-item:hover {
            transform: scale(1.05);
        }

        .road-safety-item i {
            font-size: 3rem;
            color: #007bff;
            margin-right: 20px;
        }

        .road-safety-item .safety-title {
            font-size: 1.5rem;
            font-weight: bold;
            color: #333;
        }

        .road-safety-item .safety-description {
            font-size: 1rem;
            color: #555;
        }

        /* Fade In Animation */
        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        /* Button Styles */
        .maintenance-item button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            font-size: 1rem;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .maintenance-item button:hover {
            background-color: #45a049;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .maintenance-item, .road-safety-item {
                padding: 15px;
            }

            h1 {
                font-size: 2rem;
            }

            .maintenance-header, .safety-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .maintenance-title, .safety-title {
                font-size: 1.5rem;
            }

            .maintenance-icon, .road-safety-icon {
                font-size: 2rem;
                margin-bottom: 10px;
            }

            .maintenance-description, .safety-description {
                font-size: 0.9rem;
            }
        }
    </style>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&family=Lora:wght@400;700&display=swap" rel="stylesheet">

</head>
<body>

    <div class="container">
        <h1>Vehicle Maintenance Guide</h1>

        <!-- Maintenance Section -->
        <div class="maintenance-item">
            <div class="maintenance-header">
                <i class="maintenance-icon fas fa-oil-can"></i>
                <h2 class="maintenance-title">Engine Oil Change</h2>
            </div>
            <p class="maintenance-description">
                Regular engine oil changes are essential to keeping your engine running smoothly and preventing overheating.
            </p>
            <div class="maintenance-details" id="oil-change-details">
                <ul>
                    <li><i class="fas fa-check-circle"></i> Check oil level regularly.</li>
                    <li><i class="fas fa-check-circle"></i> Change oil every 3,000 to 5,000 miles.</li>
                    <li><i class="fas fa-check-circle"></i> Use the correct oil grade recommended by your vehicle manufacturer.</li>
                    <li><i class="fas fa-check-circle"></i> Replace the oil filter during oil changes for better engine health.</li>
                </ul>
            </div>
            <span class="show-more-btn" onclick="toggleDetails('oil-change-details')">Show More</span>
        </div>

        <div class="maintenance-item">
            <div class="maintenance-header">
                <i class="maintenance-icon fas fa-tachometer-alt"></i>
                <h2 class="maintenance-title">Tire Pressure Check</h2>
            </div>
            <p class="maintenance-description">
                Keeping your tires inflated properly is crucial for safety, fuel efficiency, and tire longevity.
            </p>
            <div class="maintenance-details" id="tire-pressure-details">
                <ul>
                    <li><i class="fas fa-check-circle"></i> Check tire pressure monthly.</li>
                    <li><i class="fas fa-check-circle"></i> Inflate tires to the pressure specified in your vehicle's manual.</li>
                    <li><i class="fas fa-check-circle"></i> Inspect for uneven wear and tear.</li>
                    <li><i class="fas fa-check-circle"></i> Ensure proper tire rotation every 6,000 to 8,000 miles.</li>
                </ul>
            </div>
            <span class="show-more-btn" onclick="toggleDetails('tire-pressure-details')">Show More</span>
        </div>

        <!-- Road Safety Tips Section -->
        <button class="show-safety-btn" onclick="toggleSafetySection()">Show Road Safety Tips</button>

        <div class="road-safety-section" id="road-safety-section">
            <h2>Road Safety Tips</h2>

            <div class="road-safety-item">
                <i class="road-safety-icon fas fa-seatbelt"></i>
                <div>
                    <h3 class="safety-title">Always Wear Your Seatbelt</h3>
                    <p class="safety-description">Seatbelts save lives. Always make sure everyone in the vehicle is wearing their seatbelt before driving.</p>
                </div>
            </div>

            <div class="road-safety-item">
                <i class="road-safety-icon fas fa-speedometer"></i>
                <div>
                    <h3 class="safety-title">Obey Speed Limits</h3>
                    <p class="safety-description">Driving within speed limits is crucial for your safety and the safety of others on the road.</p>
                </div>
            </div>

            <div class="road-safety-item">
                <i class="road-safety-icon fas fa-road"></i>
                <div>
                    <h3 class="safety-title">Check Road Conditions</h3>
                    <p class="safety-description">Be aware of road conditions, traffic signs, and signals to ensure safe driving, especially in adverse weather.</p>
                </div>
            </div>

            <div class="road-safety-item">
                <i class="road-safety-icon fas fa-bicycle"></i>
                <div>
                    <h3 class="safety-title">Watch Out for Cyclists</h3>
                    <p class="safety-description">Always be aware of cyclists on the road. Keep a safe distance and give them enough space to move safely.</p>
                </div>
            </div>
        </div>

        <!-- Back to Dashboard Button -->
        <button class="back-to-dashboard" onclick="window.location.href='user_dashboard.php'">
            <i class="fas fa-arrow-left"></i> Back to Dashboard
        </button>
    </div>

    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>

    <script>
        // Toggle Maintenance Details
        function toggleDetails(id) {
            const details = document.getElementById(id);
            const button = document.querySelector(`#${id} + .show-more-btn`);
            
            if (details.style.display === "none" || details.style.display === "") {
                details.style.display = "block";
                button.textContent = "Show Less";
            } else {
                details.style.display = "none";
                button.textContent = "Show More";
            }
        }

        // Toggle Road Safety Tips Section
        function toggleSafetySection() {
            const safetySection = document.getElementById('road-safety-section');
            const safetyButton = document.querySelector('.show-safety-btn');
            
            if (safetySection.style.display === "none" || safetySection.style.display === "") {
                safetySection.style.display = "block";
                safetyButton.textContent = "Hide Road Safety Tips";
            } else {
                safetySection.style.display = "none";
                safetyButton.textContent = "Show Road Safety Tips";
            }
        }
    </script>

</body>
</html>
