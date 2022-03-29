<?php
// memulai session
session_start();
require '../database/koneksi.php';
require '../item.php';
// mengambil id user dari session
$iduser = $_SESSION['id_user'];
// memanggil session cart
$cart = unserialize(serialize($_SESSION['cart']));
$status = 1;
// looping data yang ada di dalam session cart
for ($i = 0; $i < count($cart); $i++) {
    // menghitung subtotal
    $subtotal = $cart[$i]->price * $cart[$i]->quantity;
    // jalankan query ini sesuai dengan jumlah data cart yang ada
    $sql2 = 'INSERT INTO transaksi (jumlah, subtotal, status, UserIdUser, HargaPrinter, Printer_tblIdPrinter, UserIdUser2) VALUES (' . $cart[$i]->quantity . ', ' . $subtotal . ' , ' . $status . '  , ' . $iduser . ', ' . $cart[$i]->price . ' , ' . $cart[$i]->id . ' , ' . $iduser . ')';
    mysqli_query($koneksi, $sql2); // jalankan query diatas
}
unset($_SESSION['cart']); // kosongkan kembali cart nya
header('Location: ../order/'); ?>// redirect ke halaman order