<?php
require 'koneksi/koneksi.php';
require 'template/header.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_jadwal = $_POST['id_jadwal'];
    $namaPembeli = $_POST['namaPembeli'];
    $emailPembeli = $_POST['emailPembeli'];

    $sql = "INSERT INTO penumpang (Nama, Email) VALUES ('$namaPembeli','$emailPembeli')";
    $result = mysqli_query($koneksi, $sql);

    date_default_timezone_set('Asia/Jakarta');
    $tgl = date('Y/m/j');
}

//kursi
$query = "SELECT * FROM kursi WHERE ID_Jadwal = $id_jadwal";
$result = $koneksi->query($query);

//kelas
$kelas = array();
while ($row = $result->fetch_assoc()) {
    $class = $row["Kelas"];
    if (!isset($kelas[$class])) {
        $kelas[$class] = array();
    }

    // Tambahkan harga kelas dari database kursi
    $kelas[$class][] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pemilihan Kursi</title>
    <style>
        .seat {
            width: 40px;
            height: 40px;
            margin: 5px;
            display: inline-block;
            text-align: center;
            line-height: 40px;
            border: 1px solid #ccc;
            cursor: pointer;
        }

        .selected {
            background-color: #00cc00;
            color: #fff;
        }

        #selected_info {
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <div class="pesanKursi">
        <div class="boxPSN">

            <form action="orderDone.php" method="post">
                <label for="nomor_kursi">Pilih Nomor Kursi:</label>

                <?php
                foreach ($kelas as $class => $seats) {
                    echo '<div class="class-container">';
                    echo '<div class="class-label">' . ucfirst($class) . '</div>';

                    foreach ($seats as $seat) {
                        $seatNumber = $seat["No_Kursi"];
                        $status = $seat["Status"];
                        $hargaKursi = $seat["Harga"];
                        $seatClass = ($status == 'Tersedia') ? 'seat' : 'seat selected';

                        echo '<div class="' . $seatClass . '" data-seat="' . $seatNumber . '" data-kelas="' . $class . '" data-harga="' . $hargaKursi . '">' . $seatNumber . '</div>';
                    }

                    echo '</div>';
                }
                ?>
                <br>

                <input type="submit" value="Pesan Kursi">
                <div id="selected_info"></div>
                <input type="hidden" name="selected_seat" id="selected_seat">
                <input type="hidden" name="selected_class" id="selected_class">
                <input type="hidden" name="tgl" value="<?php echo ($tgl); ?>">
                <input type="hidden" name="hargaKelas" id="hargaKelas" value="">
                <input type="hidden" name="id_jadwal" value="<?php echo htmlspecialchars($id_jadwal); ?>">
                <input type="hidden" name="namaPembeli" value="<?php echo htmlspecialchars($namaPembeli); ?>">
                <input type="hidden" name="emailPembeli" value="<?php echo htmlspecialchars($emailPembeli); ?>">
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var selectedSeat = null;
            function handleSeatClick(event) {
                var clickedSeat = event.target;
                if (clickedSeat.classList.contains('seat') && !clickedSeat.classList.contains('selected')) {
                    if (selectedSeat !== null) {
                        selectedSeat.classList.remove('selected');
                    }
                    clickedSeat.classList.add('selected');
                    selectedSeat = clickedSeat;
                    var selectedSeatInput = document.getElementById('selected_seat');
                    var selectedClassInput = document.getElementById('selected_class');
                    var hargaKelasInput = document.getElementById('hargaKelas');
                    selectedSeatInput.value = selectedSeat.dataset.seat;
                    selectedClassInput.value = selectedSeat.dataset.kelas;
                    hargaKelasInput.value = selectedSeat.dataset.harga;

                    // Tampilkan informasi kursi yang dipilih di bawah tombol
                    var selectedInfo = document.getElementById('selected_info');
                    var hargaKursi = selectedSeat.dataset.harga;
                    selectedInfo.innerHTML = `Nomor Kursi: ${selectedSeat.dataset.seat} <br> Kelas: ${selectedSeat.dataset.kelas} <br> Tambahan Biaya Kelas: Rp ${hargaKursi}`;

                }
            }
            document.body.addEventListener('click', handleSeatClick);
        });
    </script>

</body>

</html>
