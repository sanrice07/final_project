<?php
// user.php
// Pastikan db_mahasiswa.php ada di folder yang sama
require_once __DIR__ . '/db_mahasiswa.php';

// Cek koneksi
if (!isset($con) || !($con instanceof mysqli)) {
    die('Variabel koneksi $con tidak ditemukan atau tidak valid. Pastikan file db_mahasiswa.php benar.');
}

$message = '';

// Proses simpan saat form disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $npm   = trim($_POST['npm'] ?? '');
    $nama  = trim($_POST['nama'] ?? '');
    $email = trim($_POST['email'] ?? '');

    if ($npm === '' || $nama === '' || $email === '') {
        $message = 'Tolong isi semua field.';
    } else {
        // prepared statement (aman)
        $stmt = mysqli_prepare($con, "INSERT INTO `mahasiswa` (npm, nama, email) VALUES (?, ?, ?)");
        if ($stmt === false) {
            $message = 'Prepare gagal: ' . mysqli_error($con);
        } else {
            mysqli_stmt_bind_param($stmt, "sss", $npm, $nama, $email);
            if (mysqli_stmt_execute($stmt)) {
                $message = 'Data berhasil masuk!';
                // kosongkan nilai agar form bersih
                $npm = $nama = $email = '';
            } else {
                $message = 'Gagal menyimpan: ' . mysqli_error($con);
            }
            mysqli_stmt_close($stmt);
        }
    }
}
?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <title>Tambah Mahasiswa</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <style>
    /* style minimal agar mudah dilihat */
    body{font-family:Arial;padding:18px}
    .container{max-width:700px;margin:0 auto}
    .form-group{margin-bottom:8px}
    input{width:100%;padding:8px;border:1px solid #ccc;border-radius:6px}
    .btn{padding:8px 12px;border-radius:6px;background:#2673c9;color:#fff;border:none;cursor:pointer}
    .msg{margin:10px 0;padding:8px;border-radius:6px}
    .success{background:#e6ffed;border:1px solid #b7f0c7;color:#0a5a2a}
    .error{background:#fff0f0;border:1px solid #f0b7b7;color:#7a1b1b}
  </style>
</head>
<body>
  <div class="container">
    <h2>Tambah Mahasiswa Baru</h2>

    <?php if ($message): ?>
      <div class="msg <?= (stripos($message, 'berhasil') !== false) ? 'success' : 'error' ?>">
        <?= htmlspecialchars($message) ?>
      </div>
    <?php endif; ?>

    <form method="post" novalidate>
      <div class="form-group">
        <label for="npm">NPM</label>
        <input id="npm" name="npm" type="text" value="<?= htmlspecialchars($npm ?? '') ?>" placeholder="Masukkan NPM">
      </div>

      <div class="form-group">
        <label for="nama">Nama Lengkap</label>
        <input id="nama" name="nama" type="text" value="<?= htmlspecialchars($nama ?? '') ?>" placeholder="Masukkan nama">
      </div>

      <div class="form-group">
        <label for="email">Email</label>
        <input id="email" name="email" type="email" value="<?= htmlspecialchars($email ?? '') ?>" placeholder="Masukkan email">
      </div>

      <button type="submit" class="btn">Submit</button>
    </form>

    <p><a href="display.php">Lihat data (display.php)</a></p>
  </div>
</body>
</html>
