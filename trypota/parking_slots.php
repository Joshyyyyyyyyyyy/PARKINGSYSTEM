<?php  
include('db_connect.php'); // Include database connection

// Fetch parking slots from the database
$sql = "SELECT * FROM parking_slots";
$result = $conn->query($sql);

// Display parking slots
if ($result->num_rows > 0) {
    echo "<div class='slots-container'>";
    while($row = $result->fetch_assoc()) {
        // Determine the class for slot type and status
        $slot_class = ($row['slot_type'] == 'VIP') ? 'vip' : 'regular';
        $status_class = ($row['status'] == 'Occupied') ? 'occupied' : 'available';
        
        // Display the slot with appropriate class and change name from "Slot" to "VIP" or "Regular"
        echo "<div class='slot $slot_class $status_class' id='slot-" . $row['slot_number'] . "'>";
        echo ($row['slot_type'] == 'VIP') ? 'VIP ' : 'Regular ';
        echo $row['slot_number'];
        echo "</div>";
    }
    echo "</div>";
} else {
    echo "<p>No slots available.</p>";
}
?>
<style>
 /* Parking Slot Styles */
.slots-container {
    display: grid;
    grid-template-columns: repeat(10, 1fr); 
    grid-gap: 15px; 
    justify-content: center; 
    max-width: 1900px; 
    margin: 0 auto; 
    padding: 20px;
}


.slot {
    display: inline-block;
    width: 100%; 
    height: 120px; 
    text-align: center;
    line-height: 120px; 
    font-weight: bold;
    cursor: pointer;
    border-radius: 8px; 
    transition: transform 0.3s ease, background-color 0.3s ease;
    font-size: 16px;
    display: flex;
    justify-content: center;
    align-items: center;
}


.vip {
    background: linear-gradient(45deg, #b27f1f, #fefe68, #f3a80a);
}


.vip.occupied {
    background: linear-gradient(135deg, #ff0000, #f95805, #f3a80a);
    color: black;
}

.regular {
    background: linear-gradient(300deg, #90fa3e, #19e02c, rgba(33,153,108,1));
}


.regular.occupied {
    background: linear-gradient(135deg, #ff0000, #f95805, #f3a80a);
    color: black;
}


.available {
    color: black;
}

.slot:hover {
    transform: scale(1.1); 
}


body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f4f4f4;
    color: #333;
}

header {
    background-color: #1b3ba3;
    color: white;
    text-align: center;
    padding: 15px;
    font-size: 24px;
}

.container {
    width: 80%;
    margin: 0 auto;
    padding: 20px;
    background-color: white;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
    border-radius: 8px;
    margin-top: 30px;
}


form {
    display: flex;
    flex-direction: column;
    margin-bottom: 20px;
}

form label {
    margin: 10px 0 5px;
    font-weight: bold;
}

form input, form select, form button {
    padding: 10px;
    margin: 5px 0 15px;
    border-radius: 5px;
    border: 1px solid #ddd;
}

form button {
    background-color: #1b3ba3;
    color: white;
    cursor: pointer;
}

form button:hover {
    background-color: #154a82;
}


@media (max-width: 1200px) {
    .slots-container {
        grid-template-columns: repeat(8, 1fr); 
    }
    .slot {
        height: 100px; 
        font-size: 14px; 
    }
}

@media (max-width: 900px) {
    .slots-container {
        grid-template-columns: repeat(6, 1fr); 
    }
    .slot {
        height: 90px; 
        font-size: 12px; 
    }
}

@media (max-width: 600px) {
    .slots-container {
        grid-template-columns: repeat(4, 1fr); 
    }
    .slot {
        height: 80px; 
        font-size: 10px; 
    }
}
</style>
