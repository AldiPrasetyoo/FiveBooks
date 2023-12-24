<?php
require 'koneksi/koneksi.php';
session_start();
require 'template/header.php';
require 'template/navbarPesanan.php';

if (!isset($_SESSION['id_user'])) {
    header('Location: login.php');
    exit();
}

$id_user = $_SESSION['id_user'];

?>
<div>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Status Transaksi</th>
                <th>Rute</th>
                <th>Harga</th>
                <th>Kelas</th>
                <th>No Kursi</th>
                <th>Total Bayar</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody class="body-payment">
            <?php
            $i = 1;
            $hasil = mysqli_query($koneksi, "SELECT
            tiket.ID AS Tiket_ID,
            penumpang.Nama AS Nama_Pembeli,
            penumpang.Email AS Email_Pembeli,
            transaksi.Status_Transaksi AS Status_Transaksi,
            CONCAT(rute_asal.Nama,'-',rute_tujuan.Nama) AS Rute,
            jadwal.Harga AS Harga,
            kursi.Kelas AS Kelas,
            kursi.No_Kursi AS No_Kursi,
            transaksi.Jumlah_Pembayaran AS Total
            FROM
                tiket
            JOIN penumpang ON tiket.ID_Penumpang = penumpang.ID
            JOIN transaksi ON tiket.ID_Transaksi = transaksi.ID 
            JOIN jadwal ON tiket.ID_Jadwal = jadwal.ID
            JOIN rute ON jadwal.ID_Rute = rute.ID
            JOIN bandara AS rute_asal ON rute.ID_BandaraAsal = rute_asal.ID
            JOIN bandara AS rute_tujuan ON rute.ID_BandaraTujuan = rute_tujuan.ID
            JOIN kursi ON tiket.ID_Kursi = kursi.ID
            
            WHERE
                    ID_User = $id_user
                    
            ORDER BY
                tiket.ID;") or die(mysqli_error($koneksi));

            while ($info = mysqli_fetch_assoc($hasil)) {
                ?>
                <tr>
                    <td>
                        <?= $i ?>
                    </td>
                    <td>
                        <?= $info['Nama_Pembeli'] ?>
                    </td>
                    <td>
                        <?= $info['Email_Pembeli'] ?>
                    </td>
                    <td>
                        <?= $info['Status_Transaksi'] ?>
                    </td>
                    <td>
                        <?= $info['Rute'] ?>
                    </td>
                    <td>
                        <?= $info['Harga'] ?>
                    </td>
                    <td>
                        <?= $info['Kelas'] ?>
                    </td>
                    <td>
                        <?= $info['No_Kursi'] ?>
                    </td>
                    <td>
                        <?= $info['Total'] ?>
                    </td>
                    <td>
                        <?php if ($info['Status_Transaksi'] == 'BELUM BAYAR'): ?>
                            <form method="post" action="pembayaran.php">
                                <input type="hidden" name="tiket_id" value="<?= $info['Tiket_ID'] ?>">
                                <input type="hidden" name="id_user" value="<?= $_SESSION['id_user'] ?>">
                                <button type="submit" name="bayar">Bayar</button>
                            </form>
                        <?php else: ?>
                            <a href="cetak_tiket.php?tiket_id=<?= $info['Tiket_ID'] ?>" target="_blank">Cetak Tiket</a>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php
                $i++;
            } ?>
        </tbody>
    </table>
</div>
</body>

</html>