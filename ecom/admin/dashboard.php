<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <link rel="stylesheet" href="../css/dashboard.css">
    <link rel="stylesheet" href="../css/sidebar.css">
</head>

<body>
    <div class="sidebar">
        <h4 class="sidebar-brand">SHOP</h4>
        <ul>
            <li class="active">
                <a href="dashboard.php">Dashboard</a>
            </li>
            <li>
                <a href="../product/index.php">Products</a>
            </li>
            <li>
                <a href="../transaksi">Transaksi</a>
            </li>
            <li>
                <a href="../logout.php">Logout</a>
            </li>
        </ul>
    </div>
    <main>
        <div class="section-title">
            Dashboard
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        Total Printer
                    </div>
                    <div class="card-body">
                        <?php
                        include '../database/koneksi.php';
                        $query = "SELECT count(*) as total FROM printer_tb";
                        $result = mysqli_query($koneksi, $query);
                        $hasil = mysqli_fetch_assoc($result);
                        echo $hasil['total'];
                        ?>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        Total Transaksi
                    </div>
                    <div class="card-body">
                        <?php
                        include '../database/koneksi.php';
                        $query = "SELECT count(*) as total FROM transaksi";
                        $result = mysqli_query($koneksi, $query);
                        $hasil = mysqli_fetch_assoc($result);
                        echo $hasil['total'];
                        ?>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        Total User
                    </div>
                    <div class="card-body">
                        <?php
                        include '../database/koneksi.php';
                        $query = "SELECT count(*) as total FROM user";
                        $result = mysqli_query($koneksi, $query);
                        $hasil = mysqli_fetch_assoc($result);
                        echo $hasil['total'];
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="section-title mt-3">
            Notifikasi Transaksi
        </div>
        <div class="card-notif">
            <table>
                <tr>
                    <th>No</th>
                    <th>Product</th>
                    <th>Customer</th>
                    <th>Quantity</th>
                    <th>Harga</th>
                    <th>subtotal</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>

                <?php
                include '../database/koneksi.php';
                $query = "SELECT transaksi.subtotal, transaksi.Jumlah, transaksi.idTransaksi, transaksi.status ,  transaksi.UserIdUser2, user.Username, printer_tb.NamaPrinter, printer_tb.HargaPrinter FROM transaksi INNER JOIN user ON transaksi.UserIdUser2 = user.idUser INNER JOIN printer_tb ON transaksi.Printer_tblIdPrinter = printer_tb.idPrinter";
                $result = mysqli_query($koneksi, $query);
                $no = 1;
                while ($data = mysqli_fetch_object($result)) {
                    if ($data->status == 1) { ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $data->NamaPrinter ?></td>
                    <td><?= $data->Username ?></td>
                    <td><?= $data->Jumlah ?></td>
                    <td><?= number_format($data->HargaPrinter) ?></td>
                    <td><?= number_format($data->subtotal) ?></td>
                    <td><span class="badge-warning">Belum Dikonfirmasi</span></td>
                    <td>
                        <a href="dashboard.php?id=<?= $data->idTransaksi ?>" class="btn-info">Konfirmasi</a>
                    </td>
                </tr>
                <?php }
                } ?>
            </table>
        </div>
    </main>

    <?php
    if (isset($_GET['id'])) {
        include '../database/koneksi.php';
        $id = $_GET['id'];
        $status = 2;
        $query = "UPDATE transaksi SET status='$status' WHERE idTransaksi = '$id'";
        $run = mysqli_query($koneksi, $query);
        if ($run) {
            header("location:dashboard.php");
        }
    }
    ?>
</body>

</html>