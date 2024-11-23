<?php  
include('db_connect.php'); // Include database connection

// Fetch all data from the information_management table
$sql = "SELECT * FROM information_management";
$result = $conn->query($sql);

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
   body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            background-color: #f4f6f9;
        }
        h1 {
            text-align: center;
            color: #1b3ba3;
            margin-top: 30px;
        }

        /* Table container */
        .table-container {
            width: 90%;
            margin: 20px auto;
            overflow-x: auto;
        }

        /* Search bar styling */
        .search-bar {
            width: 100%;
            padding: 12px;
            font-size: 16px;
            margin-bottom: 20px;
            border-radius: 5px;
            border: 1px solid #ddd;
        }

        /* Table styling */
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 0;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        th, td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
        }

        th {
            background-color: #1b3ba3;
            color: white;
        }

        td {
            background-color: #ffffff;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #ddd;
        }

        /* No data found styling */
        .no-data {
            text-align: center;
            color: #ff0000;
            font-size: 18px;
        }

        /* Responsive styling for smaller screens */
        @media (max-width: 600px) {
            table {
                width: 100%;
                font-size: 12px;
            }

            th, td {
                padding: 8px;
            }

            .search-bar {
                font-size: 14px;
            }
        }
    </style>
<body>
<div class="topnav">
    <a class="name">Information Management</a>
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
       
        <li>
            <a href="adminout.php">
                 <i class="fa fa-xl fa-toggle-off color-teal"></i>
                  <span>IN/OUT Vehicles</span>
             </a>
        </li>
        <li class="active">
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
       
       <div class="table-container">
           <input type="text" id="searchInput" class="search-bar" placeholder="Search by name or registration..." onkeyup="filterTable()">
   
           <?php 
            if ($result->num_rows > 0) {
                echo "<table id='infoTable'>
                        <tr>
                            <th>Name</th>
                            <th>Vehicle Type</th>
                            <th>Customer Type</th>
                            <th>Registration</th>
                            <th>Slot Number</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Time Out</th> <!-- Time Out column -->
                            <th>Price</th>
                            <th>Action</th>
                        </tr>";

                // Display all the entries
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>" . htmlspecialchars($row['name']) . "</td>
                            <td>" . htmlspecialchars($row['vehicle_type']) . "</td>
                            <td>" . htmlspecialchars($row['customer_type']) . "</td>
                            <td>" . htmlspecialchars($row['registration']) . "</td>
                            <td>" . htmlspecialchars($row['slot_number']) . "</td>
                            <td>" . htmlspecialchars($row['date']) . "</td>
                            <td>" . htmlspecialchars($row['time']) . "</td>
                            <td>";
                            // Check if time_out exists and is not null
                            if ($row['time_out']) {
                                echo htmlspecialchars($row['time_out']);
                            } else {
                                echo 'Not Recorded'; // If no time_out, display this
                            }
                    echo "</td>
                            <td>" . htmlspecialchars($row['price']) . "</td>
                            <td>
                                <button  class='btn btn-danger' onclick='confirmDelete(" . $row['id'] . ")'><i class='fas fa-trash-alt'></i> Delete</button>
                            </td>
                        </tr>";
                }

                echo "</table>";
            } else {
                echo "<p class='no-data'>No data found in the information management system.</p>";
            }
            ?>
        </div>
    </div>
       <script>
           // Function to filter table based on search input
           function filterTable() {
               let input = document.getElementById('searchInput');
               let filter = input.value.toLowerCase();
               let table = document.getElementById('infoTable');
               let tr = table.getElementsByTagName('tr');
               
               // Loop through all rows, and hide those that don't match the search
               for (let i = 1; i < tr.length; i++) {
                   let tdName = tr[i].getElementsByTagName('td')[0]; // Name column
                   let tdRegistration = tr[i].getElementsByTagName('td')[3]; // Registration column
                   if (tdName || tdRegistration) {
                       let nameText = tdName.textContent || tdName.innerText;
                       let registrationText = tdRegistration.textContent || tdRegistration.innerText;
                       if (nameText.toLowerCase().indexOf(filter) > -1 || registrationText.toLowerCase().indexOf(filter) > -1) {
                           tr[i].style.display = "";
                       } else {
                           tr[i].style.display = "none";
                       }
                   } 
               }
           }
       </script>
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
