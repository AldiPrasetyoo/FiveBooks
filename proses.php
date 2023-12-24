<?php

require 'koneksi/koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $selectedSeat = $_POST["selected_seat"];
    $selectedClass = $_POST["selected_class"];

    // Mengupdate data di dalam database
    $queryUpdate = "UPDATE kursi SET Status = 'Tidak Tersedia' WHERE Kelas = ? AND ID_Jadwal = ? AND No_Kursi = ?";
    $stmtUpdate = $koneksi->prepare($queryUpdate);

    // Mendapatkan ID_Jadwal dari kursi yang dipilih
    $queryGetJadwal = "SELECT ID_Jadwal FROM kursi WHERE No_Kursi = ?";
    $stmtGetJadwal = $koneksi->prepare($queryGetJadwal);
    $stmtGetJadwal->bind_param("s", $selectedSeat);
    $stmtGetJadwal->execute();
    $stmtGetJadwal->bind_result($jadwal_id);

    if ($stmtGetJadwal->fetch()) {
        $stmtGetJadwal->close();

        // Melakukan update
        $stmtUpdate->bind_param("ssi", $selectedClass, $jadwal_id, $selectedSeat);

        if ($stmtUpdate->execute()) {
            header("Location: pesanan.php");
        } else {
            echo "Terjadi kesalahan saat mengupdate data.";
        }

        $stmtUpdate->close();
    } else {
        echo "Data kursi tidak ditemukan.";
    }
}
?>
