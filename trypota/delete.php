<?php
include('db_connect.php'); // Include database connection

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // SQL to delete a record
    $sql = "DELETE FROM information_management WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $id);

    if ($stmt->execute()) {
        // Redirect back to the information management page with a success message
        header("Location: adminInformationManagement.php?message=Record deleted successfully");
        exit();
    } else {
        // Redirect back with an error message
        header("Location: adminInformationManagement.php?error=Unable to delete record");
        exit();
    }
} else {
    // Redirect if no ID is provided
    header("Location: adminInformationManagement.php");
    exit();
}
?>
