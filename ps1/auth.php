<?php
// auth.php
session_start();

// Check if the user is logged in and has the 'admin' role
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    // Redirect to index.php if not authorized
    header("Location: index.php");
    exit();
}
?>
