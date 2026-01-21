<?php
include "../koneksi.php";

if (isset($_POST['simpan'])) {
    $nama = $_POST['nama'];
    $email = $_POST['email'];

    mysqli_query($conn, "INSERT INTO data_user VALUES('', '$nama', '$email')");
    header("Location: tampil.php");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Data</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>

<div class="container">
    <h2>Tambah Data</h2>

    <form method="post">
        <label>Nama</label>
        <input type="text" name="nama" required>

        <label>Email</label>
        <input type="email" name="email" required>

        <button type="submit" name="simpan">Simpan</button>
    </form>

    <br>
    <a href="tampil.php" class="btn">⬅ Kembali</a>
</div>

</body>
</html>
