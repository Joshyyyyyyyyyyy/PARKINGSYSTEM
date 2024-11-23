<?php 
include('db_connect.php');

session_start();

// Check if user is logged in and has 'admin' role
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php"); // Redirect to login if not an admin
    exit();
}

// Fetch vehicles with status 'Out'
$sql = "SELECT * FROM vehicle_entries WHERE status IN ('In', 'Out')";
$result = $conn->query($sql);

if (!$result) {
    die("Error executing query: " . $conn->error);
}

// Fetch total daily income
$daily_total_query = "SELECT SUM(price) as daily_income FROM information_management WHERE DATE(date) = CURDATE()";
$daily_total_result = $conn->query($daily_total_query);
$daily_total = $daily_total_result->fetch_assoc()['daily_income'] ?? 0;

// Fetch total weekly income
$weekly_total_query = "SELECT SUM(price) as weekly_income FROM information_management WHERE YEARWEEK(date, 1) = YEARWEEK(CURDATE(), 1)";
$weekly_total_result = $conn->query($weekly_total_query);
$weekly_total = $weekly_total_result->fetch_assoc()['weekly_income'] ?? 0;

// Fetch total monthly income
$monthly_total_query = "SELECT SUM(price) as monthly_income FROM information_management WHERE MONTH(date) = MONTH(CURDATE()) AND YEAR(date) = YEAR(CURDATE())";
$monthly_total_result = $conn->query($monthly_total_query);
$monthly_total = $monthly_total_result->fetch_assoc()['monthly_income'] ?? 0;

// Daily Income
$daily_query = "SELECT DATE(date) as day, SUM(price) as daily_income FROM information_management GROUP BY DATE(date)";
$daily_result = $conn->query($daily_query);
$daily_data = [];
while($row = $daily_result->fetch_assoc()) {
    $daily_data[] = ['day' => $row['day'], 'income' => $row['daily_income']];
}

// Weekly Income
$weekly_query = "SELECT WEEK(date) as week, SUM(price) as weekly_income FROM information_management GROUP BY WEEK(date)";
$weekly_result = $conn->query($weekly_query);
$weekly_data = [];
while($row = $weekly_result->fetch_assoc()) {
    $weekly_data[] = ['week' => $row['week'], 'income' => $row['weekly_income']];
}

// Monthly Income
$monthly_query = "SELECT MONTH(date) as month, SUM(price) as monthly_income FROM information_management GROUP BY MONTH(date)";
$monthly_result = $conn->query($monthly_query);
$monthly_data = [];
while($row = $monthly_result->fetch_assoc()) {
    $monthly_data[] = ['month' => $row['month'], 'income' => $row['monthly_income']];
}

// Top Contributor
$top_query = "SELECT vehicle_type, SUM(price) as total_income FROM information_management GROUP BY vehicle_type ORDER BY total_income DESC LIMIT 1";
$top_result = $conn->query($top_query);
$top_contributor = $top_result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="dashboardadmins.css">
    <link rel="stylesheet" href="admins.css  ">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="icon" type="image/icon" href="newlogo.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">  
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <title>Parking System</title>
</head>

<body>
<div class="topnav">
    <a class="name">Welcome to admin dashboard</a>
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
        <img src="newlogo.png" alt="Parking System Logo" width="200"> 
        </div>
       <br>
    <ul class="menu">
        <li class="active"><a href="admindashboard.php"><i class="fas fa-gauge"></i><span>Dashboard</span></a></li>
        <li><a href="adminaccountmgt.php"><i class="fa fa-user"></i><span>Account Management</span></a></li>
        <li><a href="adminparkingslot.php"><i class="bi bi-car-front-fill"></i><span>Parking Slot</span></a></li>
        <li><a href="adminout.php"><i class="fa fa-xl fa-toggle-off color-teal"></i><span>IN/OUT Vehicles</span></a></li>
        <li><a href="adminInformationManagement.php"><i class="fas fa-database"></i><span>Information Management</span></a></li>
        <li><a href="adminviewreport.php"><i class="fas fa-file-alt"></i><span>View Report</span></a></li>
        <li><a href="admintotalincome.php"><i class="fas fa-dollar-sign"></i><span>Total Income</span></a></li>
    </ul>
</div>

<div class="toggle-btn" id="toggleBtn">
    <i class="fas fa-bars"></i>
