<?php 
include('db_connect.php');

// Set timezone to ensure consistency
date_default_timezone_set('Asia/Manila');

if (isset($_POST['vehicle_id'])) {
    $vehicle_id = $_POST['vehicle_id'];

    // Fetch vehicle entry details
    $sql = "SELECT * FROM vehicle_entries WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $vehicle_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Get entry time and current time
        $entry_time = new DateTime($row['time']); // Entry time from database
        $current_time = new DateTime();  // Current time

        // Check if entry time is in the future (this can happen with incorrect data entry)
        if ($entry_time > $current_time) {
            echo "Error: Entry time cannot be in the future.";
            exit;
        }

        // Calculate the duration between entry and current time
        $interval = $entry_time->diff($current_time); // Difference between entry and current time

        // Determine price based on customer type
        if ($row['customer_type'] === 'VIP') {
            // VIP customer - Price is automatically "Paid"
            $price = 'Paid';
        } else {
            // Regular customer - Calculate price at 20 pesos per 2 hours
            $duration_hours = $interval->h + ($interval->days * 24);  // Total hours parked
            $duration_minutes = $interval->i;  // Additional minutes

            // Calculate total duration (including minutes) and round up to nearest full 2 hours for pricing
            $total_duration = $duration_hours + ($duration_minutes / 60);  // Total duration in hours

            // Calculate the price, ensuring it is rounded up to the next 2-hour block
            $price = ceil($total_duration / 2) * 20;  // Price calculation based on 20 pesos per 2 hours
        }

        // Get the current time as a formatted string
$time_out = $current_time->format('Y-m-d H:i:s');

// Insert into information_management table with time_out
$insert_sql = "INSERT INTO information_management (name, vehicle_type, customer_type, registration, slot_number, date, time, price, time_out)
               VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
$insert_stmt = $conn->prepare($insert_sql);
$insert_stmt->bind_param("sssssssss", 
    $row['name'], 
    $row['vehicle_type'], 
    $row['customer_type'], 
    $row['registration'], 
    $row['slot_number'], 
    $row['date'], 
    $row['time'], 
    $price, 
    $time_out // Use the variable here
);
$insert_stmt->execute();


        // Update the parking slot to available
        $update_slot_sql = "UPDATE parking_slots SET status = 'Available' WHERE slot_number = ?";
        $update_slot_stmt = $conn->prepare($update_slot_sql);
        $update_slot_stmt->bind_param("i", $row['slot_number']);
        $update_slot_stmt->execute();

        // Delete the entry from vehicle_entries table
        $delete_sql = "DELETE FROM vehicle_entries WHERE id = ?";
        $delete_stmt = $conn->prepare($delete_sql);
        $delete_stmt->bind_param("i", $vehicle_id);
        $delete_stmt->execute();

        // Output the receipt with improvements and added photo
        echo "
        <div class='receipt'>
            <div class='header'>
                <img src='newlogo.png' alt='Parking System Logo' class='logo'>
                <h2>Parking System Receipt</h2>
            </div>
            <p><strong>Name:</strong> " . htmlspecialchars($row['name']) . "</p>
            <p><strong>Vehicle Type:</strong> " . htmlspecialchars($row['vehicle_type']) . "</p>
            <p><strong>Customer Type:</strong> " . htmlspecialchars($row['customer_type']) . "</p>
            <p><strong>Registration:</strong> " . htmlspecialchars($row['registration']) . "</p>
            <p><strong>Slot Number:</strong> " . htmlspecialchars($row['slot_number']) . "</p>
            <p><strong>Date:</strong> " . htmlspecialchars($row['date']) . "</p>
            <p><strong>Entry Time:</strong> " . htmlspecialchars($row['time']) . "</p>
            <p><strong>Current Time:</strong> " . $current_time->format('Y-m-d H:i:s') . "</p>
            <p><strong>Duration:</strong> " . $interval->format('%h hours and %i minutes') . "</p>
            <p><strong>Price:</strong> ₱" . (is_numeric($price) ? $price : $price) . "</p>
            <button onclick='window.print()' class='print-btn'>Print Receipt</button>
        </div>
        ";
    } else {
        echo "Error: Vehicle not found.";
    }
} else {
    echo "Error: Vehicle ID not provided.";
}
?>
<style>
    /* Style for the receipt */
    .receipt {
        font-family: Arial, sans-serif;
        max-width: 500px;
        margin: 0 auto;
        padding: 20px;
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    /* Header with logo and title */
    .header {
        text-align: center;
        margin-bottom: 20px;
    }

    .logo {
        width: 100px;
        margin-bottom: 10px;
    }

    h2 {
        color: #1b3ba3;
        font-size: 24px;
    }

    /* Style for receipt information */
    p {
        font-size: 16px;
        margin: 10px 0;
    }

    strong {
        font-weight: bold;
    }

    /* Print button styling */
    .print-btn {
        background-color: #1b3ba3;
        color: white;
        border: none;
        padding: 10px 20px;
        font-size: 16px;
        border-radius: 5px;
        cursor: pointer;
        display: block;
        margin: 20px auto;
    }

    .print-btn:hover {
        background-color: #154a82;
    }
    @media print {

    body * {
        visibility: hidden; 
    }

    .receipt, .receipt * {
        visibility: visible; 
    }

    
    .sidebar, .topnav, .dropdown, .account-btn {
        display: none !important; 
    }


    .receipt {
        background: none !important; 
        box-shadow: none !important; 
        padding: 0 !important; 
    }

    
    @page {
        margin: 0;
    }
}

</style>
