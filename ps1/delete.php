<?php 
if (isset($_GET["id"])) {
    $id = $_GET["id"];

    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "database1";

    // Create a connection
    $connection = new mysqli($servername, $username, $password, $database);

    // Check connection
    if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    }

    // Step 1: Retrieve the slot number for the client to be deleted
    $slotSQL = "SELECT slot_occupied FROM clients WHERE id = ?";
    if ($stmt = $connection->prepare($slotSQL)) {
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->bind_result($slot_occupied);
        $stmt->fetch();
        $stmt->close();
    }

    // Step 2: Reset the parking slot status to 'available'
    if ($slot_occupied) {
        $updateSlotSQL = "UPDATE parking_slots SET status = 'available' WHERE slot_number = ?";
        if ($stmt = $connection->prepare($updateSlotSQL)) {
            $stmt->bind_param("i", $slot_occupied);
            $stmt->execute();
            $stmt->close();
        }
    }

    // Step 3: Delete the client record
    $deleteSQL = "DELETE FROM clients WHERE id = ?";
    if ($stmt = $connection->prepare($deleteSQL)) {
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
    }

    // Close connection
    $connection->close();
}

header("location:/ps1/InVehicle.php");
exit;
?>