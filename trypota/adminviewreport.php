<?php 
include('db_connect.php'); // Include database connection

// Check if this is an AJAX request to fetch income data
if (isset($_POST['ajax']) && $_POST['ajax'] === '1') {
    $from_date = $_POST['from_date'];
    $to_date = $_POST['to_date'];

    // Query to get total income between selected dates from the 'information_management' table
    $query = "SELECT SUM(price) AS total_income FROM information_management WHERE date BETWEEN ? AND ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $from_date, $to_date);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $total_income = $row['total_income'] ?? 0;

    $details_query = "SELECT id, name, vehicle_type, price, date FROM information_management WHERE date BETWEEN ? AND ?";
    $details_stmt = $conn->prepare($details_query);
    $details_stmt->bind_param("ss", $from_date, $to_date);
    $details_stmt->execute();
    $details_result = $details_stmt->get_result();

    $details = [];
    while ($detail_row = $details_result->fetch_assoc()) {
        $details[] = $detail_row;
    }

    // Return the result as JSON
    echo json_encode(['total_income' => $total_income, 'details' => $details]);
    exit;
}
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
  
    </style>
<body>
<div class="topnav">
    <a class="name">View Report</a>
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
        <li>
            <a href="adminInformationManagement.php">
                <i class="fas fa-database"></i>
                <span>Information Management</span>                
            </a>
        </li>
        <li class="active">
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
    
    <form id="incomeReportForm" class="income-form">
        <div class="form-group">
            <label for="from_date">From:</label>
            <input type="date" name="from_date" id="from_date" required>

            <label for="to_date">To:</label>
            <input type="date" name="to_date" id="to_date" required>

            <button type="button" class="generate-btn" onclick="generateReport()">Generate Report</button>
        </div>
    </form>

    <div id="reportResult" class="report-result" style="display: none;"></div>
</div>
<table id="detailsTable" class="table table-bordered table-striped" style="display: none; margin-top: 20px;">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Vehicle Type</th>
                <th>Price</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>

<script>
   function generateReport() {
        const form = document.getElementById('incomeReportForm');
        const fromDate = form.elements['from_date'].value;
        const toDate = form.elements['to_date'].value;
        const reportResult = document.getElementById('reportResult');
        const detailsTable = document.getElementById('detailsTable');
        const detailsTableBody = detailsTable.querySelector('tbody');

        // Perform AJAX request
        fetch('adminviewreport.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: `ajax=1&from_date=${fromDate}&to_date=${toDate}`
        })
        .then(response => response.json())
        .then(data => {
            // Display total income
            reportResult.style.display = 'block';
            reportResult.innerHTML = `Total Income from ${fromDate} to ${toDate} is: ₱${data.total_income}`;

            // Populate table with details
            detailsTableBody.innerHTML = ''; // Clear existing rows
            if (data.details.length > 0) {
                data.details.forEach(detail => {
                    const row = `
                        <tr>
                            <td>${detail.id}</td>
                            <td>${detail.name}</td>
                            <td>${detail.vehicle_type}</td>
                            <td>₱${detail.price}</td>
                            <td>${detail.date}</td>
                        </tr>`;
                    detailsTableBody.insertAdjacentHTML('beforeend', row);
                });
                detailsTable.style.display = 'table';
            } else {
                detailsTable.style.display = 'none';
            }
        })
        .catch(error => {
            reportResult.style.display = 'block';
            reportResult.innerHTML = 'Error generating report. Please try again.';
            console.error('Error:', error);
        });
    }
</script>

<style>
    .body{
        background-color: #f4f6f9;
    }
    .container {
        width: 100%;
        max-width: 1900px;
        margin: 0 auto;
        text-align: center;
    }

    /* Style for the report form */
    .income-form {
        background-color: #f4f7fb;
        padding: 15px 25px;
        border-radius: 8px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        max-width: 900px;
        margin: 0 auto;
    }

    .form-group {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 20px;
    }

    .form-group label {
        font-size: 18px;
        margin-right: 10px;
    }

    .form-group input {
        padding: 12px;
        font-size: 18px;
        width: 180px;
        border-radius: 5px;
        border: 1px solid #ccc;
    }

    .generate-btn {
        background-color: #1b3ba3;
        color: white;
        border: none;
        padding: 15px 25px;
        border-radius: 5px;
        cursor: pointer;
        font-size: 18px;
    }

    .generate-btn:hover {
        background-color: #174c8d;
    }

    .report-result {
        margin-top: 20px;
        padding: 20px;
        background-color: #e4f9f5;
        border: 1px solid #4caf50;
        border-radius: 5px;
        font-size: 20px;
        font-weight: bold;
        color: #4caf50;
        text-align: center;
    }

    /* Table Styles */
    #detailsTable {
        width: 100%;
        margin-top: 20px;
        border-collapse: collapse;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    #detailsTable th,
    #detailsTable td {
        padding: 12px;
        text-align: left;
        font-size: 16px;
        border: 1px solid #ddd;
    }

    #detailsTable th {
        background-color: #1b3ba3;
        color: white;
        font-weight: bold;
    }

    #detailsTable tbody tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    #detailsTable tbody tr:hover {
        background-color: #f1f1f1;
    }

    /* Make the table responsive on smaller screens */
    @media (max-width: 768px) {
        #detailsTable th,
        #detailsTable td {
            font-size: 14px;
            padding: 8px;
        }

        .generate-btn {
            padding: 10px 20px;
            font-size: 16px;
        }
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
