<?php
session_start();

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    $_SESSION['notification'] = "Access denied. Redirected to login.";
    header("Location: index.php");
    exit();
}
$servername = "localhost";
$username = "root";
$password = "";
$database = "database1";

// Create a connection
$connection = new mysqli($servername, $username, $password, $database);

// Check for connection errors
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// Query to get available slots
$availableSlotsQuery = "SELECT COUNT(*) AS available_slots FROM parking_slots WHERE status = 'available'";
$availableSlotsResult = $connection->query($availableSlotsQuery);
$availableSlots = 0;
if ($availableSlotsResult) {
    $availableSlotsRow = $availableSlotsResult->fetch_assoc();
    $availableSlots = $availableSlotsRow['available_slots'];
}

// Query to get occupied slots
$occupiedSlotsQuery = "SELECT COUNT(*) AS occupied_slots FROM parking_slots WHERE status = 'occupied'";
$occupiedSlotsResult = $connection->query($occupiedSlotsQuery);
$occupiedSlots = 0;
if ($occupiedSlotsResult) {
    $occupiedSlotsRow = $occupiedSlotsResult->fetch_assoc();
    $occupiedSlots = $occupiedSlotsRow['occupied_slots'];
}

// Query to get vehicles in
$vehicleInQuery = "SELECT COUNT(*) AS vehicle_in FROM clients WHERE date_out IS NULL";
$vehicleInResult = $connection->query($vehicleInQuery);
$vehicleIn = 0;
if ($vehicleInResult) {
    $vehicleInRow = $vehicleInResult->fetch_assoc();
    $vehicleIn = $vehicleInRow['vehicle_in'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="icon" type="image/icon" href="newlogo.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">  
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <title>Parking System</title>
</head>
<body>
<div class="sidebar" id="sidebar">
 <div class="logo">
    <img src="newlogo.png" alt="Parking System Logo" width="200" > 
</div>
<ul class="menu">
        <li class="active">
            <a href="admin_dashboard.php">
                <i class="fas fa-gauge"></i>
                <span>Dashboard</span>
            </a>
        </li>
        <li>
            <a href="parkingSlot.php">
                <i class="bi bi-car-front-fill"></i>
                <span>Parking Slot</span>
            </a>
        </li>
        <li>
            <a href="EntryVehicle.php">
                <i class="fa fa-xl fa-car color-blue"></i>
                <span>Vehicles Entry</span>
            </a>
        </li>
        <li>
            <a href="InVehicle.php">
                <i class="fa fa-xl fa-toggle-on color-orange"></i>
                <span>IN Vehicles</span>
            </a>
        </li>
        <li>
            <a href="outVehicle.php">
                 <i class="fa fa-xl fa-toggle-off color-teal"></i>
                  <span>OUT Vehicles</span>
             </a>
        </li>
        <li>
            <a href="informationManagement.php">
                <i class="fas fa-database"></i>
                <span>Information Management</span>                
            </a>
        </li>
        <li>
            <a href="#">
                <i class="fas fa-file-alt"></i>
                <span>View Report</span>                
            </a>
        </li>
        <li>
            <a href="totalIncome.php">
                <i class="fas fa-dollar-sign"></i>
                    <span>Total Income</span>
            </a>
        </li>
        <li class="logout">
            <a href="logout.php">
                <i class="fas fa-sign-out-alt"></i>
                    <span>Logout</span>
            </a>
        </li>
    </ul>
</div>
<div class="toggle-btn" id="toggleBtn">
    <i class="fas fa-bars"></i>
</div>
<section>
<div class="container my-5">
    <div class="row">
        <!-- Available Slots Container -->
        <div class="col-md-4">
            <div class="card text-white bg-success mb-4">
                <div class="card-header">Available Slots</div>
                <div class="card-body">
                    <h3 class="card-title"><?= $availableSlots ?> Slot(s)</h3>
                    <p class="card-text">Currently available parking slots.</p>
                </div>
            </div>
        </div>

        <!-- Occupied Slots Container -->
        <div class="col-md-4">
            <div class="card text-white bg-danger mb-4">
                <div class="card-header">Occupied Slots</div>
                <div class="card-body">
                    <h3 class="card-title"><?= $occupiedSlots ?> Slot(s)</h3>
                    <p class="card-text">Currently occupied parking slots.</p>
                </div>
            </div>
        </div>

        <!-- Vehicles In Container -->
        <div class="col-md-4">
            <div class="card text-white bg-info mb-4">
                <div class="card-header">Vehicles In</div>
                <div class="card-body">
                    <h3 class="card-title"><?= $vehicleIn ?> Vehicle(s)</h3>
                    <p class="card-text">Vehicles currently in the parking system.</p>
                </div>
            </div>
        </div>
    </div>
</div>
</section>

<script src="admin.js"></script>
</body>
</body>
</html>
