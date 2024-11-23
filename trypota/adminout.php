<?php
include('db_connect.php');

// Fetch vehicles with status 'Out'
$sql = "SELECT * FROM vehicle_entries WHERE status IN ('In', 'Out')";
$result = $conn->query($sql);

if (!$result) {
    die("Error executing query: " . $conn->error);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="dashboardadmins.css">
    <link rel="stylesheet" href="style.css">
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
    <a class="name">IN/OUT Vehicles</a>
        <div class="dropdown">
            <button class="account-btn" onclick="toggleDropdown()">Account</button>
            <div id="myDropdown" class="dropdown-content">
                <div class="user-info">
                    <div class="user-name">Admin</div>
                    <div class="user-id">Tester</div>
                </div>
                <div class="divider"></div>
                <a href="logout.php">
                       <i class="fas fa-sign-out-alt"></i>
                       <span class="user-name">Logout</span>
                   </a>
                
            </div>
        </div>
      </div>
      <br>
      <br>
      <br>
<div class="sidebar" id="sidebar">
 <div class="logo">
    <img src="newlogo.png" alt="Parking System Logo" width="200" > 
</div>
<br>
<ul class="menu">
        <li>
            <a href="admindashboard.php">
                <i class="fas fa-gauge"></i>
                <span>Dashboard</span>
            </a>
        </li>
        <li>
            <a href="adminaccountmgt.php">
                <i class="fa fa-user"></i>
                <span>Account Management</span>
            </a>
        </li>
        <li>
            <a href="adminparkingslot.php">
                <i class="bi bi-car-front-fill"></i>
                <span>Parking Slot</span>
            </a>
        </li>
        
        <li class="active">
            <a href="adminout.php">
                 <i class="fa fa-xl fa-toggle-off color-teal"></i>
                  <span>IN/OUT Vehicles</span>
             </a>
        </li>
        <li>
            <a href="adminInformationManagement.php">
                <i class="fas fa-database"></i>
                <span>Information Management</span>                
            </a>
        </li>
        <li>
            <a href="adminviewreport.php">
                <i class="fas fa-file-alt"></i>
                <span>View Report</span>                
            </a>
        </li>
        <li>
            <a href="admintotalincome.php">
                <i class="fas fa-dollar-sign"></i>
                    <span>Total Income</span>
            </a>
        </li>
       
    </ul>
</div>
<div class="toggle-btn" id="toggleBtn">
    <i class="fas fa-bars"></i>
</div>
<div class="container">
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Vehicle Type</th>
                    <th>Customer Type</th>
                    <th>Registration</th>
                    <th>Slot Number</th>
                    <th>Date</th>
                    <th>Time</th>
                    
                    <th>Action</th>
                    <th>Checkout</th>
                </tr>
            </thead>
            <tbody>
            <?php if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['vehicle_type']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['customer_type']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['registration']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['slot_number']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['date']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['time']) . "</td>";
                  
                    echo "<td><a href='admin_editVehicle.php?id=" . htmlspecialchars($row['id']) . "' class='edit-btn'><i class='fas fa-edit'></i> Edit</a></td>";
                    echo "<td><button class='checkout-btn' onclick='checkoutVehicle(" . htmlspecialchars($row['id']) . ")'><i class='fas fa-check-circle'></i> Checkout</button></td>";                    
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='10' class='no-data'>No vehicles ready for checkout</td></tr>";
            }
            ?>
            </tbody>
        </table>
    </div>

    <!-- Overlay for the receipt display -->
    <div id="overlay" class="overlay">
        <div class="overlay-content">
            <button class="close-btn" onclick="closeOverlay()">Close</button>
            <div id="receipt-content"></div>
        </div>
    </div>
    <div id="notification" class="notification" style="display:none;">
    <p>Client Successfully Checkout!</p>
   </div>
   <div id="edit-overlay" class="overlay">
    <div class="overlay-content">
        <button class="close-btn" onclick="closeEditOverlay()">Close</button>
        <div id="edit-form-content"></div> <!-- This will be populated with the edit form -->
    </div>
</div>
    <script>
        function checkoutVehicle(vehicleId) {
            
            document.getElementById('overlay').style.display = 'flex';
            document.getElementById('receipt-content').innerHTML = "<p>Loading receipt...</p>";

            
            const xhr = new XMLHttpRequest();
            xhr.open("POST", "checkout.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    
                    document.getElementById('receipt-content').innerHTML = xhr.responseText;
                }
            };
            xhr.send("vehicle_id=" + vehicleId);
        }

        function closeOverlay() {
            document.getElementById('overlay').style.display = 'none';
        }

        function checkoutVehicle(vehicleId) {
        document.getElementById('overlay').style.display = 'flex';
        document.getElementById('receipt-content').innerHTML = "<p>Loading receipt...</p>";

        const xhr = new XMLHttpRequest();
        xhr.open("POST", "checkout.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                document.getElementById('receipt-content').innerHTML = xhr.responseText;
            }
        };
        xhr.send("vehicle_id=" + vehicleId);
    }

    function closeOverlay() {
        document.getElementById('overlay').style.display = 'none';

        // Show the notification
        document.getElementById('notification').style.display = 'block';

        // Hide notification after 3 seconds and refresh the page
        setTimeout(function() {
            document.getElementById('notification').style.display = 'none';
            location.reload(); // Refresh the page
        }, 3000); // 3 seconds delay
    }
    </script>
    <style>
    .body{
        background-color: #f4f6f9;
    }
    .container {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
            background-color: white;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            margin-top: 30px;
            max-width: 1900px;
        }
     .overlay {
            display: none; 
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            justify-content: center;
            align-items: center;
            z-index: 999;
        }
        .overlay-content {
            background: white;
            padding: 20px;
            border-radius: 8px;
            max-width: 90%;
            width: 350px;
        }
        .close-btn {
            background-color: #333;
            color: white;
            padding: 5px;
            border: none;
            cursor: pointer;
            float: right;
        }
        .notification {
    position: fixed;
    top: 30px; 
    left: 50%; 
    transform: translate(-50%, -50%); 
    background-color: #4CAF50;
    color: white;
    padding: 10px;
    border-radius: 5px;
    z-index: 1000;
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
</body>
</html>
