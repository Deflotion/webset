<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop</title>

    <!-- Style CSS -->
    <link rel="stylesheet" href="../css/navbar.css">
    <link rel="stylesheet" href="../css/order.css">
</head>

<body>
<nav class="navbar">
        <!-- Logo Icon -->
        <div class="navbar-brand">
            <div class="round">
                <a href="../" class="nav-link active"><img src="../image/logo.png" alt=""></a>
            </div>
            <a href="../" class="nav-link-brand"><h4>Geming Shop</h4></a>
        </div>

        <!-- Navbar -->
        <ul class="navbar-item">
            <li class="nav-item">
                <a href="../" class="nav-link">Home</a>
            </li>
            <li class="nav-item">
                <a href="../order/" class="nav-link active">Orders</a>
            </li>
            <li class="nav-item">
                <a href="../cart/" class="nav-link">Cart</a>
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
                            <a href="../logout.php" class="nav-link">Logout</a>
                        </li>
                    ';
                }
            }
            // Jika Tidak Ada Maka Jalankan Program Ini
            else {
                echo '
                        <li class="nav-item">
                            <a href="../login/" class="nav-link">Sign In</a>
                        </li>
                    ';
            }
            ?>
        </ul>
        
    </nav>
    <div class="container">
        <h2 class="section-title">List Transaksi Anda</h2>
    </div>

    <div class="row">
        <div class="card mt-5">
            <div class="table-responsive">
                <table>
                    <tr>
                        <th>No</th>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Harga</th>
                        <th>subtotal</th>
                        <th>Status</th>
                    </tr>
                    <?php
                    // menghubungkan file koneksi yang berada di folder database
                    include '../database/koneksi.php';
                    // Cek apakah id_user tersimpan di dalam session, jika ada jalankan ini
                    if (isset($_SESSION['id_user'])) {
                        $id = $_SESSION['id_user']; // mengambil id_user yang ada di session lalu menyimpan nya ke dalam variabel
                        // query select table transaksi berserta dengan relasi tabel lain menggunakan inner join
                        $query = "SELECT transaksi.subtotal, transaksi.Jumlah, transaksi.idTransaksi, transaksi.status ,  transaksi.UserIdUser2, user.Username, printer_tb.NamaPrinter, printer_tb.HargaPrinter FROM transaksi INNER JOIN user ON transaksi.UserIdUser2 = user.idUser INNER JOIN printer_tb ON transaksi.Printer_tblIdPrinter = printer_tb.idPrinter WHERE UserIdUser2 = '$id'";
                        // jalankan query diatas
                        $result = mysqli_query($koneksi, $query);
                        $no = 1;
                        // looping datanya berupa object
                        while ($data = mysqli_fetch_object($result)) { ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= $data->NamaPrinter ?></td>
                        <td><?= $data->Jumlah ?></td>
                        <td><?= number_format($data->HargaPrinter) ?></td>
                        <td><?= number_format($data->subtotal) ?></td>
                        <?php 
                            
                            if ($data->status == 1) {
                            ?>
                        <td><span class="badge-warning">Belum Dikonfirmasi</span></td>
                        <?php 
                            } else {
                            ?>
                        <td><span class="badge-success">Sudah Dikonfirmasi</span></td>
                        <?php } ?>
                    </tr>
                    <?php } }
                    ?>
                </table>
            </div>
        </div>
    </div>
</body>

</html>