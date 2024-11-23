<?php include 'db_connect.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parking System Dashboard</title>
    <link rel="stylesheet" href="your_css_file.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="dashboard">
        <h1>Parking System Dashboard</h1>
        
        <!-- Dashboard Sections -->
        <div class="dashboard-sections">
            <!-- Parking Slots Count -->
            <div class="dashboard-section" style="background-color: #1b3ba3;">
                <h2><i class="bi bi-car-front-fill"></i> Parking Slot</h2>
                <div class="data-box">
                    <?php
                    $result = $conn->query("SELECT COUNT(*) AS parked_count FROM parking_slots WHERE status = 'occupied'");
                    echo "<p>" . ($result->fetch_assoc()['parked_count'] ?? 0) . "</p>";
                    ?>
                </div>
            </div>

            <!-- Vehicles IN Count -->
            <div class="dashboard-section" style="background-color: #6f42c1;">
                <h2><i class="fa fa-xl fa-toggle-on" style="color: white;"></i> Vehicles In</h2>
                <div class="data-box">
                    <?php
                    $result = $conn->query("SELECT COUNT(*) AS in_vehicle_count FROM vehicle_entries WHERE status = 'IN'");
                    echo "<p>" . ($result->fetch_assoc()['in_vehicle_count'] ?? 0) . "</p>";
                    ?>
                </div>
            </div>

            <!-- Vehicles OUT Count -->
            <div class="dashboard-section" style="background-color: #28a745;">
                <h2><i class="fa fa-xl fa-toggle-off" style="color: white;"></i> Vehicles Out</h2>
                <div class="data-box">
                    <?php
                    $result = $conn->query("SELECT COUNT(*) AS total_clients FROM information_management");
                    echo "<p>" . ($result->fetch_assoc()['total_clients'] ?? 0) . "</p>";
                    ?>
                </div>
            </div>
        </div>

        <!-- Charts Section -->
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
            <div class="chart-container-wide">
                <h2>Monthly Income</h2>
                <canvas id="incomeChart"></canvas>
            </div>
        </div>
    </div>

    <?php
    // Fetch vehicle type distribution
    $vehicleTypeData = ['2wheeler' => 0, '4wheeler' => 0, '6wheeler' => 0];
    $vehicleTypeResult = $conn->query("SELECT vehicle_type, COUNT(*) as count FROM information_management GROUP BY vehicle_type");
    while ($row = $vehicleTypeResult->fetch_assoc()) {
        $vehicleTypeData[$row['vehicle_type']] = $row['count'];
    }

    // Fetch customer type distribution
    $customerTypeData = ['VIP' => 0, 'Regular' => 0];
    $customerTypeResult = $conn->query("SELECT customer_type, COUNT(*) as count FROM information_management GROUP BY customer_type");
    while ($row = $customerTypeResult->fetch_assoc()) {
        $customerTypeData[$row['customer_type']] = $row['count'];
    }

    // Fetch monthly income data
    $incomeData = array_fill(0, 12, 0); // Default all months to 0 income
    $incomeResult = $conn->query("SELECT MONTH(date) as month, SUM(price) as total_income FROM information_management GROUP BY MONTH(date)");
    while ($row = $incomeResult->fetch_assoc()) {
        $incomeData[$row['month'] - 1] = $row['total_income'];
    }

    $conn->close();
    ?>

    <!-- JavaScript for Charts -->
    <script>
    // Vehicle Type Distribution Chart
    const vehicleTypeCtx = document.getElementById('vehicleTypeChart').getContext('2d');
    new Chart(vehicleTypeCtx, {
        type: 'pie',
        data: {
            labels: ['2 Wheeler', '4 Wheeler', '6 Wheeler'],
            datasets: [{
                data: [<?php echo $vehicleTypeData['2wheeler']; ?>, <?php echo $vehicleTypeData['4wheeler']; ?>, <?php echo $vehicleTypeData['6wheeler']; ?>],
                backgroundColor: ['#1b3ba3', '#ff9800', '#4caf50']
            }]
        },
        options: { responsive: true }
    });

    // Customer Type Distribution Chart
    const customerTypeCtx = document.getElementById('customerTypeChart').getContext('2d');
    new Chart(customerTypeCtx, {
        type: 'pie',
        data: {
            labels: ['VIP', 'Regular'],
            datasets: [{
                data: [<?php echo $customerTypeData['VIP']; ?>, <?php echo $customerTypeData['Regular']; ?>],
                backgroundColor: ['#ffd700', '#4caf50']
            }]
        },
        options: { responsive: true }
    });

    // Monthly Income Chart
    const incomeCtx = document.getElementById('incomeChart').getContext('2d');
    new Chart(incomeCtx, {
        type: 'bar',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'], // Months
            datasets: [{
                label: 'Income',
                data: [<?php echo implode(', ', $incomeData); ?>], // Insert the PHP data here
                backgroundColor: '#1b3ba3',
                borderColor: '#1b3ba3',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1000,  // Adjust step size based on your income data scale
                        callback: function(value) {
                            return '₱' + value;  // Add currency symbol for readability
                        }
                    }
                }
            },
            layout: {
                padding: {
                    left: 10,
                    right: 10,
                    top: 20,
                    bottom: 10
                }
            }
        }
    });
    </script>

    <!-- CSS Styling -->
    <style>
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
</body>
</html>
