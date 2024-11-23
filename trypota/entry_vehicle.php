<?php
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
    <link rel="stylesheet" href="">
    <style>
        /* Existing CSS */
        body { font-family: Arial, sans-serif; background-color: #f4f4f9; color: #333; 
        }
        h2 { text-align: center; margin-bottom: 20px; color: #1b3ba3; 
        }
        .form-container { 
            width: 100%;
            max-width: 1600px;
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

        .modal-overlay {
            display: none;
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
        }

        .modal {
            background: white;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            max-width: 400px;
            width: 90%;
        }

        .modal button {
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #1b3ba3;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .modal button:hover {
            background-color: #153d8a;
        }
    </style>
</head>
<body>

<div class="form-container">
    <h2>Vehicle Entry Form</h2>
    <form method="post" action="attendantentry.php" onsubmit="return validateForm()">
        
    <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" name="name" id="name" required class="input-field">
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
            <input type="text" name="registration" id="registration" required class="input-field">
        </div>

        <div class="form-group">
            <label for="slot_number">Enter Slot Number:</label>
            <input type="number" name="slot_number" id="slot_number" required class="input-field" placeholder="Enter slot number">
        </div>
        <div class="form-group">
            <label for="date">Date:</label>
            <input type="date" name="date" id="date" required class="input-field">
        </div>

        <div class="form-group">
            <label for="time">Time:</label>
            <input type="time" name="time" id="time" required class="input-field">
        </div>

        <div class="form-group">
            <label for="price" id="price-label">Price:</label>
            <input type="number" name="price" id="price" required placeholder="Enter price for Regular" disabled class="input-field">
        </div>
        <button type="submit" name="submit" class="submit-btn">Submit</button>
    </form>
</div>

<!-- Notification Modal -->
<div class="modal-overlay" id="notificationModal">
    <div class="modal">
        <p id="notificationMessage"></p>
        <button onclick="closeModal()">OK</button>
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
    document.getElementById('notificationMessage').textContent = message;
    document.getElementById('notificationModal').style.display = 'flex';
}

function closeModal() {
    document.getElementById('notificationModal').style.display = 'none';
}

// Display notification if PHP sets a message
<?php if (!empty($notification)) : ?>
    showModal("<?php echo $notification; ?>");
<?php endif; ?>
</script>

</body>
</html>
