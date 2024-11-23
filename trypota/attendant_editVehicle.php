<?php
include('db_connect.php');

// Fetch vehicle information based on the ID passed in the URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $vehicle_id = intval($_GET['id']);

    // Fetch the vehicle data
    $sql = "SELECT * FROM vehicle_entries WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $vehicle_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        die("<script>alert('Vehicle not found.'); window.location.href='attendantoutvehicle.php';</script>");
    }
} else {
    die("<script>alert('Invalid vehicle ID.'); window.location.href='attendantoutvehicle.php';</script>");
}

// Handle form submission for updating vehicle data
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    $name = trim($_POST['name']);
    $vehicle_type = trim($_POST['vehicle_type']);
    $customer_type = trim($_POST['customer_type']);
    $registration = trim($_POST['registration']);
    $new_slot_number = intval($_POST['slot_number']);

    $old_slot_number = intval($row['slot_number']); // Get the previous slot number

    // Validate inputs
    if (empty($name) || empty($vehicle_type) || empty($customer_type) || empty($registration) || empty($new_slot_number)) {
        echo "<script>alert('Please fill out all fields correctly.');</script>";
    } else {
        // Check slot validity based on customer type
        $is_valid_slot = ($customer_type === 'VIP' && $new_slot_number >= 1 && $new_slot_number <= 30) ||
                         ($customer_type === 'Regular' && $new_slot_number >= 31 && $new_slot_number <= 100);

        if (!$is_valid_slot) {
            echo "<script>alert('Invalid slot selection! VIPs can only select slots 1-30, and Regulars can only select slots 31-100.');</script>";
        } else {
            // Check if the slot is already occupied
            $slot_check_sql = "SELECT status FROM parking_slots WHERE slot_number = ?";
            $stmt_check = $conn->prepare($slot_check_sql);
            $stmt_check->bind_param("i", $new_slot_number);
            $stmt_check->execute();
            $slot_check_result = $stmt_check->get_result();

            if ($slot_check_result->num_rows > 0) {
                $slot_row = $slot_check_result->fetch_assoc();
                if ($slot_row['status'] === 'Occupied') {
                    echo "<script>alert('This slot is already occupied. Please select another slot.');</script>";
                } else {
                    // Begin transaction
                    $conn->begin_transaction();

                    try {
                        // Mark the old slot as available
                        $update_old_slot = "UPDATE parking_slots SET status = 'Available' WHERE slot_number = ?";
                        $stmt1 = $conn->prepare($update_old_slot);
                        $stmt1->bind_param("i", $old_slot_number);
                        $stmt1->execute();

                        // Mark the new slot as occupied
                        $update_new_slot = "UPDATE parking_slots SET status = 'Occupied' WHERE slot_number = ?";
                        $stmt2 = $conn->prepare($update_new_slot);
                        $stmt2->bind_param("i", $new_slot_number);
                        $stmt2->execute();

                        // Update vehicle information in the database
                        $update_vehicle_sql = "UPDATE vehicle_entries SET name = ?, vehicle_type = ?, customer_type = ?, registration = ?, slot_number = ? WHERE id = ?";
                        $stmt3 = $conn->prepare($update_vehicle_sql);
                        $stmt3->bind_param("ssssii", $name, $vehicle_type, $customer_type, $registration, $new_slot_number, $vehicle_id);
                        $stmt3->execute();

                        // Commit transaction
                        $conn->commit();
                        echo "<script>alert('Vehicle information and slot status have been updated successfully!'); window.location.href='attendantoutvehicle.php';</script>";
                    } catch (Exception $e) {
                        // Rollback on error
                        $conn->rollback();
                        echo "<script>alert('Failed to update data: " . $e->getMessage() . "');</script>";
                    }
                }
            }
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="admins.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="icon" type="image/icon" href="newlogo.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">  
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <title>Parking System</title>
</head>
<body>
<div class="topnav">
    <a class="name">Edit Vehicle</a>
    <a href="attendantdashboard.php">Tutorial</a>
    <a href="attendantdashboard.php">About</a>
        <div class="dropdown">
            <button class="account-btn" onclick="toggleDropdown()">Account</button>
            <div id="myDropdown" class="dropdown-content">
                <div class="user-info">
                    <div class="user-name">Parking attendant</div>
                    <div class="user-id">Tester</div>
                </div>
                <div class="divider"></div>
                <a href="logout.php">
                       <i class="fas fa-sign-out-alt"></i>
                       <span class="user-name">Logout</span>
                   </a>
                
            </div>
        </div>
      </div>
      <div class="sidebar" id="sidebar">
        <div class="logo">
        <img src="attendants.png" alt="Parking System Logo" width="200" > 
           <li>
                   <a>
                   <span><b>Parking Attendant</b></span>
                   </a>
               </li>
       </div>
       <br>
       <ul class="menu">
               <li>
                   <a href="attendantdashboard.php">
                       <i class="fas fa-gauge"></i>
                       <span>Dashboard</span>
                   </a>
               </li>
               <li>
                   <a href="attendparkingslot.php">
                       <i class="bi bi-car-front-fill"></i>
                       <span>Parking Slot</span>
                   </a>
               </li>
               <li>
                   <a href="attendantentry.php">
                   <i class="fa fa-xl fa-toggle-on"></i>
                       <span>Vehicles Entry</span>
                   </a>
               </li>
    
               <li class="active">
                   <a href="attendantoutvehicle.php">
                        <i class="fa fa-xl fa-toggle-off color-teal"></i>
                         <span>IN/OUT Vehicles</span>
                    </a>
               </li>
               <li>
                   <a href="attendantInformationmanagement.php">
                       <i class="fas fa-database"></i>
                       <span>Information Management</span>                
                   </a>
               </li>
               <li>
            <a href="attendantincomereport.php">
                <i class="fas fa-file-alt"></i>
                <span>View Report</span>                
            </a>
        </li>
        <li>
            <a href="attendanttotalincome.php">
                <i class="fas fa-dollar-sign"></i>
                    <span>Total Income</span>
            </a>
        </li>
           </ul>
       </div>
       <div class="toggle-btn" id="toggleBtn">
           <i class="fas fa-bars"></i>
       </div>
       <br>
       <br>
       <br>
<div class="container">
        <form action="attendant_editVehicle.php?id=<?php echo $vehicle_id; ?>" method="post">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($row['name']); ?>" required>
            
            <label for="vehicle_type">Vehicle Type:</label>
            <select id="vehicle_type" name="vehicle_type" required>
                <option value="2-wheeler" <?php echo ($row['vehicle_type'] == '2-wheeler') ? 'selected' : ''; ?>>2-wheeler</option>
                <option value="4-wheeler" <?php echo ($row['vehicle_type'] == '4-wheeler') ? 'selected' : ''; ?>>4-wheeler</option>
                <option value="6-wheeler" <?php echo ($row['vehicle_type'] == '6-wheeler') ? 'selected' : ''; ?>>6-wheeler</option>
            </select>

            <label for="customer_type">Customer Type:</label>
            <select id="customer_type" name="customer_type" required>
                <option value="VIP" <?php echo ($row['customer_type'] == 'VIP') ? 'selected' : ''; ?>>VIP</option>
                <option value="Regular" <?php echo ($row['customer_type'] == 'Regular') ? 'selected' : ''; ?>>Regular</option>
            </select>

            <label for="registration">Registration:</label>
            <input type="text" id="registration" name="registration" value="<?php echo htmlspecialchars($row['registration']); ?>" required>

            <label for="slot_number">Slot Number:</label>
            <input type="number" id="slot_number" name="slot_number" value="<?php echo htmlspecialchars($row['slot_number']); ?>" required>

            <div class="form-buttons">
                <button type="submit" name="update">Update Information</button>
                <button class="back-home-button" type="button" onclick="window.location.href='attendantoutvehicle.php'">Back Home</button>
            </div>
        </form>
    </div>
   <style>
      body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 60%;
            margin: 30px auto;
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            color: #1b3ba3;
        }
        form {
            display: grid;
            grid-template-columns: 1fr;
            gap: 15px;
        }
        label {
            font-size: 16px;
            color: #333;
        }
        input[type="text"], input[type="number"], select {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            width: 100%;
            font-size: 14px;
        }
        .form-buttons {
            display: flex;
            justify-content: space-between;
        }
        button[type="submit"] {
            background-color: #1b3ba3;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            width: 48%;
        }
        button[type="submit"]:hover {
            background-color: #153c8f;
        }
        .back-home-button {
            background-color: #ccc;
            color: #333;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            width: 48%;
        }
        .back-home-button:hover {
            background-color: #999;
        }
   </style>
<script src="admin.js"></script>
<script>
     function toggleDropdown() {
            document.getElementById("myDropdown").classList.toggle("show");
        }

        window.onclick = function(event) {
            if (!event.target.matches('.account-btn')) {
                var dropdowns = document.getElementsByClassName("dropdown-content");
                for (var i = 0; i < dropdowns.length; i++) {
                    var openDropdown = dropdowns[i];
                    if (openDropdown.classList.contains('show')) {
                        openDropdown.classList.remove('show');
                    }
                }
            }
        }
</script>
</body>
</body>
</html>