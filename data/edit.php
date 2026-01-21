<?php
include "../koneksi.php";
$id = $_GET['id'];
$data = mysqli_query($conn, "SELECT * FROM data_user WHERE id=$id");
$d = mysqli_fetch_assoc($data);

if (isset($_POST['update'])) {
    $nama = $_POST['nama'];
    $email = $_POST['email'];

    mysqli_query($conn, "UPDATE data_user SET nama='$nama', email='$email' WHERE id=$id");
    header("Location: tampil.php");
}
?>

<h2>Edit Data</h2>
<form method="post">
  Nama: <input type="text" name="nama" value="<?= $d['nama'] ?>"><br><br>
  Email: <input type="email" name="email" value="<?= $d['email'] ?>"><br><br>
  <button type="submit" name="update">Update</button>
</form>
