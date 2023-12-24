<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Five Books</title>
    <link rel="stylesheet" href="./asset/css/jadwal.css">
    <link rel="stylesheet" href="./asset/css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>

</head>

<body>
    <?php
    $koneksi = require 'koneksi/koneksi.php';
    session_start();

    if (!$koneksi) {
        die("Koneksi database gagal: " . mysqli_connect_error());
    }
    require 'template/navbar.php'
        ?>
    <div class="kontainer-judul">
        <h1>Sistem Pemesanan Tiket Pesawat</h1>
    </div>

    <div class="kont-jadwal">
        <div class="kont-judul">
            <h2>Jadwal Penerbangan Pesawat</h2>
        </div>
        <form method="post">
            <div class="row">
                <div class="col-sm-10">
                    <input type="text" name="keyword" class="form-control" size="30" placeholder="Cari Jadwal" autofocus
                        autocomplete="off">
                </div>
                <div class="col-sm-2">
                    <input type="submit" name="cari" class="form-control btn btn-primary">
                </div>
            </div>
        </form>
        <div class="jadwal">
            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kota Asal</th>
                        <th>Kota Tujuan</th>
                        <th>Nama Maskapai</th>
                        <th>Tanggal Berangkat</th>
                        <th>Tanggal Tiba</th>
                        <?php
                        if (isset($_SESSION['role'])) { ?>
                            <th>Pesan</th>
                        <?php } else { ?>

                        <?php } ?>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (isset($_POST['cari'])) {
                        $cari = $_POST['keyword'];
                        $QueryString = "SELECT jadwal.ID AS No,
                        bandara_asal.Kota AS Kota_Asal,
                        bandara_tujuan.Kota AS Kota_Tujuan,
                        CONCAT(maskapai.Nama, ' (', maskapai.Kode_Maskapai, ')') AS Nama_Maskapai,
                        jadwal.Waktu_Berangkat AS Tanggal_Berangkat,
                        jadwal.Waktu_Tiba AS Tanggal_Tiba,
                        jadwal.Harga AS Harga_Tiket
                    FROM
                        jadwal
                    JOIN rute ON jadwal.ID_Rute = rute.ID
                    JOIN bandara AS bandara_asal ON rute.ID_BandaraAsal = bandara_asal.ID
                    JOIN bandara AS bandara_tujuan ON rute.ID_BandaraTujuan = bandara_tujuan.ID
                    JOIN maskapai ON jadwal.ID_Pesawat = maskapai.ID
                    WHERE
                        jadwal.ID LIKE '%$cari%' or
                        bandara_asal.Kota LIKE '%$cari%' or
                        bandara_tujuan.Kota LIKE '%$cari%' or
                        CONCAT(maskapai.Nama, ' (', maskapai.Kode_Maskapai, ')') LIKE '%$cari%' or
                        jadwal.Waktu_Berangkat LIKE '%$cari%' or
                        jadwal.Waktu_Tiba LIKE '%$cari%' or
                        jadwal.Harga LIKE '%$cari%'
                    ORDER BY
                        jadwal.ID";

                        $SQL = mysqli_query($koneksi, $QueryString);
                    } else {
                        $SQL = mysqli_query($koneksi, "SELECT
                            jadwal.ID AS No,
                            bandara_asal.Kota AS Kota_Asal,
                            bandara_tujuan.Kota AS Kota_Tujuan,
                            CONCAT(maskapai.Nama, ' (', maskapai.Kode_Maskapai, ')') AS Nama_Maskapai,
                            jadwal.Waktu_Berangkat AS Tanggal_Berangkat,
                            jadwal.Waktu_Tiba AS Tanggal_Tiba,
                            jadwal.Harga AS Harga_Tiket
                        FROM
                            jadwal
                        JOIN rute ON jadwal.ID_Rute = rute.ID
                        JOIN bandara AS bandara_asal ON rute.ID_BandaraAsal = bandara_asal.ID
                        JOIN bandara AS bandara_tujuan ON rute.ID_BandaraTujuan = bandara_tujuan.ID
                        JOIN maskapai ON jadwal.ID_Pesawat = maskapai.ID
                        ORDER BY
                            jadwal.ID");
                    }

                    $i = 1;
                    while ($info = mysqli_fetch_assoc($SQL)) {
                        ?>
                        <tr>
                            <td>
                                <?= $i ?>
                            </td>
                            <td>
                                <?= $info['Kota_Asal'] ?>
                            </td>
                            <td>
                                <?= $info['Kota_Tujuan'] ?>
                            </td>
                            <td>
                                <?= $info['Nama_Maskapai'] ?>
                            </td>
                            <td>
                                <?= $info['Tanggal_Berangkat'] ?>
                            </td>
                            <td>
                                <?= $info['Tanggal_Tiba'] ?>
                            </td>
                            <?php if (isset($_SESSION['role'])) { ?>
                                <td><a href='#' data-toggle='modal' data-target='#pesanModal<?= $i ?>'>Pesan</a></td>
                            <?php } else { ?>

                            <?php } ?>
                        </tr>


                        <div class="modal fade" id="pesanModal<?= $i ?>" tabindex="-1" role="dialog"
                            aria-labelledby="pesanModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="pesanModalLabel">Form Pemesanan</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="kontainer-judul">
                                            <h1>Order Tiket Pesawat</h1>
                                        </div>
                                        <div class="kont-order">
                                            <form action="pilkur.php" method="post">
                                        </div>
                                        <input type="hidden" name="id_jadwal" id="id_jadwal" value="<?= $info['No'] ?>">
                                        <div>
                                            <label for="name">Nama:</label>
                                            <input type="text" name="namaPembeli" id="namaPembeli" required>
                                        </div>
                                        <div>
                                            <label for="email">Email:</label>
                                            <input type="text" name="emailPembeli" id="emailPembeli" required>
                                        </div>
                                            <input type="hidden" name="id_jadwal" id="id_jadwal" value="<?= $info['No'] ?>">
                                        <input type="submit" value="Next" name="order" class="tombol">
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
            </div>
            <?php
            $i++;
                    }
                    ?>
        </tbody>
        </table>
    </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

</body>

</html>