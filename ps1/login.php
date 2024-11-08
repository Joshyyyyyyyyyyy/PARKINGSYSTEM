<?php
session_start();
include 'connection.php';

// Clear any previous notifications
unset($_SESSION['notification']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT password, role FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($hashed_password, $role);
        $stmt->fetch();

        if (password_verify($password, $hashed_password)) {
            $_SESSION['username'] = $username;
            $_SESSION['role'] = $role;

            // Redirect to the appropriate dashboard
            if ($role === 'admin') {
                header("Location: admin_dashboard.php");
            } else {
                header("Location: parking_attendant_dashboard.php");
            }
            exit();
        } else {
            $_SESSION['notification'] = "Incorrect password."; // Set notification
        }
    } else {
        $_SESSION['notification'] = "User not found."; // Set notification
    }

    $stmt->close();
    $conn->close();

    // Redirect back to the index page to display the error
    header("Location: index.php");
    exit();
}
?>
