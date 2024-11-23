<?php 
$servername = "localhost";
$username = "root";
$password = "";
$database = "db2";

// Connect to database
$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
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

// Total Income
$total_query = "SELECT SUM(price) as total_income FROM information_management";
$total_result = $conn->query($total_query);
$total_income = $total_result->fetch_assoc()['total_income'] ?? 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Income Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f4f6f9;
            color: #333;
        }
        .card {
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .card-title {
            color: #1b3ba3;
        }
        .text-primary {
            color: #1b3ba3 !important;
        }
        .card-body {
            padding: 1.5rem;
        }
        .card-body h2 {
            font-size: 2rem;
            color: #1b3ba3;
        }
        .btn-primary {
            background-color: #1b3ba3;
            border: none;
        }
        .btn-primary:hover {
            background-color: #163a7a;
        }
        .card-header {
            background-color: #1b3ba3;
            color: white;
        }
        .card-footer {
            background-color: #f8f9fa;
            text-align: right;
        }
        canvas {
            max-height: 300px;
        }
    </style>
</head>
<body>
    <div class="container my-5">
        <!-- Top Contributor and Total Income Row -->
        <div class="row mb-4">
            <!-- Total Income Card (Left) -->
            <div class="col-md-6 d-flex">
                <div class="card flex-fill text-center bg-light shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Total Income</h5>
                        <h2 class="text-primary">₱<?= number_format($total_income, 2); ?></h2>
                    </div>
                </div>
            </div>

            <!-- Top Contributor Card (Right) -->
            <div class="col-md-6 d-flex">
                <div class="card flex-fill text-center bg-light shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Top Contributor</h5>
                        <p>Vehicle Type: <?= $top_contributor['vehicle_type']; ?></p>
                        <p>Income: ₱<?= number_format($top_contributor['total_income'], 2); ?></p>
                    </div>
                </div>
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

    <script>
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
