<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/login.css">
    <title>Register</title>
</head>
<body>
    <div class="container">
        <form method="POST" class="login-email" action="function-register.php">
            <p class = login-text style="font-size: 2rem; font-weight: 800;">Register</p><br>
            <div class = input-group>
                <input type="username" placeholder="Username" name="username" required></input>
            </div>
            <div class = input-group>
                <input type="password" placeholder="Password" name="password" required></input>
            </div>
            <div class = input-group>
                <button type="submit" class="btn"name="submit"><a>Register</a></button>
            </div>
                <p class="register-text">Sudah punya akun? <a href="../login/login.php">Login</a></p>
        </form>
    </div>

</body>
</html>