</div>
<br>
<br>
<br>
<br>
<div class="dashboard">
    <!-- Dashboard Sections -->
    <div class="dashboard-sections">
        <!-- Parking Slots Count -->
        <div class="dashboard-section" style="background-color: #1b3ba3;">
            <h2><i class="bi bi-car-front-fill"></i> Parking Slot Available</h2>
            <div class="data-box">
                <?php
                $result = $conn->query("SELECT COUNT(*) AS parked_count FROM parking_slots WHERE status = 'available'");
                echo "<p>" . ($result->fetch_assoc()['parked_count'] ?? 0) . "</p>";
                ?>
            </div>
        </div>

        <!-- Vehicles IN Count -->
        <div class="dashboard-section" style="background-color: #4f6edb;">
            <h2><i class="fa fa-xl fa-toggle-on" style="color: white;"></i> Vehicles In</h2>
            <div class="data-box">
                <?php
                $result = $conn->query("SELECT COUNT(*) AS in_vehicle_count FROM vehicle_entries WHERE status = 'IN'");
                echo "<p>" . ($result->fetch_assoc()['in_vehicle_count'] ?? 0) . "</p>";
                ?>
            </div>
        </div>

        <!-- Vehicles OUT Count -->
        <div class="dashboard-section" style="background-color: #0f245c;">
            <h2><i class="fa fa-xl fa-toggle-off" style="color: white;"></i> Vehicles Out</h2>
            <div class="data-box">
                <?php
                $result = $conn->query("SELECT COUNT(*) AS total_clients FROM information_management");
                echo "<p>" . ($result->fetch_assoc()['total_clients'] ?? 0) . "</p>";
                ?>
            </div>
        </div>
    </div>
<br>
<br>
    <div class="charts">
        <div class="chart-row">
            <div class="chart-container">
                <h2>Vehicle Type Distribution</h2>
                <canvas id="vehicleTypeChart"></canvas>
            </div>
            <div class="chart-container">
                <h2>Customer Type Distribution</h2>
                <canvas id="customerTypeChart"></canvas>
            </div>
        </div>
        <!-- Income Boxes -->
        <div class="row mb-5">
            <div class="col-md-4">
                <div class="card text-center bg-light shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Daily Income</h5>
                        <h2 class="text-primary">₱<?= number_format($daily_total, 2); ?></h2>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center bg-light shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Weekly Income</h5>
                        <h2 class="text-primary">₱<?= number_format($weekly_total, 2); ?></h2>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center bg-light shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Monthly Income</h5>
                        <h2 class="text-primary">₱<?= number_format($monthly_total, 2); ?></h2>
                    </div>
                </div>
            </div>
        </div>

        <!-- Income Charts -->
        <div class="row">
            <div class="col-md-4">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title">Daily Income</h5>
                        <canvas id="dailyIncomeChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title">Weekly Income</h5>
                        <canvas id="weeklyIncomeChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title">Monthly Income</h5>
                        <canvas id="monthlyIncomeChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</div>

<?php
// Fetch data for charts
$vehicleTypeData = ['2wheeler' => 0, '4wheeler' => 0, '6wheeler' => 0];
$vehicleTypeResult = $conn->query("SELECT vehicle_type, COUNT(*) as count FROM information_management GROUP BY vehicle_type");
while ($row = $vehicleTypeResult->fetch_assoc()) {
    $vehicleTypeData[$row['vehicle_type']] = $row['count'];
}

$customerTypeData = ['VIP' => 0, 'Regular' => 0];
$customerTypeResult = $conn->query("SELECT customer_type, COUNT(*) as count FROM information_management GROUP BY customer_type");
while ($row = $customerTypeResult->fetch_assoc()) {
    $customerTypeData[$row['customer_type']] = $row['count'];
}


$conn->close();
?>

<!-- JavaScript for Charts -->
<script>
const vehicleTypeCtx = document.getElementById('vehicleTypeChart').getContext('2d');
new Chart(vehicleTypeCtx, {
    type: 'pie',
    data: {
        labels: ['2 Wheeler', '4 Wheeler', '6 Wheeler'],
        datasets: [{
            data: [<?php echo $vehicleTypeData['2wheeler']; ?>, <?php echo $vehicleTypeData['4wheeler']; ?>, <?php echo $vehicleTypeData['6wheeler']; ?>],
            backgroundColor: ['#87CEEB', '#4169E1', '#000080']
        }]
    },
    options: { responsive: true }
});

