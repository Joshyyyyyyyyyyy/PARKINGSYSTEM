<?php
session_start();

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    $_SESSION['notification'] = "Access denied. Redirected to login.";
    header("Location: index.php");
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$database = "database1";

$connection = new mysqli($servername, $username, $password, $database);

$id = "";
$name = "";
$vehicle_type = "";
$registration = "";
$slot_occupied = "";
$date = "";
$price = "";

$errorMessage = ""; 
$successMessage = "";

// Fetch existing data for the client
if (isset($_GET["id"])) {
    $id = $_GET["id"];

    $sql = "SELECT * FROM clients WHERE id=?";
    if ($stmt = $connection->prepare($sql)) {
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $stmt->close();
    }

    if (!$row) {
        header("location: /addVehicles/clients.php");
        exit;
    }

    // Assign fetched data to variables
    $name = $row["name"];
    $vehicle_type = $row["vehicle_type"];
    $registration = $row["registration"];
    $slot_occupied = $row["slot_occupied"];
    $date = $row["date"];
    $price = $row["price"];
}

// Process form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST["id"]; 
    $name = $_POST["name"];
    $vehicle_type = $_POST["vehicle_type"];
    $registration = $_POST["registration"];
    $new_slot_occupied = $_POST["slot_occupied"]; // use a separate variable for the new slot
    $date = $_POST["date"];
    $price = $_POST["price"];

    do {
        if (empty($id) || empty($name) || empty($vehicle_type) || empty($registration) || empty($new_slot_occupied) || empty($date)) {
            $errorMessage = "ALL the fields are required"; 
            break;
        }

        // Update the client information
        $sql = "UPDATE clients 
                SET name = ?, vehicle_type = ?, registration = ?, slot_occupied = ?, date = ?, price = ?
                WHERE id = ?";
        if ($stmt = $connection->prepare($sql)) {
            $stmt->bind_param("ssssssi", $name, $vehicle_type, $registration, $new_slot_occupied, $date, $price, $id);
            if (!$stmt->execute()) {
                $errorMessage = "Error updating client: " . $stmt->error;
                break;
            }
            $stmt->close();
        }

        // Update the parking slot status only if the slot has changed
        if ($new_slot_occupied != $slot_occupied) {
            // Reset the previous slot
            if ($slot_occupied) {
                $updatePrevSlotSQL = "UPDATE parking_slots SET status = 'available' WHERE slot_number = ?";
                if ($stmt = $connection->prepare($updatePrevSlotSQL)) {
                    $stmt->bind_param("i", $slot_occupied);
                    $stmt->execute();
                    $stmt->close();
                }
            }
            // Update the new slot
            $updateNewSlotSQL = "UPDATE parking_slots SET status = 'occupied' WHERE slot_number = ?";
            if ($stmt = $connection->prepare($updateNewSlotSQL)) {
                $stmt->bind_param("i", $new_slot_occupied);
                $stmt->execute();
                $stmt->close();
            }
        }

        $successMessage = "Client info updated correctly, and slot status updated";

    } while (false);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="main.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="icon" type="image/icon" href="newlogo.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <title>Parking System</title>
</head>
<body>
<div class="sidebar" id="sidebar">
 <div class="logo">
    <img src="newlogo.png" alt="Parking System Logo" width="200" > 
</div>
<ul class="menu">
        <li>
            <a href="#">
                <i class="fas fa-gauge"></i>
                <span>Dashboard</span>
            </a>
        </li>
        <li>
            <a href="parkingSlot.php">
                <i class="bi bi-car-front-fill"></i>
                <span>Parking Slot</span>
            </a>
        </li>
        <li>
            <a href="EntryVehicle.php">
                <i class="fa fa-xl fa-car color-blue"></i>
                <span>Vehicles Entry</span>
            </a>
        </li>
        <li class="active">
            <a href="InVehicle.php">
                <i class="fa fa-xl fa-toggle-on color-orange"></i>
                <span>IN Vehicles</span>
            </a>
        </li>
        <li>
            <a href="outVehicle.php">
                <i class="fa fa-xl fa-toggle-off color-teal"></i>
                <span>OUT Vehicles</span>
            </a>
        </li>
        <li>
            <a href="#">
                <i class="fas fa-file-alt"></i>
                <span>View Report</span>                
            </a>
        </li>
        <li>
            <a href="#">
                <i class="fas fa-dollar-sign"></i>
                    <span>Total Income</span>
            </a>
        </li>
        <li class="logout">
            <a href="index.php">
                <i class="fas fa-sign-out-alt"></i>
                    <span>Logout</span>
            </a>
        </li>
    </ul>
</div>
<div class="toggle-btn" id="toggleBtn">
    <i class="fas fa-bars"></i>
</div>
    <div class="container my-5">
        <h2>Edit Client</h2>
        <?php
        if (!empty($errorMessage)) {
            echo "
            <div class = 'alert alert-warning alert-dismissible fade show' role='alert'>
                <strong>$errorMessage</strong>
                <button type='button'class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>
                ";
        }
        ?>
        <form method="POST">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Name</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="name" value="<?php echo $name; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Vehicle_type</label>
                <div class="col-sm-6">
                    <select type="options" class="form-control" name="vehicle_type" value="<?php echo $vehicle_type; ?>">
                      <option value="0">CLICK TO CHOOSE A VEHICLE TYPE</option>
                      <option value="4 wheels">4 wheels</option>
                      <option value="2 wheels">2 wheels</option>
                    </select>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Registration</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="registration" value="<?php echo $registration; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Slot occupied</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="slot_occupied" value="<?php echo $slot_occupied; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Date</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="date" value="<?php echo $date; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Price</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="price" value="<?php echo $price; ?>">
                </div>
            </div>
            <?php
             if ( !empty($successMessage) ){
                echo "
                <div class='row mb-3'>
                    <div class='offset-sm-3 col-sm-3'>
                        <div class = 'alert alert-warning alert-dismissible fade show' role='alert'>
                            <strong>$successMessage</strong>
                            <button type='button'class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                        </div> 
                    </div>
                </div>
                ";
             }
            ?>

            <div class="row mb-3">
                <div class="offset-sm-3 col-sm-3 d-grid">
                    <button type="submit" class="btn btn-outline-primary">submit</button>    
                </div>
                <div class="col-sm-3 d-grid">
                   <a class="btn btn-outline-primary" href="/ps1/costumerMngt.php" role="button">Cancel</a>    
                </div>
            </div>


        </form>

    </div>
    <script src="scripts.js"></script>

</body>
</html>