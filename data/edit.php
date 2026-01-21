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

<!DOCTYPE html>
<html>
<head>
    <title>Edit Data</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>

<div class="container">
    <h2>Edit Data</h2>

    <form method="post">
        <label>Nama</label>
        <input type="text" name="nama" value="<?= $d['nama'] ?>">

        <label>Email</label>
        <input type="email" name="email" value="<?= $d['email'] ?>">

        <button type="submit" name="update">Update</button>
    </form>

    <br>
    <a href="tampil.php" class="btn">⬅ Kembali</a>
</div>

</body>
</html>
