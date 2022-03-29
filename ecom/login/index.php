<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In Page</title>

    <link rel="stylesheet" href="../css/login.css">

</head>

<body>
    <div class="alert alert-warning" role="alert">
        <?php
        include '../database/koneksi.php';
        error_reporting(0);
        echo $_SESSION['error'];
        session_start();
        if (isset($_SESSION['username'])) {
            if ($_SESSION['username'] == 'admin') {
                // Halaman Admin
                header('Location:../admin/dashboard.php');
            } else {
                // Halaman User
                header('Location:../');
            }
        }

        if (isset($_POST['submit'])) {
            $username = $_POST['username'];
            $password = $_POST['password'];
            $sql = "SELECT * FROM user WHERE username='$username' AND password='$password'";
            $result = mysqli_query($koneksi, $sql);
            $hasil = mysqli_fetch_object($result);
            $cek = mysqli_num_rows($result);
            if ($cek > 0) {
                $_SESSION['username'] = $username;
                $_SESSION['id_user'] = $hasil->idUser;
                $_SESSION['status'] = 'login';
                if ($_POST['username'] == 'admin') {
                    // Halaman Admin
                    header('Location:../admin/dashboard.php');
                } else {
                    // Halaman User
                    header('Location:../');
                }
            } else {
                echo "<script>alert('Email atau password Anda salah. Silahkan coba lagi!')</script>";
            }
        }
        ?>
    </div>

    <div class="container">
        <form action="" method="POST" class="login-email">
            <p class="login-text" style="font-size: 2rem; font-weight: 800;">Login</p>
            <div class="input-group">
                <input type="text" placeholder="Username" name="username" value="<?php echo $username; ?>" required>
            </div>
            <div class="input-group">
                <input type="password" placeholder="Password" name="password" value="<?php echo $_POST['password']; ?>"
                    required>
            </div>
            <div class="input-group">
                <button name="submit" class="btn">Login</button>
            </div>
            <p class="login-register-text">Anda belum punya akun? <a href="register.php">Register</a></p>
        </form>
    </div>
</body>

</html>