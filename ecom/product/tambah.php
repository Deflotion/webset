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
        <div class="section-title">
            Tambah Product
        </div>
        <div class="container">
            <form action="" method="post" enctype="multipart/form-data">
                <label for="name">Nama Printer</label>
                <input type="text" id="name" name="name" class="form-control" placeholder="Nama Printer">

                <label for="harga">Harga Printer</label>
                <input type="number" id="harga" name="price" class="form-control" placeholder="Harga Printer">

                <label for="spesifikasi">Spesifikasi Printer</label>
                <textarea name="spesifikasi" class="form-control" maxlength="50" id="spesifikasi" cols="30"
                    rows="10"></textarea>

                <label for="harga">Gambar Printer</label>
                <input type="file" id="harga" name="image" class="form-control" placeholder="Harga Printer">

                <input type="submit" name="submit" class="btn-success" value="Submit">
            </form>
        </div>
    </main>

    <?php 
    
        // Cek jika tombol submit ditekan maka jalankan ini
        if (isset($_POST['submit'])) {
            include "../database/koneksi.php";

            $nama = $_POST['name']; // mengambil name dari data yang dikirm lalu menyimpannya ke dalam variable
            $harga = $_POST['price']; // mengambil price dari data yang dikirm lalu menyimpannya ke dalam variable
            $spesifikasi = $_POST['spesifikasi']; // mengambil spesifikasi dari data yang dikirm lalu menyimpannya ke dalam variable

            $namaFile = $_FILES['image']['name']; // mengambil nama file image dari data yang dikirm lalu menyimpannya ke dalam variable
            $namaSementara = $_FILES['image']['tmp_name']; // set nama image
            $dirUpload = "../img-product/"; // lokasi tempat image akan disimpan

            $terupload = move_uploaded_file($namaSementara, $dirUpload.$namaFile); // simpan imaage ke dalam folder lokasi yang ditentukan diatas
            
            // menjalankan query menambah product berdasarkan field yang ada
            $query = mysqli_query($koneksi, "INSERT INTO printer_tb (NamaPrinter,HargaPrinter,SpesifikasiPrinter, GambarPrinter) VALUES('$nama' , '$harga' , '$spesifikasi' , '$namaFile')");
                
            // jika query berhasil maka jalankan ini
            if ($query) {
                header("location:index.php");
            }
        }
    ?>
</body>

</html>