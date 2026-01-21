<?php
include "../koneksi.php";

if (isset($_POST['simpan'])) {
    $nama = $_POST['nama'];
    $email = $_POST['email'];

    mysqli_query($conn, "INSERT INTO data_user VALUES('', '$nama', '$email')");
    header("Location: tampil.php");
}
?>

<h2>Tambah Data</h2>
<form method="post">
  Nama: <input type="text" name="nama" required><br><br>
  Email: <input type="email" name="email" required><br><br>
  <button type="submit" name="simpan">Simpan</button>
</form>
