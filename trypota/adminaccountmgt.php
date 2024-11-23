<?php
include('db_connect.php'); // Database connection setup

$query = "SELECT * FROM users";
$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="dashboardadmin.css">
    <link rel="stylesheet" href="admins.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="icon" type="image/icon" href="newlogo.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">  
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <title>Parking System</title>
</head>
<style>
    .container{
        max-width: 1700px;
    }
  /* General Styling */
  body { font-family: Arial, sans-serif; color: #333; 
    background-color: #f4f6f9;
}

h2 { color: #1B3BA3; display: inline-block; }

.add-account-btn {
    float: right;
    padding: 10px 20px;
    font-size: 16px;
    color: #fff;
    background-color: #1B3BA3;
    text-decoration: none;
    border-radius: 5px;
    transition: background-color 0.3s ease;
    margin-top: 5px;
}
.add-account-btn:hover { background-color: #152A73; }

table { width: 100%; border-collapse: collapse; margin-top: 20px; background-color: #f9f9f9; }
table, th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
th { background-color: #1B3BA3; color: #fff; }

.action-btn { padding: 6px 12px; color: #fff; border-radius: 4px; text-decoration: none; font-size: 14px; transition: background-color 0.3s ease; margin: 0 2px; }
.edit-btn { background-color: #1B3BA3; }
.edit-btn:hover { background-color: #152A73; }
.delete-btn { background-color: #A31B3B; }
.delete-btn:hover { background-color: #73152A; }

/* Modal styling */
.modal {
    display: none;
    position: fixed;
    top: 0; left: 0;
    width: 100%; height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    justify-content: center;
    align-items: center;
}
.modal-content {
    background-color: white;
    padding: 20px;
    border-radius: 8px;
    width: 400px;
    text-align: center;
}
.close-btn {
    background-color: #f44336;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    margin-top: 20px;
}
.submit-btn {
    background-color: #1B3BA3;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    margin-top: 20px;
}
    </style>
<body>
<div class="topnav">
    <a class="name">Account Management</a>
        <div class="dropdown">
            <button class="account-btn" onclick="toggleDropdown()">Account</button>
            <div id="myDropdown" class="dropdown-content">
                <div class="user-info">
                    <div class="user-name">Admin</div>
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
<div class="sidebar" id="sidebar">
 <div class="logo">
    <img src="newlogo.png" alt="Parking System Logo" width="200" > 
</div>
<br>
<ul class="menu">
        <li>
            <a href="admindashboard.php">
                <i class="fas fa-gauge"></i>
                <span>Dashboard</span>
            </a>
        </li>
        <li class="active">
            <a href="adminaccountmgt.php">
                <i class="fa fa-user"></i>
                <span>Account Management</span>
            </a>
        </li>
        <li>
            <a href="adminparkingslot.php">
                <i class="bi bi-car-front-fill"></i>
                <span>Parking Slot</span>
            </a>
        </li>
       
        <li>
            <a href="adminout.php">
                 <i class="fa fa-xl fa-toggle-off color-teal"></i>
                  <span>IN/OUT Vehicles</span>
             </a>
        </li>
        <li>
            <a href="adminInformationManagement.php">
                <i class="fas fa-database"></i>
                <span>Information Management</span>                
            </a>
        </li>
        <li>
            <a href="adminviewreport.php">
                <i class="fas fa-file-alt"></i>
                <span>View Report</span>                
            </a>
        </li>
        <li>
            <a href="admintotalincome.php">
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
<button onclick="openModal('addModal')" class="add-account-btn">+ Add Account</button>

<table>
    <tr>
        <th>ID</th>
        <th>Username</th>
        <th>Password</th>
        <th>Role</th>
        <th>Actions</th>
    </tr>
    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
    <tr>
        <td><?php echo $row['id']; ?></td>
        <td><?php echo $row['username']; ?></td>
        <td><?php echo $row['password']; ?></td>
        <td><?php echo $row['role']; ?></td>
        <td>
            <button onclick="openEditModal(<?php echo $row['id']; ?>, '<?php echo $row['username']; ?>', '<?php echo $row['password']; ?>', '<?php echo $row['role']; ?>')" class="action-btn edit-btn"><i class="fas fa-edit"></i> Edit</button>
            <button onclick="confirmDelete(<?php echo $row['id']; ?>)" class="action-btn delete-btn"> <i class="fas fa-trash-alt"></i> Delete</button>
        </td>
    </tr>
    <?php } ?>
</table>

<!-- Add Account Modal -->
<div id="addModal" class="modal">
    <div class="modal-content">
        <h3>Add New Account</h3>
        <form id="addForm" onsubmit="addAccount(event)">
            <label>Username:</label>
            <input type="text" name="username" required><br><br>
            <label>Password:</label>
            <input type="text" name="password" required><br><br>
            <label>Role:</label>
            <select name="role" required>
                <option value="admin">Admin</option>
                <option value="attendant">Attendant</option>
            </select><br><br>
            <button type="submit" class="submit-btn">Add Account</button>
            <button type="button" class="close-btn" onclick="closeModal('addModal')">Close</button>
        </form>
    </div>
</div>

<!-- Edit Account Modal -->
<div id="editModal" class="modal">
    <div class="modal-content">
        <h3>Edit Account</h3>
        <form id="editForm" onsubmit="editAccount(event)">
            <input type="hidden" name="id" id="editId">
            <label>Username:</label>
            <input type="text" name="username" id="editUsername" required><br><br>
            <label>Password:</label>
            <input type="text" name="password" id="editPassword" required><br><br>
            <label>Role:</label>
            <select name="role" id="editRole" required>
                <option value="admin">Admin</option>
                <option value="attendant">Attendant</option>
            </select><br><br>
            <button type="submit" class="submit-btn">Update Account</button>
            <button type="button" class="close-btn" onclick="closeModal('editModal')">Close</button>
        </form>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="modal">
    <div class="modal-content">
        <h3>Are you sure you want to delete this account?</h3>
        <button id="confirmDeleteBtn" class="submit-btn">Yes, Delete</button>
        <button type="button" class="close-btn" onclick="closeModal('deleteModal')">No, Cancel</button>
    </div>
</div>
</div>
<script>
function openModal(modalId) {
    document.getElementById(modalId).style.display = 'flex';
}

function closeModal(modalId) {
    document.getElementById(modalId).style.display = 'none';
}

function openEditModal(id, username, password, role) {
    document.getElementById('editId').value = id;
    document.getElementById('editUsername').value = username;
    document.getElementById('editPassword').value = password;
    document.getElementById('editRole').value = role;
    openModal('editModal');
}

function confirmDelete(id) {
    document.getElementById('confirmDeleteBtn').onclick = function() {
        deleteAccount(id);
    };
    openModal('deleteModal');
}

function addAccount(event) {
    event.preventDefault();
    const formData = new FormData(document.getElementById('addForm'));
    
    fetch('add_account.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        alert(data);
        location.reload();
    })
    .catch(error => console.error('Error:', error));
}

function editAccount(event) {
    event.preventDefault();
    const formData = new FormData(document.getElementById('editForm'));
    
    fetch('edit_account.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        alert(data);
        location.reload();
    })
    .catch(error => console.error('Error:', error));
}

function deleteAccount(id) {
    fetch(`delete_account.php?id=${id}`)
    .then(response => response.text())
    .then(data => {
        alert(data);
        location.reload();
    })
    .catch(error => console.error('Error:', error));
}
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
