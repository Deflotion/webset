<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>

    <link rel="stylesheet" href="../css/sidebar.css">
    <link rel="stylesheet" href="../css/product.css">
</head>

<body>
    <?php
    include '../database/koneksi.php';

    if (isset($_GET['id'])) {
        $id = htmlspecialchars($_GET['id']);

        $query = "DELETE FROM printer_tb WHERE idPrinter='$id'";
        $result = mysqli_query($koneksi, $query);

        if ($result) {
            header('Location: index.php');
        } else {
            echo "<script>alert('Produk Gagal Dihapus')</script>";
        }
    }
    ?>
    <div class="sidebar">
        <h4 class="sidebar-brand">SHOP</h4>
        <ul>
            <li>
                <a href="../admin/dashboard.php">Dashboard</a>
            </li>
            <li>
                <a href="../product/index.php">Products</a>
            </li>
            <li class="active">
                <a href="index.php">Transaksi</a>
            </li>
            <li>
                <a href="../logout.php">Logout</a>
            </li>
        </ul>
    </div>
    <main>
        <div class="section-title">
            Data Transaksi
        </div>
        <div class="row">
            <div class="card mt-5">
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th>No</th>
                            <th>Product</th>
                            <th>Customer</th>
                            <th>Quantity</th>
                            <th>Harga</th>
                            <th>subtotal</th>
                            <th>Status</th>
                        </tr>
                        <?php
                    include '../database/koneksi.php';

                    $query =
                        'SELECT transaksi.subtotal, transaksi.Jumlah, transaksi.idTransaksi, transaksi.status ,  transaksi.UserIdUser2, user.Username, printer_tb.NamaPrinter, printer_tb.HargaPrinter FROM transaksi INNER JOIN user ON transaksi.UserIdUser2 = user.idUser INNER JOIN printer_tb ON transaksi.Printer_tblIdPrinter = printer_tb.idPrinter';
                    $result = mysqli_query($koneksi, $query);
                    $no = 1;
                    while ($data = mysqli_fetch_object($result)) { ?>

                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $data->NamaPrinter ?></td>
                            <td><?= $data->Username ?></td>
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

                        <?php }
                    ?>
                    </table>
                </div>
            </div>
        </div>
    </main>
</body>

</html>