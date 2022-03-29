<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>

    <link rel="stylesheet" href="../css/sidebar.css">
    <link rel="stylesheet" href="../css/tambah_product.css">
</head>

<body>
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
        <?php
            include '../database/koneksi.php';
            $id = $_GET['id'];
            $data = mysqli_query($koneksi,"select * from printer_tb where idPrinter ='$id'");
            while($d = mysqli_fetch_array($data)){
        ?>

        <div class="section-title">
            Data Product
        </div>
        <div class="container">
            <form action="" method="post" enctype="multipart/form-data">
                <label for="name">Nama Printer</label>
                <input type="text" id="name" name="name" class="form-control" value="<?php echo $d['NamaPrinter'] ?>"
                    placeholder="Nama Printer">

                <label for="harga">Harga Printer</label>
                <input type="number" id="harga" name="price" class="form-control"
                    value="<?php echo $d['HargaPrinter'] ?>" placeholder="Harga Printer">

                <label for="spesifikasi">Spesifikasi Printer</label>
                <textarea name="spesifikasi" class="form-control" maxlength="50" id="spesifikasi" cols="30"
                    rows="5"><?php echo $d['SpesifikasiPrinter'] ?></textarea>

                <label for="harga">Gambar Printer</label>
                <input type="file" id="harga" name="image" class="form-control">

                <input type="submit" class="btn-success" name="submit" value="Submit">
            </form>
        </div>
        <?php 
            }
        ?>

        <?php 
        
        // Cek apakah tombol submit diklik jika ya maka jalankan ini
        if (isset($_POST['submit'])) {
            include "../database/koneksi.php";

            $id = $_GET['id'];  // mengambil id dari data yang dikirm lalu menyimpannya ke dalam variable
            $nama = $_POST['name']; // mengambil name dari data yang dikirm lalu menyimpannya ke dalam variable
            $harga = $_POST['price']; // mengambil price dari data yang dikirm lalu menyimpannya ke dalam variable
            $spesifikasi = $_POST['spesifikasi']; // mengambil spesifikasi dari data yang dikirm lalu menyimpannya ke dalam variable

            $namaFile = $_FILES['image']['name']; // mengambil nama file dari data yang dikirm lalu menyimpannya ke dalam variable

            // Jika file image ada maka jalankan ini
            if ($namaFile != "") {
                $dirUpload = "../img-product/";
                $namaSementara = $_FILES['image']['tmp_name'];
                $terupload = move_uploaded_file($namaSementara, $dirUpload.$namaFile);
                $query = mysqli_query($koneksi, "UPDATE printer_tb SET NamaPrinter='$nama', HargaPrinter='$harga' , SpesifikasiPrinter='$spesifikasi', GambarPrinter='$namaFile' WHERE idPrinter='$id'");
            } 
            // jika tidak maka jalankan ini
            else {
                $query = mysqli_query($koneksi, "UPDATE printer_tb SET NamaPrinter='$nama', HargaPrinter='$harga' , SpesifikasiPrinter='$spesifikasi' WHERE idPrinter='$id'");
            }

            // jika query berhasil dijalankan ini
            if ($query) {
                header("location:index.php?pesan=insert");
            }
        }
    ?>
</body>

</html>