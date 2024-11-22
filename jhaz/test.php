<?php
include('db.php');

$sql = "SELECT * FROM `table na name niyo`";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php 
if ($result && $result->num_rows > 0) {
    echo "<table id='infoTable'>
            <tr>
                <th>Name</th>
                <th>Vehicle Type</th>
                <th>Customer Type</th>
                <th>Registration</th>
                <th>Slot Number</th>
                <th>Date</th>
                <th>Time</th>
                <th>Price</th>
            </tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . htmlspecialchars($row['name'] ?? 'N/A') . "</td>
                <td>" . htmlspecialchars($row['vehicle_type'] ?? 'N/A') . "</td>
                <td>" . htmlspecialchars($row['customer_type'] ?? 'N/A') . "</td>
                <td>" . htmlspecialchars($row['registration'] ?? 'N/A') . "</td>
                <td>" . htmlspecialchars($row['slot_number'] ?? 'N/A') . "</td>
                <td>" . htmlspecialchars($row['date'] ?? 'N/A') . "</td>
                <td>" . htmlspecialchars($row['time'] ?? 'N/A') . "</td>
                <td>" . htmlspecialchars($row['price'] ?? 'N/A') . "</td>
            </tr>";
    }

    echo "</table>";
} else {
    echo "<p class='no-data'>No data found in the information management system.</p>";
}
?>
</body>
</html>
