<?php
session_start();

if (isset($_SESSION['username'])) {
    if ($_SESSION['role'] === 'admin') {
        header("Location: admin_dashboard.php");
        exit();
    } elseif ($_SESSION['role'] === 'attendant') {
        header("Location: parking_attendant_dashboard.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login & Registration Form</title>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" type="image/icon" href="newlogo.png">
</head>
<body>
    <div class="container" id="container">
        <div class="form-container sign-up-container">
            <form action="register.php" method="POST" id="signUpForm">
                <img src="newlogo.png" alt="Logo" class="form-logo">
                <h1>Create Account</h1>
                <input type="text" name="username" placeholder="Username" required />
                <input type="password" name="password" placeholder="Password" required />
                <select name="role" required>
                    <option value="">Select Role</option>
                    <option value="admin">Admin</option>
                    <option value="attendant">Parking Attendant</option>
                </select>
                <button type="submit">Sign Up</button>
            </form>
        </div>
        <div class="form-container sign-in-container">
            <form action="login.php" method="POST" id="signInForm">
                <img src="newlogo.png" alt="Logo" class="form-logo">
                <h1>Sign in</h1>

                <!-- Notification display moved here for visibility -->
                <div id="notification" style="color: red; margin-bottom: 10px; text-align: center;">
                    <?php 
                    // Display the notification if it exists
                    if (isset($_SESSION['notification'])) { 
                        echo $_SESSION['notification']; 
                        unset($_SESSION['notification']); // Clear notification after displaying
                    } 
                    ?>
                </div>

                <input type="text" name="username" placeholder="Username" required />
                <input type="password" name="password" placeholder="Password" required />
                <button type="submit">Sign In</button>
            </form>
        </div>
        <div class="overlay-container">
            <div class="overlay">
                <div class="overlay-panel overlay-left">
                    <h1>Welcome to Parking System!</h1>
                    <p>Sign in if you have already an account</p>
                    <button class="ghost" id="signIn">Sign In</button>
                </div>
                <div class="overlay-panel overlay-right">
                    <h1>Welcome to Parking System!</h1>
                    <p>Create an account if you don't have an account</p>
                    <button class="ghost" id="signUp">Sign Up</button>
                </div>
            </div>
        </div>
    </div>

    <script src="script.js"></script>
</body>
</html>
