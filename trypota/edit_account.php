<?php
include('db_connect.php'); // Database connection setup

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = mysqli_real_escape_string($conn, $_POST['id']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $role = mysqli_real_escape_string($conn, $_POST['role']);

    $query = "UPDATE users SET username = '$username', password = '$password', role = '$role' WHERE id = $id";
    if (mysqli_query($conn, $query)) {
        echo "Account updated successfully!";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
} else {
    echo "Invalid request method.";
}
?>
