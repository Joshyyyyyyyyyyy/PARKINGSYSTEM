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
        <li class="active">
            <a href="dashboard.php">
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
            <a href="createNewClient.php">
                <i class="fa fa-xl fa-car color-blue"></i>
                <span>Vehicles Entry</span>
            </a>
        </li>
        <li>
            <a href="costumerMngt.php">
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
    
</div>

<script src="scripts.js">
    
</script>
</body>
</body>
</html>