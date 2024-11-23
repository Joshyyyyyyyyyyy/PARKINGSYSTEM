<?php
include('db_connect.php'); // Database connection setup

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $role = mysqli_real_escape_string($conn, $_POST['role']);

    // Hash the password securely
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $query = "INSERT INTO users (username, password, role) VALUES ('$username', '$hashedPassword', '$role')";
    
    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Account added successfully!'); window.location.href = 'add_account_form.php';</script>";
    } else {
        echo "<script>alert('Error adding account: " . mysqli_error($conn) . "'); window.location.href = 'add_account_form.php';</script>";
    }
} else {
    echo "<script>alert('Invalid request method.'); window.location.href = 'add_account_form.php';</script>";
}

$conn->close();
?>
