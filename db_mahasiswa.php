<?php
// db_mahasiswa.php
$host = 'localhost';
$user = 'root';
$pass = '';
$db   = 'db_mahasiswa';

$con = mysqli_connect($host, $user, $pass, $db);

if (!$con) {
    die('Koneksi database gagal: ' . mysqli_connect_error());
}
?>
