<?php 
    include("connection.php");
    include("login.php")
    ?>
    
    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parking System</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="icon" type="image/icon" href="newlogo.png">
</head>
<body>
    <div class="login-container">
       
        <img src="newlogo.png" alt="Parking System Logo">
        <div class="form-section">
            <h2>Login</h2>
            <form name="form" method="POST" action="login.php" onsubmit="return isvalid()" >
                <label style="color: white;">Username: </label>
                <input type="text" id="user" name="user">
                <label style="color: white;">Password: </label>
                <input type="password" id="pass" name="pass">
                <input type="submit" id="btn" value="Login" name = "submit">
            </form>
        </div>
    </div>
    <script>
            function isvalid(){
                var user = document.form.user.value;
                var pass = document.form.pass.value;
                if(user.length=="" && pass.length==""){
                    alert(" Username and password field is empty!!!");
                    return false;
                }
                else if(user.length==""){
                    alert(" Username field is empty!!!");
                    return false;
                }
                else if(pass.length==""){
                    alert(" Password field is empty!!!");
                    return false;
                }
                
            }
        </script>
</body>
</html>