const customerTypeCtx = document.getElementById('customerTypeChart').getContext('2d');
new Chart(customerTypeCtx, {
    type: 'pie',
    data: {
        labels: ['VIP', 'Regular'],
        datasets: [{
            data: [<?php echo $customerTypeData['VIP']; ?>, <?php echo $customerTypeData['Regular']; ?>],
            backgroundColor: ['#5c79e0', '#162c77']
        }]
    },
    options: { responsive: true }
});
 // Daily Income Chart Data
 const dailyIncome = {
            labels: <?php echo json_encode(array_column($daily_data, 'day')); ?>,
            datasets: [{
                label: 'Daily Income',
                data: <?php echo json_encode(array_column($daily_data, 'income')); ?>,
                backgroundColor: 'rgba(75, 192, 192, 0.5)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        };

        // Weekly Income Chart Data
        const weeklyIncome = {
            labels: <?php echo json_encode(array_map(function($week) { return "Week " . $week['week']; }, $weekly_data)); ?>,
            datasets: [{
                label: 'Weekly Income',
                data: <?php echo json_encode(array_column($weekly_data, 'income')); ?>,
                backgroundColor: 'rgba(54, 162, 235, 0.5)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        };

        // Monthly Income Chart Data
        const monthlyIncome = {
            labels: <?php echo json_encode(array_map(function($month) { return "Month " . $month['month']; }, $monthly_data)); ?>,
            datasets: [{
                label: 'Monthly Income',
                data: <?php echo json_encode(array_column($monthly_data, 'income')); ?>,
                backgroundColor: 'rgba(153, 102, 255, 0.5)',
                borderColor: 'rgba(153, 102, 255, 1)',
                borderWidth: 1
            }]
        };

        // Create Charts
        const dailyIncomeChart = new Chart(document.getElementById('dailyIncomeChart'), {
            type: 'bar',
            data: dailyIncome,
            options: {
                responsive: true,
                scales: {
                    y: { 
                        beginAtZero: true 
                    }
                }
            }
        });

        const weeklyIncomeChart = new Chart(document.getElementById('weeklyIncomeChart'), {
            type: 'bar',
            data: weeklyIncome,
            options: {
                responsive: true,
                scales: {
                    y: { 
                        beginAtZero: true 
                    }
                }
            }
        });

        const monthlyIncomeChart = new Chart(document.getElementById('monthlyIncomeChart'), {
            type: 'bar',
            data: monthlyIncome,
            options: {
                responsive: true,
                scales: {
                    y: { 
                        beginAtZero: true 
                    }
                }
            }
        });
</script>
</body>
</html>


    <!-- CSS Styling -->
    <style>
        .row.mb-5 {
    position: flex;
    justify-content: space-between;
}
    body {
        font-family: 'Roboto', sans-serif;
        background-color: #f7f7f7;
        margin: 0;
        padding: 0;
    }
    
    .dashboard {
        background-color: #ffffff;
        border-radius: 12px;
        padding: 30px;
        width: 90%;
        max-width: 1900px;
        margin: 20px auto;
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
        text-align: center;
    }

    h1 {
        color: #333;
        margin-bottom: 30px;
        font-size: 2.5em;
    }

    .dashboard-sections {
        display: flex;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 20px;
    }

    .dashboard-section {
        flex: 1;
        min-width: 250px;
        border-radius: 12px;
        padding: 20px;
        color: white;
        display: flex;
        flex-direction: column;
        align-items: center;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
    }

    .dashboard-section:hover {
        transform: translateY(-10px);
    }

    .dashboard-section h2 {
        color: #ffffff;
        margin-bottom: 10px;
        font-size: 1.3em;
        font-weight: 600;
    }

    .data-box {
        font-size: 2.8em;
        font-weight: bold;
    }

    .charts {
        display: flex;
        flex-direction: column;
        gap: 40px;
    }

    .chart-row {
        display: flex;
        gap: 30px;
        justify-content: center;
        flex-wrap: wrap;
    }

    .chart-container, .chart-container-wide {
        background-color: #ffffff;
        padding: 25px;
        border-radius: 12px;
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
        flex: 1;
        min-width: 320px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }

    .chart-container canvas {
        width: 300px !important;
        height: 300px !important;
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
