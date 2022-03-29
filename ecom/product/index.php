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
        
        include "../database/koneksi.php";
        
        // Pengecekan apakah ada id yang dikirim jika ada maka jalankan ini
        if (isset($_GET['id'])) {

            // mengambil id yang dikirim
            $id = htmlspecialchars($_GET['id']);

            // query delete table berdasarkan id yang dikirim
            $query = "DELETE FROM printer_tb WHERE idPrinter='$id'";
            
            // menjalankan query
            $result = mysqli_query($koneksi, $query);

            // jika berhasil menjalankan query maka  jalankan ini
            if ($result) {
                header("Location: index.php");
            }
            // jika gagal maka tampilkan pesan ini
            else {
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
            <li class="active">
                <a href="index.php">Products</a>
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
            Data Product
        </div>
        <div class="row">
            <div class="card mt-5">
                <a href="tambah.php" class="btn btn-primary">Tambah Product</a>
                <div class="table-responsive">
                    <table border="1px">
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Spesifikasi</th>
                            <th>Harga</th>
                            <th>Action</th>
                        </tr>
                        <?php 
                        
                        include "../database/koneksi.php";

                        // query menampilkan semua isi table printer_tb berdasarkan id ny dan tampilkan secara descending
                        $query = "SELECT * FROM printer_tb ORDER BY idPrinter DESC";
                        $result = mysqli_query($koneksi, $query);
                        $no = 1;
                        // looping datanya berupa object
                        while ($data = mysqli_fetch_array($result))  { ?>
                        <tr>
                            <td><?php echo $no++; ?></td>
                            <td><?php echo $data['NamaPrinter'] ?></td>
                            <td><?php echo $data['SpesifikasiPrinter'] ?></td>
                            <td>
                                <?php 
                                        $harga = $data['HargaPrinter'];
                                        echo "Rp." . number_format($harga);
                                    ?>
                            </td>
                            <td>
                                <a href="edit.php?id=<?php echo htmlspecialchars($data['idPrinter']); ?>"
                                    class="btn-edit">Edit</a>
                                <a href="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>?id=<?php echo $data['idPrinter']; ?>"
                                    class="btn-delete">Delete</a>
                            </td>
                        </tr>
                        <?php 
                        }
                        ?>
                    </table>
                </div>
            </div>
        </div>
    </main>
</body>

</html>