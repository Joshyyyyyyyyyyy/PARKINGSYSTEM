<?php
include('db_connect.php'); // Database connection setup

if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);

    $query = "DELETE FROM users WHERE id = $id";
    if (mysqli_query($conn, $query)) {
        echo "Account deleted successfully!";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
} else {
    echo "Invalid user ID.";
}
?>
