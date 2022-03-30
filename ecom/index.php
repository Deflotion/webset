<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Geming  Shop</title>

    <!-- Style CSS -->
    <link rel="stylesheet" href="css/home.css">
    <link rel="stylesheet" href="css/navbar.css">

</head>

<body>
    <nav class="navbar">
        <!-- Logo Icon -->
        <div class="navbar-brand">
            <div class="round">
                <a href="" class="nav-link active"><img src="image/logo.png" alt=""></a>
            </div>
            <a href="" class="nav-link-brand"><h4>Geming Shop</h4></a>
        </div>

        <!-- Navbar -->
        <ul class="navbar-item">
            <li class="nav-item">
                <a href="index.php" class="nav-link active">Home</a>
            </li>
            <li class="nav-item">
                <a href="order/" class="nav-link">Orders</a>
            </li>
            <li class="nav-item">
                <a href="cart/" class="nav-link">Cart</a>
            </li>
            <?php

            // Memulai Session
            session_start();

            // Melakukan Pengecekan Apakah di dalam session terdapat array username
            // Jika Ada Maka Jalankan Program Ini
            if (isset($_SESSION['status'])) {

                // Melakukan apakah di dalam array username itu adalah admin atau bukan
                // Jika Admin maka jalankan program ini
                if ($_SESSION['status'] == 'admin') {
                    // Halaman Admin
                    echo '
                        <li class="nav-item">
                            <a href="admin/dashboard.php" class="nav-link">Dashboard</a>
                        </li>
                    ';
                }

                // Jika Bukan Admin Maka Jalankan Program Ini

                else {
                    echo '
                        <li class="nav-item">
                            <a href="logout.php" class="nav-link">Logout</a>
                        </li>
                    ';
                }
            }

            // Jika Tidak Ada Maka Jalankan Program Ini

            else {
                echo '
                        <li class="nav-item">
                            <a href="login/" class="nav-link">Sign In</a>
                        </li>
                    ';
            }
            ?>

        </ul>

        
    </nav>

    <!-- Banner -->


    <!-- Main Page -->
    <div class="container">
        <div class="section-title">
            New Products
        </div>
        <div class="row-card">
            <?php
            // Memanggil file koneksi.php
            include 'database/koneksi.php';

            // Query untuk menampilkan produk berdasarkan id printer terbaru atau terbesar
            $query = 'SELECT * FROM printer_tb ORDER BY idPrinter DESC';
            // Jalankan Query
            // variable koneksi berasal dari file koneksi.php
            $result = mysqli_query($koneksi, $query);

            // looping data nya berupa array
            while ($data = mysqli_fetch_array($result)) { ?>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header">
                        <div class="round-card">
                            <a href="cart/index.php?id=<?php echo $data['idPrinter']; ?>&action=add" class="link-order">Order</a>
                        </div>
                        
                    </div>
                    <div class="card-image">
                        <div class="round-card-image">
                            <img src="img-product/<?= $data['GambarPrinter'] ?>" alt="">
                        </div>
                    </div>
                    <div class="card-body">
                        <h4 class="text-title"><?= $data['NamaPrinter'] ?></h4>
                        <p class="text-desc"><?= $data['SpesifikasiPrinter'] ?></p>
                        <h6 class="text-price"><?= 'Rp.' .number_format($data['HargaPrinter']) ?></h6>
                    </div>
                </div>
            </div>

            <?php }
            ?>
        </div>
    </div>
</body>

</html>