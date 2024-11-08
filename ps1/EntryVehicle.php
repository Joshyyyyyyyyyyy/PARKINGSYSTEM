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

$name = $_POST["name"] ?? '';
$vehicle_type = $_POST["vehicle_type"] ?? '';
$registration = $_POST["registration"] ?? '';
$slot_occupied = $_POST["slot_occupied"] ?? '';
$date = $_POST["date"] ?? '';
$price = $_POST["price"] ?? '';

$errorMessage = "";
$successMessage = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    do {
        if (empty($name) || empty($vehicle_type) || empty($registration) || empty($slot_occupied) || empty($date)) {
            $errorMessage = "All the fields are required";
            break;
        }


        // Check if the selected slot is available
        $checkSlotQuery = "SELECT status FROM parking_slots WHERE slot_number = '$slot_occupied'";
        $slotResult = $connection->query($checkSlotQuery);

        if ($slotResult->num_rows == 0) {
            $errorMessage = "Selected slot does not exist.";
            break;
        }

        $slotData = $slotResult->fetch_assoc();
        if ($slotData['status'] === 'occupied') {
            $errorMessage = "Selected slot is already occupied.";
            break;
        }

        // Add new client to the database
        $sql = "INSERT INTO clients (name, vehicle_type, registration, slot_occupied, date, price) 
                VALUES ('$name', '$vehicle_type', '$registration', '$slot_occupied', '$date','$price')";
        $result = $connection->query($sql);

        if (!$result) {
            $errorMessage = "Invalid query: " . $connection->error;
            break;
        }

        // Update the slot status to occupied
        $updateSlotQuery = "UPDATE parking_slots SET status = 'occupied' WHERE slot_number = '$slot_occupied'";
        $connection->query($updateSlotQuery);

        // Get the ID of the newly added client
        $clientId = $connection->insert_id;

        // Redirect to the receipt page with the new client ID and the price
        header("Location: InVehicle.php?id=$clientId&price=$price");
        exit;

    } while (false);
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
    <img src="newlogo.png" alt="Parking System Logo" width="200"> 
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
    <li class="active">
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
        <a href="index.php">
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
    <h2>New Client</h2>
    <?php if (!empty($errorMessage)): ?>
        <div class="alert alert-warning alert-dismissible fade show">
            <strong><?= $errorMessage ?></strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>
    <form method="POST">
        <div class="form-group">
            <label>Name</label>
            <input type="text" class="form-control" name="name" value="<?= htmlspecialchars($name); ?>">
        </div>
        <div class="form-group">
            <label>Vehicle Type</label>
            <select class="form-control" name="vehicle_type">
                <option value="">Select Vehicle Type</option>
                <option value="4wheels" <?= $vehicle_type === '4wheels' ? 'selected' : ''; ?>>4 Wheeler</option>
                <option value="2wheels" <?= $vehicle_type === '2wheels' ? 'selected' : ''; ?>>2 Wheeler</option>
            </select>
        </div>
        <div class="form-group">
            <label>Registration</label>
            <input type="text" class="form-control" name="registration" value="<?= htmlspecialchars($registration); ?>">
        </div>
        <div class="form-group">
            <label>Slot Occupied</label>
            <input type="text" class="form-control" name="slot_occupied" value="<?= htmlspecialchars($slot_occupied); ?>">
        </div>
        <div class="form-group">
            <label>Date</label>
            <input type="date" class="form-control" name="date" value="<?= htmlspecialchars($date); ?>">
        </div>
        <div class="form-group">
            <label>Price</label>
            <input type="text" class="form-control" name="price" value="<?= htmlspecialchars($price); ?>">
        </div>

        <div class="form-buttons">
            <button type="submit" class="btn btn-primary">Submit</button>
            <a href="InVehicle.php" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
    <style>
      .main-content {
        flex-grow: 1;
        padding: 30px;
        background-color: #fff;
        max-width: 1800px;
        margin: 40px auto;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    h2 {
        text-align: center;
        color: #1b3ba3;
    }

    .form-group {
        margin-bottom: 15px;
    }

    .form-control {
        padding: 10px;
        font-size: 1em;
    }

    .form-buttons {
        display: flex;
        gap: 10px;
        justify-content: center;
        margin-top: 20px;
    }

    .btn {
        padding: 10px 20px;
        font-size: 1em;
    }

    .btn-primary {
        width: 100%;
        background-color: #1b3ba3;
        border: none;
    }

    .btn-secondary {
        background-color: #dc3545;
        color: white;
        width: 100%;
    }

    .alert {
        margin: 15px 0;
    }
    </style>
</div>
<script src="admin.js"></script>
</body>
</html>