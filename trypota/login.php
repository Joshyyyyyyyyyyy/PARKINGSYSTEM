<?php
session_start();
$errorMessage = isset($_SESSION['error']) ? $_SESSION['error'] : '';
unset($_SESSION['error']); // Clear the error after displaying it
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parking System</title>
    <link rel="stylesheet" href="">
    <link rel="icon" type="image/icon" href="newlogo.png">
</head>
<body>
    <div class="overlay"></div> <!-- Black Overlay background -->
    <div class="container">
        <div class="login-box">
            <div class="logo">
                <img src="newlogo.png" alt="BCP Parking System Logo"> <!-- Update with the path to your logo -->
            </div>
            <h2>LOGIN</h2>
            <form action="login_handler.php" method="POST" id="loginForm">
                <input type="text" name="username" placeholder="Username" required>
                
                <!-- Password input with eye icon inside -->
                <div class="password-container">
                    <input type="password" name="password" placeholder="Password" required id="password">
                    <span id="togglePassword" class="eye-icon">&#128065;</span>
                </div>

                <div class="remember-me">
                    <input type="checkbox" name="remember_me" id="remember_me">
                    <label for="remember_me">Remember Me</label>
                </div>
                <button type="submit">Sign In</button>
            </form>
        </div>
    </div>

    <!-- Modal for incorrect login -->
    <div class="modal" id="errorModal">
        <div class="modal-content">
            <span class="close" id="closeModal">&times;</span>
            <div class="notification-box">
                <p>Incorrect username or password. Please try again.</p>
                <br>
                <br>
                <button id="retryButton">Retry</button>
            </div>
        </div>
    </div>

    <script>
        // Password visibility toggle
        const togglePassword = document.getElementById("togglePassword");
        const passwordInput = document.getElementById("password");

        togglePassword.addEventListener("click", function() {
            // Toggle password visibility
            const type = passwordInput.type === "password" ? "text" : "password";
            passwordInput.type = type;
            this.classList.toggle("visible");
        });

        // Get the modal, close button, and retry button elements
        var modal = document.getElementById("errorModal");
        var closeModal = document.getElementById("closeModal");
        var retryButton = document.getElementById("retryButton");

        // Show modal when there's an error (wrong password)
        function showErrorModal() {
            modal.style.display = "flex"; // Show the modal
        }

        // Close modal when the user clicks the close button
        closeModal.onclick = function() {
            modal.style.display = "none"; // Hide the modal
        }

        // Close modal if the user clicks outside of it
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }


        // Retry button action
        retryButton.onclick = function() {
            modal.style.display = "none"; // Hide the modal to retry login
        }
    </script>
</body>
</html>

<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Arial', sans-serif;
}

body {
    background: url('bcp.jpg') no-repeat center center fixed;
    background-size: cover;
    display: flex;
    align-items: center;
    justify-content: center;
    height: 100vh;
    overflow: hidden;
}

.overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.75);
    z-index: 1;
}

.container {
    position: relative;
    z-index: 2;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100%;
}

.login-box {
    position: relative;
    background: rgba(0, 0, 0, 0.85);
    width: 400px;
    padding: 40px 30px;
    border-radius: 15px;
    text-align: center;
    color: white;
    box-shadow: 0 0 15px rgba(0, 0, 0, 0.5), 0 0 25px rgba(27, 59, 163, 0.7);
    z-index: 2;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    animation: glow 1.5s ease-in-out infinite alternate;
}

.login-box:hover {
    transform: translateY(-8px);
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.6), 0 0 35px rgba(27, 59, 163, 0.9);
}

