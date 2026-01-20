<?php
include 'db_mahasiswa.php';

if (isset($_POST['submit'])) {
    $npm   = $_POST['npm'];
    $nama  = $_POST['nama'];
    $email = $_POST['email'];

    $sql = "INSERT INTO db_mahasiswabaru (npm, nama, email)
            VALUES ('$npm', '$nama', '$email')";

    $result = mysqli_query($con, $sql);

    if ($result) {
        echo "Data berhasil masuk!";
    } else {
        die(mysqli_error($con));
    }
}
?>


<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="style.css">

    <title>Penerimaan Mahasiswa Baru 2026</title>
  </head>
  <body>
    <div class="container">
        <form method="post">
  <div class="form-group">
    <label>NPM </label>
    <input type="text" class="form-control" placeholder="masukan npm" name="npm">
  </div>
  <div class="form-group">
    <label>Nama Lengkap </label>
    <input type="text" class="form-control" placeholder="masukan nama lengkap" name="nama">
  </div>
  <div class="form-group">
    <label>Email </label>
    <input type="text" class="form-control" placeholder="masukan email" name="email">
  </div>
  <button type="submit" class="btn btn-primary">Submit</button>
</form>
    </div>

  </body>
</html>