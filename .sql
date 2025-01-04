-- Create Users Table
CREATE TABLE users (
    id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,                -- User's full name
    phone VARCHAR(20) DEFAULT NULL,              -- User's phone number
    address TEXT DEFAULT NULL,                   -- User's address
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);


-- Create Admin Table
CREATE TABLE admin (
    id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

-- Create Vehicles Table
CREATE TABLE vehicles (
    vehicle_id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    owner_id INT(11) NOT NULL,
    make VARCHAR(100) NOT NULL,
    model VARCHAR(100) NOT NULL,
    year INT(11) NOT NULL,
    registration_number VARCHAR(50) NOT NULL,
    color VARCHAR(50) DEFAULT NULL,
    mileage INT(11) DEFAULT NULL,
    status VARCHAR(50) DEFAULT 'Active',
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (owner_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Create Service Types Table
CREATE TABLE service_types (
    service_id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    service_name VARCHAR(100) NOT NULL,
    description TEXT NOT NULL,
    service_interval_days INT(11) NOT NULL -- Assumed column for intervals
);


-- Create Services Table
CREATE TABLE services (
    service_id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    vehicle_id INT(11) NOT NULL,
     admin_id INT(11) NOT NULL,
    service_type_id INT(11) NOT NULL,
    service_date DATE NOT NULL,
    cost DECIMAL(10,2) DEFAULT NULL,
    next_service_due DATE DEFAULT NULL,
    last_service_date DATE DEFAULT NULL,
    status VARCHAR(10) NOT NULL DEFAULT 'pending',
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (admin_id) REFERENCES admin(id) ON DELETE CASCADE,
    FOREIGN KEY (vehicle_id) REFERENCES vehicles(vehicle_id) ON DELETE CASCADE,
    FOREIGN KEY (service_type_id) REFERENCES service_types(service_id)
);



-- Trigger: Update Vehicle Status to Inactive if Mileage > 100,000
DELIMITER //
CREATE TRIGGER update_vehicle_status
BEFORE UPDATE ON vehicles
FOR EACH ROW
BEGIN
    IF NEW.mileage > 100000 THEN
        SET NEW.status = 'Inactive';
    END IF;
END//
DELIMITER ;








-- Insert Admin Data
INSERT INTO admin (username, password) VALUES ('admin', MD5('admin123'));

-- Insert Users Data
INSERT INTO users (username, email, password)
VALUES
('john_doe', 'john.doe@example.com', MD5('password123')),
('jane_smith', 'jane.smith@example.com', MD5('password456'));

-- Insert Vehicles Data
INSERT INTO vehicles (owner_id, make, model, year, registration_number, color, mileage)
VALUES
(1, 'Toyota', 'Corolla', 2020, 'KA01AB1234', 'Red', 25000),
(2, 'Honda', 'Civic', 2019, 'KA02CD5678', 'Blue', 30000);
INSERT INTO service_types (service_name, description, service_interval_days) 
VALUES
    ('Oil Change', 'Regular oil change to maintain engine health.', 365), 
    ('Tire Rotation', 'Rotating tires to ensure even wear.', 180),
    ('Brake Inspection', 'Check the condition of brake pads and discs.', 180),
    ('Engine Check', 'Comprehensive engine diagnostics and check-up.', 365),
    ('Transmission Fluid Change', 'Change transmission fluid for smooth gear shifting.', 730);




INSERT INTO services (vehicle_id, service_type_id, service_date, cost, status,admin_id)
VALUES
(1, 1, '2024-01-15', 50.00, 'pending',1),
(1, 2, '2024-06-10', 100.00,  'pending',1),
(2, 3, '2024-02-20', 200.00,  'pending',1);
