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

if (isset($_GET['id']) && isset($_GET['slot'])) {
    $clientId = $_GET['id'];
    $slotNumber = $_GET['slot'];

    // Mark the slot as available in the parking_slots table
    $updateSlotSQL = "UPDATE parking_slots SET status = 'available' WHERE slot_number = ?";
    $stmt = $connection->prepare($updateSlotSQL);
    $stmt->bind_param("i", $slotNumber);
    $stmt->execute();

    // Delete the client record from the clients table (or mark them as checked out)
    $deleteClientSQL = "DELETE FROM clients WHERE id = ?";
    $stmt = $connection->prepare($deleteClientSQL);
    $stmt->bind_param("i", $clientId);
    $stmt->execute();

    // Redirect to a receipt page
    header("Location: receipt.php?id=$clientId&price=20");
    exit;
}

$connection->close();
?>
