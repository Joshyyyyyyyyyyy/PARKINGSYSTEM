<?php
session_start();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="dashboardadmins.css">
    <link rel="stylesheet" href="admins.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="icon" type="image/icon" href="newlogo.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">  
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <title>Parking System</title>
</head>
<style>
     /* Parking Slot Styles */
        .slots-container {
            display: grid;
            grid-template-columns: repeat(10, 1fr); /* Create 10 columns for 10 slots per row */
            grid-gap: 15px; /* Space between slots */
            justify-content: center; /* Center the grid within the container */
            max-width: 1900px; /* Maximum width for the container */
            margin: 0 auto; /* Center the container horizontally */
            padding: 20px;
        }

        .slot {
            display: inline-block;
            width: 100%; 
            height: 120px; 
            text-align: center;
            line-height: 120px; 
            font-weight: bold;
            cursor: pointer;
            border-radius: 8px; 
            transition: transform 0.3s ease, background-color 0.3s ease;
            font-size: 16px;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .vip {
            background: linear-gradient(330deg, #b27f1f, #fefe68, #f3a80a);
        }

        .vip.occupied {
            background: linear-gradient(315deg, #ff0000f5, #a30000fa, rgba(71,0,0,1));
            color: black;
        }

        .regular {
            background-color: #32cd32;
        }

        .regular.occupied {
            background: linear-gradient(315deg, #ff0000f5, #a30000fa, rgba(71,0,0,1));
            color: black;
        }

        .available {
            color: black;
        }

        .slot:hover {
            transform: scale(1.1); 
        }

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f6f9;
            color: #333;
        }

        header {
            background-color: #1b3ba3;
            color: white;
            text-align: center;
            padding: 15px;
            font-size: 24px;
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

        @media (max-width: 1200px) {
            .slots-container {
                grid-template-columns: repeat(8, 1fr); 
            }
            .slot {
                height: 100px; 
                font-size: 14px; 
            }
        }

        @media (max-width: 900px) {
            .slots-container {
                grid-template-columns: repeat(6, 1fr); 
            }
            .slot {
                height: 90px; 
                font-size: 12px; 
            }
        }

        @media (max-width: 600px) {
            .slots-container {
                grid-template-columns: repeat(4, 1fr); 
            }
            .slot {
                height: 80px; 
                font-size: 10px; 
            }
        }
</style>
<body>
<div class="topnav">
    <a class="name">Parking Slots</a>
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
        <li class="active">
            <a href="adminparkingslot.php">
                <i class="bi bi-car-front-fill"></i>
                <span>Parking Slot</span>
            </a>
        </li>
      
        <li>
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
        <section class="parking-slots-section">
            <br>
            <br>
            <?php  
            include('db_connect.php'); 

            
            $sql = "SELECT * FROM parking_slots";
            $result = $conn->query($sql);

            
            if ($result->num_rows > 0) {
                echo "<div class='slots-container'>";
                while($row = $result->fetch_assoc()) {
                    
                    $slot_class = ($row['slot_type'] == 'VIP') ? 'vip' : 'regular';
                    $status_class = ($row['status'] == 'Occupied') ? 'occupied' : 'available';

                    
                    echo "<div class='slot $slot_class $status_class' id='slot-" . $row['slot_number'] . "'>";
                    echo ($row['slot_type'] == 'VIP') ? 'VIP ' : 'Regular ';
                    echo $row['slot_number'];
                    echo "</div>";
                }
                echo "</div>";
            } else {
                echo "<p>No slots available.</p>";
            }
            ?>
        </section>
    </div>

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
