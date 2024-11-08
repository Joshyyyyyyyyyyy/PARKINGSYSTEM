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

// Check if both id and slot are set in the URL
if (isset($_GET['id']) && isset($_GET['slot'])) {
    $clientId = intval($_GET['id']);
    $slotNumber = intval($_GET['slot']); 

    // Store receipt information in the receipts table
    $insertReceiptSQL = "INSERT INTO receipts (client_id, slot_number, checkout_date) VALUES (?, ?, NOW())";
    if ($stmt = $connection->prepare($insertReceiptSQL)) {
        $stmt->bind_param("ii", $clientId, $slotNumber);
        $stmt->execute();
        $stmt->close();
    } else {
        die("Error preparing statement: " . $connection->error);
    }

    // Mark the slot as available
    $updateSlotSQL = "UPDATE parking_slots SET status = 'available' WHERE slot_number = ?";
    if ($stmt = $connection->prepare($updateSlotSQL)) {
        $stmt->bind_param("i", $slotNumber);
        $stmt->execute();
        $stmt->close();
    } else {
        die("Error preparing statement: " . $connection->error);
    }

   // After inserting the receipt and before redirecting
$sqlPrice = "SELECT price FROM clients WHERE id = ?";
if ($stmtPrice = $connection->prepare($sqlPrice)) {
    $stmtPrice->bind_param("i", $clientId);
    $stmtPrice->execute();
    $stmtPrice->bind_result($price);
    $stmtPrice->fetch();
    $stmtPrice->close();
}

// Redirect to the receipt page with price included
header("Location: receipt.php?id=$clientId&price=" . urlencode($price));
exit;

} else {
    echo "Invalid request. Missing parameters.";
}

$connection->close();
?>