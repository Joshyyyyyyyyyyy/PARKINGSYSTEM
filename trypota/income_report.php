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

    // Return the result as JSON
    echo json_encode(['total_income' => $total_income]);
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Income Report</title>
    <link rel="stylesheet" href=""> <!-- Link to your CSS file for consistent styling -->
</head>
<body>
    <div class="container">
        <h2>Income Report</h2>
        <form id="incomeReportForm">
            <label>From:</label>
            <input type="date" name="from_date" required>
            <label>To:</label>
            <input type="date" name="to_date" required>
            <button type="button" onclick="generateReport()">Generate Report</button>
        </form>

        <div id="reportResult" class="report-result" style="display: none;"></div>
    </div>

    <!-- Script for AJAX functionality -->
    <script>
        function generateReport() {
            const form = document.getElementById('incomeReportForm');
            const fromDate = form.elements['from_date'].value;
            const toDate = form.elements['to_date'].value;
            const reportResult = document.getElementById('reportResult');

            // Perform AJAX request
            fetch('income_report.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: `ajax=1&from_date=${fromDate}&to_date=${toDate}`
            })
            .then(response => response.json())
            .then(data => {
                // Display the result
                reportResult.style.display = 'block';
                reportResult.innerHTML = `Total Income from ${fromDate} to ${toDate} is: ₱${data.total_income}`;
            })
            .catch(error => {
                reportResult.style.display = 'block';
                reportResult.innerHTML = 'Error generating report. Please try again.';
                console.error('Error:', error);
            });
        }
    </script>

    <!-- Style for the report section -->
    <style>
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            font-family: Arial, sans-serif;
            background-color: #f8f8f8;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        h2 {
            text-align: center;
            color: #333;
        }

        form {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 20px;
        }

        label {
            font-size: 1em;
            color: #333;
        }

        input[type="date"] {
            padding: 5px;
            font-size: 1em;
        }

        button {
            background-color: #1b3ba3;
            color: #fff;
            padding: 8px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1em;
        }

        button:hover {
            background-color: #333;
        }

        .report-result {
            margin-top: 20px;
            text-align: center;
            font-size: 1.2em;
            color: #333;
        }
    </style>
</body>
</html>
