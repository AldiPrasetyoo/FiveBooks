<?php
include 'koneksi/koneksi.php';

if (isset($_POST['btn'])) {
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "INSERT INTO user (Nama, Email, Password ) VALUES ('$nama', '$email', '$password')";
    $result = mysqli_query($koneksi, $sql);

    if ($result) {
        header("Location: login.php");
    } else {
        header("Location: regis.php");
        echo "error : " . $sql;
    }
}
?>