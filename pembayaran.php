<?php
require 'koneksi/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['bayar'])) {
    $tiket_id = $_POST['tiket_id'];
    $id_user = $_POST['id_user'];

    $query = "SELECT transaksi.ID AS Transaksi_ID, transaksi.Status_Transaksi
              FROM tiket
              JOIN transaksi ON tiket.ID_Transaksi = transaksi.ID
              WHERE tiket.ID = $tiket_id AND tiket.ID_User = $id_user";
    $result = mysqli_query($koneksi, $query) or die(mysqli_error($koneksi));

    if ($row = mysqli_fetch_assoc($result)) {
        $status_transaksi = $row['Status_Transaksi'];
        if ($status_transaksi == 'BELUM BAYAR') {
            $update_query = "UPDATE transaksi SET Status_Transaksi = 'LUNAS' WHERE ID = {$row['Transaksi_ID']}";
            mysqli_query($koneksi, $update_query) or die(mysqli_error($koneksi));
        }
    } else {
        echo 'Invalid Tiket ID.';
    }
    header("Location: pesanan.php");
    exit();
}

?>