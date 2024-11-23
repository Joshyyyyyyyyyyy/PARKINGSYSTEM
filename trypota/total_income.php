<?php
include('db_connect.php'); // Include the database connection file

// Query to calculate total income from the information_management table
$query = "SELECT SUM(price) AS total_income FROM information_management";
$result = $conn->query($query);
$row = $result->fetch_assoc();
$total_income = $row['total_income'] ?? 0; // If no income, default to 0

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Total Income</title>
    <link rel="stylesheet" href="style.css"> <!-- Add any CSS styles you need -->
</head>
<body>
    <div class="container">
        <h2>Total Income</h2>
        <div class="income-display">
            <p>Total Income: ₱<?php echo number_format($total_income, 2); ?></p>
        </div>
    </div>

    <style>
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            font-family: Arial, sans-serif;
            background-color: #f8f8f8;
            border: 1px solid #ddd;
            border-radius: 5px;
            text-align: center;
        }
        h2 {
            color: #333;
        }
        .income-display {
            font-size: 1.5em;
            color: #1b3ba3;
        }
    </style>
</body>
</html>