.logo img {
    width: 200px;
    margin-bottom: 20px;
    filter: drop-shadow(0 0 10px #007bff);
    animation: glow 1.5s ease-in-out infinite alternate;
}

@keyframes glow {
    from {
        filter: drop-shadow(0 0 5px #007bff);
    }
    to {
        filter: drop-shadow(0 0 20px #007bff);
    }
}

h2 {
    font-size: 28px;
    margin-bottom: 20px;
    color: #00aaff;
    font-weight: bold;
    letter-spacing: 1px;
}

form {
    display: flex;
    flex-direction: column;
}

input[type="text"],
input[type="password"] {
    width: 100%;
    padding: 12px;
    margin: 12px 0;
    border: 1px solid rgba(255, 255, 255, 0.3);
    border-radius: 30px;
    background: rgba(255, 255, 255, 0.1);
    color: white;
    font-size: 16px;
    text-align: center;
    outline: none;
    transition: background 0.3s ease, border 0.3s ease;
}

input[type="text"]:focus,
input[type="password"]:focus {
    background: rgba(255, 255, 255, 0.2);
    border: 1px solid #00aaff;
}

button {
    padding: 12px;
    border: none;
    border-radius: 30px;
    background-color: #007bff;
    color: white;
    font-size: 18px;
    cursor: pointer;
    transition: background-color 0.3s ease, transform 0.3s ease;
    font-weight: bold;
    letter-spacing: 1px;
}

button:hover {
    background-color: #0056b3;
    transform: translateY(-5px);
}

button:active {
    transform: translateY(2px);
}

.remember-me {
    display: flex;
    align-items: center;
    margin: 15px 0;
    justify-content: flex-start;
}

.remember-me input {
    margin-right: 8px;
}

.remember-me label {
    font-size: 14px;
    color: #fff;
}

/* Modal styles */
.modal {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.7);
    z-index: 3;
    justify-content: center;
    align-items: center;
}

/* New keyframe for red glow */
@keyframes redGlow {
    from {
        filter: drop-shadow(0 0 5px #ff0000); /* Red glow at the start */
    }
    to {
        filter: drop-shadow(0 0 20px #ff0000); /* Red glow at the end */
    }
}

/* Apply the red glow animation to the modal content */
.modal-content {
    background-color: #232323;
    margin: auto;
    padding: 20px;
    border-radius: 10px;
    text-align: center;
    color: #333;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
    animation: redGlow 1.5s ease-in-out infinite alternate; /* Apply red glow animation */
}


.close {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.close:hover,
.close:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
}

/* Improved notification box */
.notification-box {
    padding: 20px;
    background-color: #2c2c2c;
    color: white;
    font-size: 18px;
    border-radius: 5px;
    margin-bottom: 20px;
}
p {
    color: #ff4d4d;
}
button#retryButton {
    background-color: #ff4d4d;
    border: none;
    padding: 10px 20px;
    border-radius: 25px;
    color: white;
    font-weight: bold;
    cursor: pointer;
    position: relative;
    overflow: hidden;
    transition: all 0.3s ease;
}

/* Glowing effect */
button#retryButton::before {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 300%;
    height: 300%;
    background: rgba(255, 77, 77, 0.5);
    border-radius: 50%;
    transform: translate(-50%, -50%);
    animation: glow-animation 2s infinite;
    z-index: 0;
}

/* Glow animation */
@keyframes glow-animation {
    0% {
        transform: translate(-50%, -50%) scale(1);
        box-shadow: 0 0 10px rgba(255, 77, 77, 0.8);
    }
    50% {
        transform: translate(-50%, -50%) scale(1.5);
        box-shadow: 0 0 20px rgba(255, 77, 77, 1);
    }
    100% {
        transform: translate(-50%, -50%) scale(1);
        box-shadow: 0 0 10px rgba(255, 77, 77, 0.8);
    }
}

/* Make the button text appear on top of the glowing effect */
button#retryButton:hover {
    background-color: #ff1a1a;
    transform: translateY(-5px);
    box-shadow: 0 0 15px rgba(255, 77, 77, 1);
}

button#retryButton:active {
    transform: translateY(2px);
}

/* Eye icon inside password */
.password-container {
    position: relative;
    width: 100%;
}

.eye-icon {
    font-size: 20px;
    position: absolute;
    right: 10px;
    top: 50%;
    transform: translateY(-50%);
    cursor: pointer;
    color: white;
}

.eye-icon.visible {
    color: #00aaff;
}
</style>
