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
            <a href="../" class="nav-link-brand">
                <h4>Geming Shop</h4>
            </a>
        </div>

        <!-- Navbar -->
        <ul class="navbar-item">
            <li class="nav-item">
                <a href="../" class="nav-link">Home</a>
            </li>
            <li class="nav-item">
                <a href="../order/" class="nav-link">Orders</a>
            </li>
            <li class="nav-item">
                <a href="../cart/" class="nav-link active">Cart</a>
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
                            <a href="login/" class="nav-link">Sign In</a>
                        </li>
                    ';
            }
            ?>
        </ul>
    </nav>
    <?php

    require '../database/koneksi.php';
    // menghubungkan file item 
    require '../item.php';

    // cek apakah ada id yang dikirim
    if (isset($_GET['id']) && !isset($_POST['update'])) {
        // query select table printer berdasarkan id
        $sql = 'SELECT * FROM printer_tb WHERE idPrinter=' . $_GET['id'];
        // jalankan query diatas
        $result = mysqli_query($koneksi, $sql);
        // tampilkan datanya berupa object
        $product = mysqli_fetch_object($result);
        // initialisasi file item sebagai class item
        $item = new Item();
        $item->id = $product->idPrinter; // masukan id printer ke dalam item->id
        $item->name = $product->NamaPrinter; // masukan nama printer ke dalam item->name
        $item->price = $product->HargaPrinter; // masukan harga printer ke dalam item->price
        $iteminstock = 10; // masukan stok printer ke dalam iteminstock
        $item->quantity = 1; // masukan quantity printer ke dalam item->quantity

        // jika session cart kosong maka kita isi session cart sebagia array kosong
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        //Periksa produk dalam keranjang
        $index = -1;
        $cart = unserialize(serialize($_SESSION['cart']));
        // looping data yang data didalam session cart
        for ($i = 0; $i < count($cart); $i++) {
            if ($cart[$i]->id == $_GET['id']) {
                $index = $i;
                break;
            }
        }

        if ($index == -1) {
            $_SESSION['cart'][] = $item;
        }
        //$ _SESSION ['cart']: set $ cart sebagai variabel _session
        else {
            if ($cart[$index]->quantity < $iteminstock) {
                $cart[$index]->quantity++;
            }

            $_SESSION['cart'] = $cart;
        }
    }
    //Menghapus produk dalam keranjang
    if (isset($_GET['index']) && !isset($_POST['update'])) {
        $cart = unserialize(serialize($_SESSION['cart']));
        unset($cart[$_GET['index']]);
        $cart = array_values($cart);
        $_SESSION['cart'] = $cart;
    }
    // Perbarui jumlah dalam keranjang
    if (isset($_POST['update'])) {
        $arrQuantity = $_POST['quantity'];
        $cart = unserialize(serialize($_SESSION['cart']));
        for ($i = 0; $i < count($cart); $i++) {
        $cart[$i]->quantity = $arrQuantity[$i];
        $_SESSION['cart'] = $cart;
        }
    }

    ?>
    <div class="container">
        <h2 class="section-title">keranjang Belanja Anda</h2>
        <form method="POST">
            <table id="t01">
                <tr>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                    <th>Aksi</th>
                </tr>
                <?php
                if (!isset($_SESSION['cart'])) {
                    $_SESSION['cart'] = [];
                }
                $cart = unserialize(serialize($_SESSION['cart']));
                $s = 0;
                $index = 0;
                for ($i = 0; $i < count($cart); $i++) {
                    $s += $cart[$i]->price * $cart[$i]->quantity; ?>
                <tr>
                    <td> <?php echo $cart[$i]->id; ?> </td>
                    <td> <?php echo $cart[$i]->name; ?> </td>
                    <td>Rp. <?php echo number_format($cart[$i]->price); ?> </td>
                    <td> <input type="number" class="form-number" min="1" value="<?php echo $cart[$i]->quantity; ?>"
                            name="quantity[]"> </td>
                    <td> Rp.<?php echo number_format(
                                    $cart[$i]->price * $cart[$i]->quantity
                                ); ?> </td>
                    <td style="display: flex;align-items: center;justify-content: center;">
                        <a href="index.php?index=<?php echo $index; ?>" class="btn-danger"
                            onclick="return confirm('Apa Kamu Yakin Ingin Menghapus Ini?')">
                            Delete</a>
                    </td>
                </tr>
                <?php $index++;
                }
                ?>
                <tr>
                    <td colspan="3"> Total </td>
                    <td colspan="2">Rp.<?php echo number_format($s); ?></td>
                    <td style="text-align:right; font-weight:500">
                        <!-- <input id="saveimg" type="image" name="update" alt="Save Button"> -->
                        <button name="update" class="submit">Hitung</button>
                        <!-- <input type=" hidden" name="update"> -->
                    </td>
                </tr>
            </table>
        </form>
        <br>
        <a href="../index.php" class="btn btn-info">Lanjut Belanja</a>
        <?php

        if (isset($_SESSION['id_user'])) {
        ?>
        | <a href="checkout.php" class="btn btn-primary">Checkout</a>
        <?php } ?>
    </div>
    <?php if (isset($_GET['id']) || isset($_GET['index'])) {
        header('Location: index.php');
    } ?>
</body>

</html>