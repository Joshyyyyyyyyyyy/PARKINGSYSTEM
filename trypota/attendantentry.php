<?php
session_start();
include('db_connect.php');

// Fetch available slots based on customer type
$vip_slots_sql = "SELECT slot_number FROM parking_slots WHERE slot_type='VIP' AND status='Available'";
$regular_slots_sql = "SELECT slot_number FROM parking_slots WHERE slot_type='Regular' AND status='Available'";
$vip_slots_result = $conn->query($vip_slots_sql);
$regular_slots_result = $conn->query($regular_slots_sql);

$notification = ''; // To hold any notification message

// Handle form submission
if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $vehicle_type = $_POST['vehicle_type'];
    $customer_type = $_POST['customer_type'];
    $registration = $_POST['registration'];
    $slot_number = (int) $_POST['slot_number'];
    $date = $_POST['date'];
    $time = $_POST['time'];

    // Validate slot range based on customer type
    $is_valid_slot = ($customer_type === 'VIP' && $slot_number >= 1 && $slot_number <= 30) ||
                     ($customer_type === 'Regular' && $slot_number >= 31 && $slot_number <= 100);

    if (!$is_valid_slot) {
        $notification = "Invalid slot selection! VIPs can only select slots 1-30, and Regulars can only select slots 31-100.";
    } else {
        // Check if the slot is already occupied
        $slot_check_sql = "SELECT status FROM parking_slots WHERE slot_number = $slot_number";
        $slot_check_result = $conn->query($slot_check_sql);
        if ($slot_check_result->num_rows > 0) {
            $row = $slot_check_result->fetch_assoc();
            if ($row['status'] === 'Occupied') {
                $notification = "This slot is already occupied. Please select another slot.";
            } else {
                $price = $customer_type == 'VIP' ? 'Paid' : $_POST['price'];

                // Insert the vehicle entry into the vehicle_entries table
                $insert_sql = "INSERT INTO vehicle_entries (name, vehicle_type, customer_type, registration, slot_number, date, time, price)
                            VALUES ('$name', '$vehicle_type', '$customer_type', '$registration', '$slot_number', '$date', '$time', '$price')";

                if ($conn->query($insert_sql) === TRUE) {
                    $update_slot_sql = "UPDATE parking_slots SET status='Occupied' WHERE slot_number=$slot_number";
                    if ($conn->query($update_slot_sql) === TRUE) {
                        $notification = "Vehicle entry recorded successfully!";
                    } else {
                        $notification = "Error updating parking slot: " . $conn->error;
                    }
                } else {
                    $notification = "Error recording vehicle entry: " . $conn->error;
                }
            }
        } else {
            $notification = "Invalid slot number.";
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
<style>
    body { font-family: Arial, sans-serif; background-color: #f4f4f9; color: #333; 
        }
        h2 { text-align: center; margin-bottom: 20px; color: #1b3ba3; 
        }
        .form-container { 
            float: right;
            width: 100%;
            max-width: 1650px;
            margin: 0 auto;
            background-color: white;
            padding: 20px;
             border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); }
            .form-group {
            margin-bottom: 15px;
}

label {
    display: block;
    font-weight: bold;
    margin-bottom: 5px;
    color: #555;
}

.input-field {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    box-sizing: border-box;
}

.input-field:focus {
    border-color: #1b3ba3;
    outline: none;
}

.submit-btn {
    width: 100%;
    padding: 10px;
    background-color: #1b3ba3;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

.submit-btn:hover {
    background-color: #153d8a;
}

select, input[type="text"], input[type="number"], input[type="date"], input[type="time"] {
    font-size: 16px;
    padding: 8px;
    border-radius: 5px;
}
/* Modal overlay styling */
.modal-overlay {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.3s ease; /* Smooth transition for opacity */
    z-index: 1000; /* Ensure it’s above other content */
}

/* Modal content styling */
.modal-content {
    background: white;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    max-width: 400px;
    width: 90%;
    text-align: center;
}

/* Show the modal overlay */
.modal-overlay.show {
    display: flex;
    opacity: 1;
}

.modal-overlay.hide {
    display: none;
    opacity: 0;
}

button {
    margin-top: 15px;
    padding: 10px 20px;
    background-color: #1b3ba3;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
}

button:hover {
    background-color: #153d8a;
}

</style>
<body>
<div class="topnav">
    <a class="name">Entry Vehicles</a>
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
               <li class="active">
                   <a href="attendantentry.php">
                   <i class="fa fa-xl fa-toggle-on"></i>
                       <span>Vehicles Entry</span>
                   </a>
               </li>
               <li>
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
<div class="form-container">
    <form method="post" action="attendantentry.php" onsubmit="return validateForm()">
    <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" name="name" id="name" required class="input-field" maxlength="25">
        </div>

        <div class="form-group">
            <label for="vehicle_type">Vehicle Type:</label>
            <select name="vehicle_type" id="vehicle_type" required class="input-field">
                <option value="">Please Select Vehicle Type</option>
                <option value="2wheeler">2-Wheeler</option>
                <option value="4wheeler">4-Wheeler</option>
                <option value="6wheeler">6-Wheeler</option>
            </select>
        </div>

        <div class="form-group">
            <label for="customer_type">Customer Type:</label>
            <select name="customer_type" id="customer_type" required class="input-field" onchange="toggleSlotField()">
                <option value="">Please Select Customer Type</option>
                <option value="Regular">Regular</option>
                <option value="VIP">VIP</option>
            </select>
        </div>

        <div class="form-group">
            <label for="registration">Vehicle Registration:</label>
            <input type="text" name="registration" id="registration" required class="input-field" maxlength="10">
        </div>

        <div class="form-group">
            <label for="slot_number">Enter Slot Number:</label>
            <input type="number" name="slot_number" id="slot_number" required class="input-field" placeholder="Enter slot number" max="100">
        </div>
        <div class="form-group">
            <label for="date">Date:</label>
            <input type="date" name="date" id="date" required class="input-field">
        </div>

        <div class="form-group">
            <label for="time">Time:</label>
            <input type="time" name="time" id="time" required class="input-field">
        </div>

        <button type="submit" name="submit" class="submit-btn">Submit</button>
    </form>
</div>

<div class="modal-overlay" id="modalOverlay">
    <div class="modal-content">
        <p id="modalMessage"></p>
        <button onclick="closeModal()">Close</button>
    </div>
</div>

<script>
function toggleSlotField() {
    var customerType = document.getElementById('customer_type').value;
    var slotNumber = document.getElementById('slot_number');
    var priceInput = document.getElementById('price');
    var priceLabel = document.getElementById('price-label');

    if (customerType === 'VIP') {
        slotNumber.min = 1;
        slotNumber.max = 30;
        priceInput.disabled = true;
        priceLabel.innerText = "Price: (VIP - Paid)";
    } else {
        slotNumber.min = 31;
        slotNumber.max = 100;
        priceInput.disabled = false;
        priceLabel.innerText = "Price (20, 40, 60 pesos):";
    }
}

function validateForm() {
    var customerType = document.getElementById('customer_type').value;
    var slotNumber = parseInt(document.getElementById('slot_number').value, 10);

    if ((customerType === 'VIP' && (slotNumber < 1 || slotNumber > 30)) ||
        (customerType === 'Regular' && (slotNumber < 31 || slotNumber > 100))) {
        showModal('Invalid slot selection! VIPs can only select slots 1-30, and Regulars can only select slots 31-100.');
        return false;
    }

    return true;
}

function showModal(message) {
    document.getElementById('modalMessage').innerText = message;
    document.getElementById('modalOverlay').classList.add('show');
    document.getElementById('modalOverlay').classList.remove('hide');
}

function closeModal() {
    document.getElementById('modalOverlay').classList.add('hide');
    document.getElementById('modalOverlay').classList.remove('show');
}


document.addEventListener("DOMContentLoaded", function() {
    <?php if (!empty($notification)): ?>
        showModal("<?php echo $notification; ?>");
    <?php endif; ?>
});
</script>

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
</html>
