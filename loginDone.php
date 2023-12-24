<?php 
include 'koneksi/koneksi.php';

if (isset($_POST['login'])) {
	
$email = $_POST['email'];
$password = md5($_POST['password']);

$result = mysqli_query($koneksi,"select * from user where email='$Email' and password='$Password'");

$cek = mysqli_num_rows($result);
	if($cek > 0){
		$row = mysqli_fetch_array($result,MYSQLI_NUM);
		$id = $row[0];

		
		session_start();
		$_SESSION['user_id'] = $id;
		$_SESSION['email'] = $Email;
		$_SESSION['status'] = 1;
		
		header('Location: index.php');
	}else{
		header('Location: login.php');
	}
}?>
