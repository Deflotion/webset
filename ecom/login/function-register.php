<?php
include '../database/koneksi.php';
if (isset($_POST['submit'])) {
    $status   = $_POST['status']   = "user";
    $Username = $_POST['username'];
    $Password = $_POST['password'];

    $result = mysqli_query($koneksi, "INSERT INTO user SET username = '$Username' , password = '$Password', status = '$status'");
    header('location:../login/');
}
