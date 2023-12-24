<?php
require 'koneksi/koneksi.php';
session_start();

if (!isset($_SESSION['id_user'])) {
    header('Location: login.php');
    exit();
}

// Check if the tiket_id parameter is set
if (isset($_GET['tiket_id'])) {
    $tiket_id = $_GET['tiket_id'];

    // Fetch tiket information
    $query = "SELECT
                penumpang.Nama AS Nama_Pembeli,
                penumpang.Email AS Email_Pembeli,
                jadwal.Harga AS Harga,
                kursi.Kelas AS Kelas,
                kursi.No_Kursi AS No_Kursi,
                maskapai.Nama AS Nama_Maskapai,
                CONCAT(rute_asal.Nama, ' - ', rute_tujuan.Nama) AS Rute,
                jadwal.Waktu_Berangkat,
                jadwal.Waktu_Tiba
              FROM
                tiket
              JOIN penumpang ON tiket.ID_Penumpang = penumpang.ID
              JOIN jadwal ON tiket.ID_Jadwal = jadwal.ID
              JOIN kursi ON tiket.ID_Kursi = kursi.ID
              JOIN rute ON jadwal.ID_Rute = rute.ID
              JOIN bandara AS rute_asal ON rute.ID_BandaraAsal = rute_asal.ID
              JOIN bandara AS rute_tujuan ON rute.ID_BandaraTujuan = rute_tujuan.ID
              JOIN maskapai ON jadwal.ID_Pesawat = maskapai.ID
              WHERE
                tiket.ID = $tiket_id";

    $result = mysqli_query($koneksi, $query) or die(mysqli_error($koneksi));

    if ($row = mysqli_fetch_assoc($result)) {
        // Include the HTML code for printing the ticket
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Cetak Tiket</title>
        </head>
        <body>
            <table border="1">
                <tr>
                    <th>Nama Pembeli</th>
                    <th>Email Pembeli</th>
                    <th>Harga</th>
                    <th>Kelas</th>
                    <th>No Kursi</th>
                    <th>Nama Maskapai</th>
                    <th>Rute</th>
                    <th>Tanggal Berangkat</th>
                    <th>Tanggal Tiba</th>
                </tr>
                <tr>
                    <td><?= $row['Nama_Pembeli'] ?></td>
                    <td><?= $row['Email_Pembeli'] ?></td>
                    <td><?= $row['Harga'] ?></td>
                    <td><?= $row['Kelas'] ?></td>
                    <td><?= $row['No_Kursi'] ?></td>
                    <td><?= $row['Nama_Maskapai'] ?></td>
                    <td><?= $row['Rute'] ?></td>
                    <td><?= $row['Waktu_Berangkat'] ?></td>
                    <td><?= $row['Waktu_Tiba'] ?></td>
                </tr>
            </table>
        </body>
        </html>
        <?php
        exit();
    } else {
        // Handle the case where tiket_id is not valid or not found
        echo 'Invalid Tiket ID.';
    }
} else {
    // Handle the case where tiket_id parameter is not set
    echo 'Tiket ID is not specified.';
}
?>
