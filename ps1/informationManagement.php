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

// Retrieve all client information, including checked-out clients
$sql = "SELECT * FROM clients";
$result = $connection->query($sql);
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
        <li class="active">
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
<div class="container my-5">
    <h2 class="text-center">Client Information Management</h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Client ID</th>
                <th>Name</th>
                <th>Vehicle Type</th>
                <th>Registration Number</th>
                <th>Slot Occupied</th>
                <th>Date</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['id']); ?></td>
                        <td><?php echo htmlspecialchars($row['name']); ?></td>
                        <td><?php echo htmlspecialchars($row['vehicle_type']); ?></td>
                        <td><?php echo htmlspecialchars($row['registration']); ?></td>
                        <td><?php echo htmlspecialchars($row['slot_occupied']); ?></td>
                        <td><?php echo htmlspecialchars($row['date']); ?></td>
                        <td><?php echo isset($row['checked_out']) && $row['checked_out'] ? 'Checked Out' : 'Active'; ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="7" class="text-center">No client data found.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<style>
    .container {
    margin-top: 20px;
    max-width: 1800px;
}

.table {
    border-radius: 0.5rem; 
    overflow: hidden; 
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    background-color: white; 
}

.table thead th {
    background-color: #1b3ba3; 
    color: white; 
    padding: 15px; 
    text-align: left; 
}

.table tbody tr {
    transition: background-color 0.3s; 
}

.table tbody tr:hover {
    background-color: rgba(0, 123, 255, 0.1); 
}

.table tbody td {
    padding: 12px; 
    color: #333; 
    vertical-align: middle; 
}

.table tbody td a {
    margin-right: 5px; 
}

.table .btn {
    padding: 5px 10px; 
}

.btn-primary {
    background-color: #1b3ba3; 
    border: none; 
}

.btn-primary:hover {
    background-color: #0056b3; 
}

.btn-danger {
    background-color: #dc3545; 
}

.btn-danger:hover {
    background-color: #c82333; 
}
</style>
</div>

<script src="admin.js">
    
</script>
</body>
</body>
</html>

<?php $connection->close(); ?>
