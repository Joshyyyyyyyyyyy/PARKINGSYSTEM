<?php 

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login & Register</title>
    <link href="styles2.css" rel="stylesheet">
</head>
<body>
<div class="wrapper">
        <div id="loginForm" class="form-container active">
            <form method="POST" action="loginholder.php" onsubmit="showLoading()">
                <h1>Login</h1>
                <div class="input-box">
                    <input type="email" name="email" placeholder="Email" required>
                    <i class='bx bxs-user'></i>
                </div>
                <div class="input-box">
                    <input type="password" name="password" placeholder="Password" required>
                    <i class='bx bxs-lock-alt'></i>
                </div>
                <button class="btn" type="submit">Login</button>
                <div class="register-link">
                    <p>Don't have an account? <a href="#" onclick="toggleForm('registerForm')">Register</a></p>
                </div>
            </form>
        </div>

        <div id="registerForm" class="form-container">
            <form method="POST" action="register.php">
                <h1>Create Account</h1>
                <div class="input-box">
                    <input type="text" name="firstname" placeholder="First name" required>
                    <i class='bx bxs-user'></i>
                </div>
                <div class="input-box">
                    <input type="text" name="lastname" placeholder="Last name" required>
                    <i class='bx bxs-user'></i>
                </div>
                <div class="input-box">
                    <input type="email" name="email" placeholder="Email" required>
                    <i class='bx bxs-envelope'></i>
                </div>
                <div class="input-box">
                    <input type="password" name="password" placeholder="Password" required>
                    <i class='bx bxs-lock-alt'></i>
                </div>
                <button class="btn" type="submit">Register</button>
                <div class="register-link">
                    <p>Already have an account? <a href="#" onclick="toggleForm('loginForm')">Login</a></p>
                </div>
            </form>
        </div>
    </div>

    <div id="successModal" class="modal">
        <div class="modal-content">
            <h3>Registration Successful!</h3>
            <p>Your account has been created successfully.</p>
            <button onclick="closeModal()">Close</button>
        </div>
    </div>

    <div id="loadingModal" class="loading-modal">
        <div class="spinner"></div>
    </div>

    <script>
        function toggleForm(formId) {
            document.getElementById('loginForm').classList.remove('active');
            document.getElementById('registerForm').classList.remove('active');
            document.getElementById(formId).classList.add('active');
        }

        function showLoading() {
            document.getElementById('loadingModal').style.display = 'flex';
            setTimeout(() => {
                document.getElementById('loadingModal').style.display = 'none';
            }, 3000);
        }
    </script>
</body>
</html>
