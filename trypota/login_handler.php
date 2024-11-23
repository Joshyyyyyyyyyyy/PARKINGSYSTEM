<?php
session_start();

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db2";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

// Login processing
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $inputUsername = trim($_POST['username']);
    $inputPassword = trim($_POST['password']);

    // Sanitize user inputs
    $inputUsername = $conn->real_escape_string($inputUsername);

    // Retrieve user data
    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Statement preparation failed: " . $conn->error);
    }

    $stmt->bind_param("s", $inputUsername);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verify hashed password
        if (password_verify($inputPassword, $user['password'])) {
            session_regenerate_id(); // Prevent session fixation
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];

            // Redirect based on role
            if ($user['role'] === 'admin') {
                header("Location: admindashboard.php");
                exit();
            } elseif ($user['role'] === 'attendant') {
                header("Location: attendantdashboard.php");
                exit();
            }
        } else {
            // Incorrect password
            $_SESSION['error'] = "Invalid password.";
            header("Location: login.php");
            exit();
        }
    } else {
        // User not found
        $_SESSION['error'] = "User not found.";
        header("Location: login.php");
        exit();
    }

    $stmt->close();
}

$conn->close();
?>
