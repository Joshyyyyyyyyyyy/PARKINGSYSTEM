
<?php
session_start();

// Check if user is logged in and has 'attendant' role
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'attendant') {
    header("Location: login.php"); // Redirect to login if not an attendant
    exit();
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
    <a class="name">Welcome Parking Attendant</a>
        <a href="#tutorial">Tutorial</a>
        <a href="#about">About</a>
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
      <br>
       <br>
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
               <li class="active">
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
       
       <section class="tutorial" id="tutorial">
    <div class="tutorial-container">
        <h1>Parking System User Guide</h1>
        <div class="tutorial-grid">
            <div class="tutorial-item">
                <img src="step1.jpg" alt="Tutorial 1" width="100%" height="200">
                <div class="tutorial-content">
                    <h2>Parking Slot</h2>
                    <p>Tap on the parking slot icon on the dashboard to view available spots where you can park.</p>
                    <a href="tutorials/getting-started.html" class="read-more">View</a>
                </div>
            </div>
            <div class="tutorial-item">
                <img src="step2.jpg" alt="Tutorial 2" width="100%" height="200">
                <div class="tutorial-content">
                    <h2>Entry Vehicles</h2>
                    <p>After viewing the available parking spots, tap on the "Entry Vehicle" icon on the dashboard. This will allow you to enter your client's vehicle information, such as license plate number, vehicle type, and any additional details required.</p>
                    <a href="tutorials/advanced-techniques.html" class="read-more">View</a>
                </div>
            </div>
            <div class="tutorial-item">
                <img src="step3.jpg" alt="Tutorial 3" width="100%" height="200">
                <div class="tutorial-content">
                    <h2>In/Out Vehicles</h2>
                    <p>After entering the client's vehicle information, the data will be automatically transferred to the IN/OUT Vehicle section. Here, the attendant can edit the information if needed or proceed with the checkout. Upon checkout, a receipt will be generated and displayed.</p>
                    <a href="tutorials/tips-and-tricks.html" class="read-more">View</a>
                </div>
            </div>
            <div class="tutorial-item">
                <img src="step4.jpg" alt="Tutorial 4" width="100%" height="200">
                <div class="tutorial-content">
                    <h2>Information Management</h2>
                    <p>After checking out the vehicle, the data will be transferred to the Information Management section. In this section, the information will be securely stored for future reference or record-keeping.</p>
                    <a href="tutorials/best-practices.html" class="read-more">View</a>
                </div>
            </div>
            <div class="tutorial-item">
                <img src="step5.jpg" alt="Tutorial 4" width="100%" height="200">
                <div class="tutorial-content">
                    <h2>View Report</h2>
                    <p>The View Report section is designed for generating detailed reports. It provides an overview of income within a specified date range and displays relevant client information for better record management.</p>
                    <a href="tutorials/best-practices.html" class="read-more">View</a>
                </div>
            </div>
            <div class="tutorial-item">
                <img src="step6.jpg" alt="Tutorial 4" width="100%" height="200">
                <div class="tutorial-content">
                    <h2>Total Income</h2>
                    <p>The Total Income section provides a comprehensive summary of the parking system's earnings. This includes details such as the top contributor (the vehicle type most frequently parked), as well as income breakdowns by daily, weekly, and monthly periods. Additionally, a bar graph is included to visually represent the income trends over time.</p>
                    <a href="tutorials/best-practices.html" class="read-more">View</a>
                </div>
            </div>
        </div>
    </div>
</section>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>

<section class="about" id="about">
        <div class="about-img">
            <img src="newlogo.png">
        </div>
        <div class="about-content">
            <h3>About <span>Parking System</span></h3>
            <h3>BSIT <span>21010</span></h3>
            <p>The BCP Parking System is an efficient solution for managing parking operations seamlessly. Designed for ease of use, it allows operators 
                to track available slots, record vehicle entries, and manage client information from a central dashboard. With features like real-time updates 
                and instant receipt generation, BCP Parking improves organization and reduces wait times, providing a smooth, user-friendly experience for both clients and staff.</p>
            <br>
        </div>
    </section>
<br>
<br>
<br>
<br>
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

