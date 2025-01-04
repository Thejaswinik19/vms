<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vehicle Record Management System</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/indexStyle.css">
</head>
<body>

    <!-- Header with Navigation -->
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <a class="navbar-brand" href="#"><i class="fas fa-car"></i> Vehicle Management</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
    <li class="nav-item active">
        <a class="nav-link" href="#">Home</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="login.php">Login</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="register.php">Register</a>
    </li>
   
    <li class="nav-item">
        <a class="btn btn-outline-warning nav-link" href="adminLogin.php"><i class="fas fa-user-shield"></i> Admin</a>
    </li>
</ul>

            </div>
        </nav>
    </header>

    <!-- Carousel Section -->
    <section class="carousel-section mt-3">
        <div id="vehicleCarousel" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="car1.jpg" class="d-block w-100" alt="Car 1">
                    <div class="carousel-caption">
                        <h3>Manage Your Vehicles Easily</h3>
                        <p>Track vehicle records, maintenance, and much more!</p>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="bg1.jpg" class="d-block w-100" alt="Car 2">
                    <div class="carousel-caption">
                        <h3>Secure and Reliable</h3>
                        <p>Advanced tools for vehicle management.</p>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="car3.jpg" class="d-block w-100" alt="Car 3">
                    <div class="carousel-caption">
                        <h3>Stay Organized</h3>
                        <p>All your vehicle data in one place.</p>
                    </div>
                </div>
            </div>
            <a class="carousel-control-prev" href="#vehicleCarousel" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            </a>
            <a class="carousel-control-next" href="#vehicleCarousel" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
            </a>
        </div>
    </section>

    <!-- Features Section -->
    <section class="container mt-5">
        <h2 class="text-center mb-4">Our Features</h2>
        <div class="row text-center">
            <div class="col-md-4">
                <i class="fas fa-clipboard-list fa-3x mb-3 text-primary"></i>
                <h4>Record Management</h4>
                <p>Keep track of all vehicle information, including owner details and maintenance logs.</p>
            </div>
            <div class="col-md-4">
                <i class="fas fa-tools fa-3x mb-3 text-success"></i>
                <h4>Maintenance Alerts</h4>
                <p>Receive reminders for vehicle maintenance and servicing.</p>
            </div>
            <div class="col-md-4">
                <i class="fas fa-lock fa-3x mb-3 text-danger"></i>
                <h4>Secure System</h4>
                <p>Protected and secure management system for reliable use.</p>
            </div>
        </div>
    </section>

    <!-- Cards Section -->
    <section class="container mt-5 mb-5">
        <h2 class="text-center mb-4">Why Choose Us?</h2>
        <div class="row">
            <div class="col-md-4">
                <div class="card shadow">
                    <img src="images/feature1.jpg" class="card-img-top" alt="Feature 1">
                    <div class="card-body">
                        <h5 class="card-title">Easy Access</h5>
                        <p class="card-text">Access your vehicle records anytime, anywhere.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow">
                    <img src="images/feature2.jpg" class="card-img-top" alt="Feature 2">
                    <div class="card-body">
                        <h5 class="card-title">Customizable</h5>
                        <p class="card-text">Personalized vehicle reports and features.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow">
                    <img src="images/feature3.jpg" class="card-img-top" alt="Feature 3">
                    <div class="card-body">
                        <h5 class="card-title">24/7 Support</h5>
                        <p class="card-text">We provide round-the-clock support for your queries.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-dark text-white text-center py-3">
        <p>&copy; 2024 Vehicle Record Management System | All Rights Reserved</p>
        <p>
            <a href="#" class="text-white mx-2"><i class="fab fa-facebook"></i></a>
            <a href="#" class="text-white mx-2"><i class="fab fa-twitter"></i></a>
            <a href="#" class="text-white mx-2"><i class="fab fa-instagram"></i></a>
        </p>
    </footer>

    <!-- Bootstrap and JS Scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
