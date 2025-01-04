# Vehicle Management System (VMS)

A web-based application for managing users, vehicles, services, and admins. The system allows administrators to manage vehicle information, services, and users, and provides a complete solution for managing vehicle maintenance.

---

## 📌 Features

- **User Management**: Add and manage users.
- **Vehicle Management**: Add, view, update, and delete vehicles.
- **Service Management**: Track vehicle service history and manage upcoming services.
- **Admin Panel**: Admins can manage users, services, and vehicle records.
- **Vehicle Status**: Automatically update vehicle status to 'Inactive' if mileage exceeds 100,000 km.
- **Service Types**: Define service types with intervals for vehicle maintenance.

---

## 🛠️ Technologies Used

- **Frontend**: HTML, CSS, JavaScript (optional for enhancements)
- **Backend**: PHP
- **Database**: MySQL
- **Local Server**: XAMPP

---


---

## 🚀 Getting Started

### Prerequisites

- XAMPP installed on your system.
- Basic knowledge of PHP and MySQL.

### Installation

1. **Clone the Repository**
   ```bash
   git clone https://github.com/yourusername/vms.git

2. **Move to XAMPP's htdocs Folder**

Copy the vms folder to your htdocs directory.
3. **Set Up the Database**

Open phpMyAdmin.
Create a new database named vms.
Import the .sql file located in the vms project folder.
4. **Configure Database Connection**

Update the db.php file with your database credentials:
php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "vms";

5. **Run the Application**

Start Apache and MySQL from the XAMPP Control Panel.
Visit http://localhost/vms in your browser.

