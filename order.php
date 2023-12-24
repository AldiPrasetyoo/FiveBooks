<?php
session_start();
$koneksi = require 'koneksi/koneksi.php';

if (!$koneksi) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

if (isset($_GET['pesan'])) {
	$id_jadwal = $_GET['pesan'];
    $query = "SELECT * FROM tiket WHERE ID = $id_jadwal";
    $result = mysqli_query($koneksi, $query);
	
    if ($result) {
		$info_tiket = mysqli_fetch_assoc($result);
    } else {
		echo "Error: " . mysqli_error($koneksi);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Tiket Pesawat</title>
    <link rel="stylesheet" href="./asset/css/style.css">
</head>
<body>
    <div class="kontainer-judul">
        <h1>Order Tiket Pesawat</h1>
    </div>

    <div class="kont-order">
        <form action="orderDone.php" method="post">
            <div>
                <label for="name">Nama:</label>
                <input type="text" name="nama" id="nama" required>
            </div>
            <div>
                <label for="email">Email:</label>
                <input type="text" name="email" id="email" required>
            </div>
			<div>
                <label for="tglTrx">Tanggal:</label>
                <input type="date" name="tglTrx" id="tglTrx" required>
            </div>
            <input type="text" name="id_tiket" value="<?= $id_jadwal ?>">
            <input type="submit" value="Order Now" name="order" class="tombol">
        </form>
    </div>
</body>
</html>
