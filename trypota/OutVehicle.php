<?php
include('db_connect.php');

// Fetch vehicles with status 'Out'
$sql = "SELECT * FROM vehicle_entries WHERE status IN ('In', 'Out')";
$result = $conn->query($sql);

if (!$result) {
    die("Error executing query: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Out Vehicle</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* Overlay and dimmed background styling */
        .overlay {
            display: none; /* Hidden by default */
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            justify-content: center;
            align-items: center;
            z-index: 999;
        }
        .overlay-content {
            background: white;
            padding: 20px;
            border-radius: 8px;
            max-width: 90%;
            width: 350px;
        }
        .close-btn {
            background-color: #333;
            color: white;
            padding: 5px;
            border: none;
            cursor: pointer;
            float: right;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Vehicles Ready for Checkout</h1>
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Vehicle Type</th>
                    <th>Customer Type</th>
                    <th>Registration</th>
                    <th>Slot Number</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Price</th>
                    <th>Action</th>
                    <th>Checkout</th>
                </tr>
            </thead>
            <tbody>
            <?php if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['vehicle_type']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['customer_type']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['registration']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['slot_number']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['date']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['time']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['price']) . "</td>";
                    echo "<td><a href='edit_vehicle.php?id=" . htmlspecialchars($row['id']) . "' class='edit-btn'>Edit</a></td>";
                    echo "<td><button class='checkout-btn' onclick='checkoutVehicle(" . htmlspecialchars($row['id']) . ")'>Checkout</button></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='10' class='no-data'>No vehicles ready for checkout</td></tr>";
            }
            ?>
            </tbody>
        </table>
    </div>

    <!-- Overlay for the receipt display -->
    <div id="overlay" class="overlay">
        <div class="overlay-content">
            <button class="close-btn" onclick="closeOverlay()">Close</button>
            <div id="receipt-content"></div>
        </div>
    </div>

    <script>
        function checkoutVehicle(vehicleId) {
            // Open the overlay and display loading message
            document.getElementById('overlay').style.display = 'flex';
            document.getElementById('receipt-content').innerHTML = "<p>Loading receipt...</p>";

            // AJAX request to fetch the receipt
            const xhr = new XMLHttpRequest();
            xhr.open("POST", "checkout.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    // Load the response (receipt) into the overlay
                    document.getElementById('receipt-content').innerHTML = xhr.responseText;
                }
            };
            xhr.send("vehicle_id=" + vehicleId);
        }

        function closeOverlay() {
            document.getElementById('overlay').style.display = 'none';
        }
    </script>
</body>
</html>
