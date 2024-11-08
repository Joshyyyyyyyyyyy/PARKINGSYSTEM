<?php
session_start();

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'attendant') {
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

$sql = "SELECT * FROM clients WHERE slot_occupied IS NOT NULL";
$result = $connection->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="admins.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="icon" type="image/icon" href="newlogo.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">  
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <title>Parking System</title>
</head>

<body>
<div class="topnav">
    <a class="name">Out Vehicle</a>
        <a href="parking_attendant_dashboard.php">Tutorial</a>
        <a href="parking_attendant_dashboard.php">About</a>
        <div class="dropdown">
            <button class="account-btn" onclick="toggleDropdown()">Account</button>
            <div id="myDropdown" class="dropdown-content">
                <div class="user-info">
                    <div class="user-name">Parking attendant</div>
                    <div class="user-id">Tester</div>
                </div>
                <div class="divider"></div>
                <a href="logout.php">
                       <i class="fas fa-sign-out-alt"></i>
                           <span>Logout</span>
                   </a>
                
            </div>
        </div>
      </div>
      <div class="sidebar" id="sidebar">
        <div class="logo">
           <img src="test2.png" alt="Parking System Logo" width="150" > 
           <li>
                   <a>
                       <span>Parking Attendant</span>
                   </a>
               </li>
       </div>
       <br>
       <ul class="menu">
               <li>
                   <a href="parking_attendant_dashboard.php">
                       <i class="fas fa-gauge"></i>
                       <span>Dashboard</span>
                   </a>
               </li>
               <li>
                   <a href="attendantparkingSlot.php">
                       <i class="bi bi-car-front-fill"></i>
                       <span>Parking Slot</span>
                   </a>
               </li>
               <li>
                   <a href="attendantEntryVehicle.php">
                       <i class="fa fa-xl fa-car color-blue"></i>
                       <span>Vehicles Entry</span>
                   </a>
               </li>
               <li>
                   <a href="attendantInVehicle.php">
                       <i class="fa fa-xl fa-toggle-on color-orange"></i>
                       <span>IN Vehicles</span>
                   </a>
               </li>
               <li class="active">
                   <a href="attendantoutVehicle.php">
                        <i class="fa fa-xl fa-toggle-off color-teal"></i>
                         <span>OUT Vehicles</span>
                    </a>
               </li>
               <li>
                   <a href="attendantinformationManagement.php">
                       <i class="fas fa-database"></i>
                       <span>Information Management</span>                
                   </a>
               </li>
               <li>
                  <a href="attendanttotalincome.php">
                     <i class="fas fa-dollar-sign"></i>
                     <span>Total Income</span>
                  </a>
              </li>
           </ul>
       </div>
       <div class="toggle-btn" id="toggleBtn">
           <i class="fas fa-bars"></i>
       </div>
    <br>
    <br>
    <br>
    <div class="container my-5">
    <h2></h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Vehicle Type</th>
                <th>Registration Number</th>
                <th>Slot Occupied</th>
                <th>Date</th>
                <th>Price</th>
                <th>Checkout</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['id'] . "</td>";
                    echo "<td>" . $row['name'] . "</td>";
                    echo "<td>" . $row['vehicle_type'] . "</td>";
                    echo "<td>" . $row['registration'] . "</td>";
                    echo "<td>" . $row['slot_occupied'] . "</td>";
                    echo "<td>" . $row['date'] . "</td>";
                    echo "<td>" . $row['price'] . "</td>";
                    echo "<td><a href='checkout.php?id=" . $row['id'] . "&slot=" . $row['slot_occupied'] . "' class='btn btn-primary'>Checkout</a></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='8' class='text-center'>No vehicles to check out</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>
</div>
    </section>
    <style>
        .container {
    margin-top: 20px;
    max-width: 1900px;
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
    font-weight: bold;
}

.table tbody tr {
    transition: background-color 0.3s;
}

.table tbody tr:hover {
    background-color: rgba(27, 59, 163, 0.1);
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
    border-radius: 4px;
    font-weight: bold;
}

.btn-primary {
    background-color: #1b3ba3;
    border: none;
    color: white;
}

.btn-primary:hover {
    background-color: #142d7a;
}

.btn-danger {
    background-color: #dc3545;
    color: white;
    border: none;
}

.btn-danger:hover {
    background-color: #c82333;
}
    </style>
    <script src="admin.js"></script>
<script>
     function toggleDropdown() {
            document.getElementById("myDropdown").classList.toggle("show");
        }

        window.onclick = function(event) {
            if (!event.target.matches('.account-btn')) {
                var dropdowns = document.getElementsByClassName("dropdown-content");
                for (var i = 0; i < dropdowns.length; i++) {
                    var openDropdown = dropdowns[i];
                    if (openDropdown.classList.contains('show')) {
                        openDropdown.classList.remove('show');
                    }
                }
            }
        }
</script>
</body>
</html>

<?php $connection->close(); ?>