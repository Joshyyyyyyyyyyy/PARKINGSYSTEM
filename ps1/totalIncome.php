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

$connection = new mysqli($servername, $username, $password, $database);

if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

$totalIncomeQuery = "SELECT SUM(price) AS total_income FROM clients";
$totalIncomeResult = $connection->query($totalIncomeQuery);

$total_income = 0;
if ($totalIncomeResult) {
    $totalIncomeRow = $totalIncomeResult->fetch_assoc();
    $total_income = $totalIncomeRow['total_income'] ?? 0;
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
        <li>
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
        <li class="active">
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
<div class="main-content">
    <h2 class="header-title">Total Income</h2>
    <div class="income-display">
        Total Income: <span class="text-success"><?= number_format($total_income, 2); ?> PHP</span>
    </div>
   
</div>
<style>
        .main-content {
            max-width: 800px;
            margin: 40px auto;
            padding: 30px;
            background-color: #f8f9fa;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            text-align: center;
        }

        .income-display {
            font-size: 24px;
            font-weight: bold;
            color: #1b3ba3;
            margin-top: 20px;
        }

        .header-title {
            color: #1b3ba3;
            font-size: 28px;
            margin-bottom: 20px;
        }
    </style>
<script src="admin.js"></script>
</body>
</body>
</html>
