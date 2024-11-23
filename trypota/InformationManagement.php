<?php 
include('db_connect.php'); // Include database connection

// Fetch all data from the information_management table
$sql = "SELECT * FROM information_management";
$result = $conn->query($sql);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Information Management</title>
    <style>
        /* Page background */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        h1 {
            text-align: center;
            color: #1b3ba3;
            margin-top: 30px;
        }

        /* Table container */
        .table-container {
            width: 90%;
            margin: 20px auto;
            overflow-x: auto;
        }

        /* Search bar styling */
        .search-bar {
            width: 100%;
            padding: 12px;
            font-size: 16px;
            margin-bottom: 20px;
            border-radius: 5px;
            border: 1px solid #ddd;
        }

        /* Table styling */
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 0;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        th, td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
        }

        th {
            background-color: #1b3ba3;
            color: white;
        }

        td {
            background-color: #ffffff;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #ddd;
        }

        /* No data found styling */
        .no-data {
            text-align: center;
            color: #ff0000;
            font-size: 18px;
        }

        /* Responsive styling for smaller screens */
        @media (max-width: 600px) {
            table {
                width: 100%;
                font-size: 12px;
            }

            th, td {
                padding: 8px;
            }

            .search-bar {
                font-size: 14px;
            }
        }
    </style>
</head>
<body>
<h1>Client Information Management</h1>
    <div class="table-container">
        <!-- Search bar above table -->
        <input type="text" id="searchInput" class="search-bar" placeholder="Search by name or registration..." onkeyup="filterTable()">

        <?php 
        if ($result->num_rows > 0) {
            echo "<table id='infoTable'>
                    <tr>
                        <th>Name</th>
                        <th>Vehicle Type</th>
                        <th>Customer Type</th>
                        <th>Registration</th>
                        <th>Slot Number</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Price</th>
                    </tr>";

            // Display all the entries
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>" . htmlspecialchars($row['name']) . "</td>
                        <td>" . htmlspecialchars($row['vehicle_type']) . "</td>
                        <td>" . htmlspecialchars($row['customer_type']) . "</td>
                        <td>" . htmlspecialchars($row['registration']) . "</td>
                        <td>" . htmlspecialchars($row['slot_number']) . "</td>
                        <td>" . htmlspecialchars($row['date']) . "</td>
                        <td>" . htmlspecialchars($row['time']) . "</td>
                        <td>" . htmlspecialchars($row['price']) . "</td>
                    </tr>";
            }

            echo "</table>";
        } else {
            echo "<p class='no-data'>No data found in the information management system.</p>";
        }
        ?>

    </div>

    <script>
        // Function to filter table based on search input
        function filterTable() {
            let input = document.getElementById('searchInput');
            let filter = input.value.toLowerCase();
            let table = document.getElementById('infoTable');
            let tr = table.getElementsByTagName('tr');
            
            // Loop through all rows, and hide those that don't match the search
            for (let i = 1; i < tr.length; i++) {
                let tdName = tr[i].getElementsByTagName('td')[0]; // Name column
                let tdRegistration = tr[i].getElementsByTagName('td')[3]; // Registration column
                if (tdName || tdRegistration) {
                    let nameText = tdName.textContent || tdName.innerText;
                    let registrationText = tdRegistration.textContent || tdRegistration.innerText;
                    if (nameText.toLowerCase().indexOf(filter) > -1 || registrationText.toLowerCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }
        }
    </script>

</body>
</html>
