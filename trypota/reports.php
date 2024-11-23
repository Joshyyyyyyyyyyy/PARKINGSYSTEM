<?php 
include('db_connect.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Income Report</title>
    <link rel="stylesheet" href="styles.css"> <!-- Add your CSS file -->
</head>
<body>
    <div class="container">
        <h2>Income Report</h2>
        <form method="POST">
            <label for="from_date">From:</label>
            <input type="date" name="from_date" required>
            <label for="to_date">To:</label>
            <input type="date" name="to_date" required>
            <button type="submit" name="generate_report">Generate Report</button>
        </form>

        <?php
        if (isset($_POST['generate_report'])) {
            $from_date = $_POST['from_date'];
            $to_date = $_POST['to_date'];

            // Query to calculate total income from Information Management table
            $query = "SELECT SUM(price) AS total_income FROM information_management WHERE date BETWEEN ? AND ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("ss", $from_date, $to_date);
            $stmt->execute();
            $result = $stmt->get_result();
            $data = $result->fetch_assoc();

            // Display total income
            $total_income = $data['total_income'] ? $data['total_income'] : 0;
            echo "<h3>Total Income from $from_date to $to_date: ₱" . number_format($total_income, 2) . "</h3>";
        }
        ?>

    </div>
</body>
</html>

<style>
    .container {
        max-width: 500px;
        margin: 0 auto;
        padding: 20px;
        border: 1px solid #ddd;
        background-color: #f8f8f8;
        font-family: Arial, sans-serif;
    }
    h2 {
        text-align: center;
    }
    form {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }
    label {
        font-weight: bold;
    }
    button {
        padding: 10px;
        background-color: #1b3ba3;
        color: white;
        border: none;
        cursor: pointer;
    }
    h3 {
        text-align: center;
        margin-top: 20px;
        color: #333;
    }
</style>
