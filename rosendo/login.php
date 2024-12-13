<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOG-IN FORM</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=jost:wght@500&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/SimpleLightbox/2.1.0/simpleLightbox.min.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="slidestyle.css">
</head>
<body>
    <div class="main">
        <input type="checkbox" id="chk" aria-hidden="true">
        
        <div class="signup">
            <form action="register.php" method="POST">
                <label for="chk" aria-hidden="true">Create Account</label>
                <input type="text" name="fullname" placeholder="Fullname:" required>
                <input type="email" name="email" placeholder="Email:" required>
                <input type="password" name="password" placeholder="Password:" required>
                <button type="submit" name="register">Submit</button>
            </form>
        </div>

        <div class="login">
            <form action="loginholder.php" method="POST">
                <label for="chk" aria-hidden="true">Log-in</label>
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit" name="login">Login</button>
            </form>
        </div>
    </div>
</body>
</html>
