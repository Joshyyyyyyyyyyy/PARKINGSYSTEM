<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "database1";

// Create a connection
$connection = new mysqli($servername, $username, $password, $database);

// Check for connection errors
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// Get the client ID and price from the URL
$clientId = $_GET['id'] ?? '';
$price = $_GET['price'] ?? '20'; // Default to 20 PHP if not specified

// Debug: Display all IDs in the clients table
$query = "SELECT id FROM clients";
$result = $connection->query($query);

echo "<p>Available IDs in clients table: ";
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo $row['id'] . " ";
    }
} else {
    echo "No data found in clients table.";
}
echo "</p>";

// Retrieve client details from database
$sql = "SELECT * FROM clients WHERE id = ?";
$stmt = $connection->prepare($sql);
$stmt->bind_param("i", $clientId);
$stmt->execute();
$result = $stmt->get_result();
$client = $result->fetch_assoc();

$connection->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <title>Receipt</title>
</head>
<body>
<div class="container my-5">
    <div class="card">
        <div class="card-header text-center">
            <h2>Parking Receipt</h2>
        </div>
        <div class="card-body">
            <p><strong>Client ID:</strong> <?php echo htmlspecialchars($clientId); ?></p>
            <p><strong>Price:</strong> <?php echo htmlspecialchars($price); ?> PHP</p>
            <?php if ($client): ?>
                <p><strong>Name:</strong> <?php echo htmlspecialchars($client['name']); ?></p>
                <p><strong>Vehicle Type:</strong> <?php echo htmlspecialchars($client['vehicle_type']); ?></p>
                <p><strong>Registration Number:</strong> <?php echo htmlspecialchars($client['registration']); ?></p>
                <p><strong>Slot Occupied:</strong> <?php echo htmlspecialchars($client['slot_occupied']); ?></p>
                <p><strong>Date:</strong> <?php echo htmlspecialchars($client['date']); ?></p>
            <?php else: ?>
                <p>No client found with ID: <?php echo htmlspecialchars($clientId); ?></p>
            <?php endif; ?>
        </div>
        <div class="card-footer text-center">
            <button onclick="window.print()" class="btn btn-primary">Print Receipt</button>
            <a href="outVehicle.php" class="btn btn-secondary">Back to Out Vehicles</a>
        </div>
    </div>
</div>
</body>
</html>
