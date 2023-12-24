<?php
session_start();
include "koneksi/koneksi.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    $sql = "SELECT * FROM user WHERE Email ='$email' AND Password = '$password'";

    $data = $koneksi->query($sql) or die($koneksi->error);

    if ($data->num_rows != 0) {
        $row = $data->fetch_assoc();

        session_start();
        $_SESSION["id_user"] = $row["ID"];
        $_SESSION["nama"] = $row["Nama"];
        $_SESSION["email"] = $row["email"];
        $_SESSION["password"] = $row["password"];
        $_SESSION["role"] = 1;
        header("Location: jadwal.php");
    } else {
        echo "<script>alert('Gagal');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Five Books</title>
    <link rel="stylesheet" href="./asset/css/login.css">
</head>

<body>
    <div class="bg-container">
        <div class="container">
            <h2>Login</h2>
            <form method="POST">
                <div class="form-group">
                    <label>Email:</label>
                    <input type="text" class="form-control col-sm-4 offset-md-4" name="email" id="email"
                        required="required" />
                </div>
                <div class="form-group">
                    <label>Password:</label>
                    <input type="password" class="form-control col-sm-4 offset-md-4" name="password" id="password"
                        required="required" />
                </div>
                <div class="form-group">
                    <button type="submit">Login</button>
                </div>
            </form>
            <div class="form-group">
                    <label>Belum Punya Akun ? <a href = "regis.php">Daftar Disini</a></label>
                </div>
        </div>
    </div>
</body>

</html>