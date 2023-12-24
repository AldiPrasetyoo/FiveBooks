<?php
require 'koneksi/koneksi.php';
session_start();
$id_user = $_SESSION["id_user"];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $kursiDipilih = $_POST["selected_seat"];
    $kelasDipilih = $_POST["selected_class"];
    $tgl = $_POST["tgl"];
    $hargaKelas = $_POST["hargaKelas"];
    $id_jadwal = $_POST["id_jadwal"];
    $namaPenumpang = $_POST["namaPembeli"];
    $emailPenumpang = $_POST["emailPembeli"];

    // Check if the passenger already exists
    $stmtCheckPassenger = $koneksi->prepare("SELECT ID FROM penumpang WHERE Nama = ? AND Email = ? ORDER BY ID DESC LIMIT 1");
    $stmtCheckPassenger->bind_param("ss", $namaPenumpang, $emailPenumpang);
    $stmtCheckPassenger->execute();
    $stmtCheckPassenger->store_result();

    if ($stmtCheckPassenger->num_rows != 0) {
        // Passenger exists, fetch the latest data
        $stmtCheckPassenger->bind_result($id_penumpang);
        $stmtCheckPassenger->fetch();
        $stmtCheckPassenger->close();
    } else {
        // Passenger doesn't exist, insert new data
        $stmtInsertPassenger = $koneksi->prepare("INSERT INTO penumpang (Nama, Email) VALUES (?, ?)");
        $stmtInsertPassenger->bind_param("ss", $namaPenumpang, $emailPenumpang);
        $stmtInsertPassenger->execute();
        $stmtInsertPassenger->close();

        // Get the ID of the newly inserted passenger
        $id_penumpang = $koneksi->insert_id;
    }

    // Transaksi
    $queryHarga = "SELECT Harga FROM jadwal WHERE ID = ?";
    $stmtHarga = $koneksi->prepare($queryHarga);
    $stmtHarga->bind_param("i", $id_jadwal);
    $stmtHarga->execute();
    $stmtHarga->bind_result($hargaJadwal);
    $stmtHarga->fetch();
    $stmtHarga->close();

    $hargaTotal = $hargaJadwal + $hargaKelas;

    // Insert Transaksi
    $queryInsertTransaksi = "INSERT INTO transaksi (Jumlah_Pembayaran, Tanggal, Status_Transaksi, ID_Penumpang) VALUES (?, ?, 'BELUM BAYAR', ?)";
    $stmtInsertTransaksi = $koneksi->prepare($queryInsertTransaksi);
    $stmtInsertTransaksi->bind_param("iss", $hargaTotal, $tgl, $id_penumpang);
    $stmtInsertTransaksi->execute();
    $stmtInsertTransaksi->close();

    // Get ID Transaksi
    $stmtTransaksi = $koneksi->prepare("SELECT ID FROM transaksi WHERE Tanggal = ? AND ID_Penumpang = ?");
    $stmtTransaksi->bind_param("si", $tgl, $id_penumpang);
    $stmtTransaksi->execute();
    $stmtTransaksi->bind_result($id_transaksi);
    $stmtTransaksi->fetch();
    $stmtTransaksi->close();

    // Get ID Kursi
    $stmtKursi = $koneksi->prepare("SELECT ID FROM kursi WHERE Kelas = ? AND ID_Jadwal = ? AND No_Kursi = ?");
    $stmtKursi->bind_param("sss", $kelasDipilih, $id_jadwal, $kursiDipilih);
    $stmtKursi->execute();
    $stmtKursi->bind_result($id_kursi);
    $stmtKursi->fetch();
    $stmtKursi->close();

    // Insert Tiket
    $queryInsertTiket = "INSERT INTO tiket (ID_User, ID_Jadwal, ID_Penumpang, ID_Transaksi, ID_Kursi) VALUES (?, ?, ?, ?, ?)";
    $stmtInsertTiket = $koneksi->prepare($queryInsertTiket);
    $stmtInsertTiket->bind_param("iiiii", $id_user, $id_jadwal, $id_penumpang, $id_transaksi, $id_kursi);
    $stmtInsertTiket->execute();
    $stmtInsertTiket->close();

    // Update status kursi
    $queryUpdate = "UPDATE kursi SET Status = 'Tidak Tersedia' WHERE Kelas = ? AND ID_Jadwal = ? AND No_Kursi = ?";
    $stmtUpdate = $koneksi->prepare($queryUpdate);
    $stmtUpdate->bind_param("sis", $kelasDipilih, $id_jadwal, $kursiDipilih);

    if ($stmtUpdate->execute()) {
        header("Location: jadwal.php");
    } else {
        echo "Terjadi kesalahan saat mengupdate data.";
    }

    $stmtUpdate->close();
}
?>
