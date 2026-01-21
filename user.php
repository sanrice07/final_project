<?php
// user.php
require_once __DIR__ . '/db_mahasiswa.php';

if (!isset($con) || !($con instanceof mysqli)) {
  die('Variabel koneksi $con tidak ditemukan atau tidak valid. Periksa db_mahasiswa.php');
}

$message = '';
$npm = $nama = $email = '';
$edit_id = null;

if (isset($_GET['edit']) && is_numeric($_GET['edit'])) {
  $edit_id = (int) $_GET['edit'];
  $stmt = mysqli_prepare($con, "SELECT npm, nama, email FROM mahasiswa WHERE id_mhs = ?");
  if ($stmt) {
    mysqli_stmt_bind_param($stmt, "i", $edit_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $npm_db, $nama_db, $email_db);
    if (mysqli_stmt_fetch($stmt)) {
      $npm = $npm_db;
      $nama = $nama_db;
      $email = $email_db;
    } else {
      $message = "Data dengan ID {$edit_id} tidak ditemukan.";
      $edit_id = null;
    }
    mysqli_stmt_close($stmt);
  } else {
    $message = "Gagal prepare: " . mysqli_error($con);
  }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $npm_post = trim($_POST['npm'] ?? '');
  $nama_post = trim($_POST['nama'] ?? '');
  $email_post = trim($_POST['email'] ?? '');
  $id_post = isset($_POST['id']) ? (int) $_POST['id'] : null;

  if ($npm_post === '' || $nama_post === '' || $email_post === '') {
    $message = 'Tolong isi semua field.';
  } else {
    if ($id_post) {
      // UPDATE
      $stmt = mysqli_prepare($con, "UPDATE mahasiswa SET npm = ?, nama = ?, email = ? WHERE id_mhs = ?");
      if ($stmt) {
        mysqli_stmt_bind_param($stmt, "sssi", $npm_post, $nama_post, $email_post, $id_post);
        if (mysqli_stmt_execute($stmt)) {
          header('Location: display.php');
          exit;
        } else {
          $message = 'Gagal update: ' . mysqli_error($con);
        }
        mysqli_stmt_close($stmt);
      } else {
        $message = 'Prepare update gagal: ' . mysqli_error($con);
      }
    } else {
      $stmt = mysqli_prepare($con, "INSERT INTO mahasiswa (npm, nama, email) VALUES (?, ?, ?)");
      if ($stmt) {
        mysqli_stmt_bind_param($stmt, "sss", $npm_post, $nama_post, $email_post);
        if (mysqli_stmt_execute($stmt)) {
          header('Location: display.php');
          exit;
        } else {
          $message = 'Gagal menyimpan: ' . mysqli_error($con);
        }
        mysqli_stmt_close($stmt);
      } else {
        $message = 'Prepare insert gagal: ' . mysqli_error($con);
      }
    }
  }
}
?>
<!doctype html>
<html lang="id">

<head>
  <meta charset="utf-8">
  <title>Tambah / Edit Mahasiswa</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <style>
    body {
      font-family: Arial;
      padding: 18px
    }

    .container {
      max-width: 700px;
      margin: 0 auto
    }

    .form-group {
      margin-bottom: 8px
    }

    input {
      width: 100%;
      padding: 8px;
      border: 1px solid #ccc;
      border-radius: 6px
    }

    .btn {
      padding: 8px 12px;
      border-radius: 6px;
      background: #2673c9;
      color: #fff;
      border: none;
      cursor: pointer
    }

    .msg {
      margin: 10px 0;
      padding: 8px;
      border-radius: 6px
    }

    .success {
      background: #e6ffed;
      border: 1px solid #b7f0c7;
      color: #0a5a2a
    }

    .error {
      background: #fff0f0;
      border: 1px solid #f0b7b7;
      color: #7a1b1b
    }

    a.link {
      display: inline-block;
      margin-top: 10px
    }
  </style>
</head>

<body>
  <div class="container">
    <h2><?= $edit_id ? "Edit Mahasiswa (ID: {$edit_id})" : "Tambah Mahasiswa Baru" ?></h2>

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
        <input id="nama" name="nama" type="text" value="<?= htmlspecialchars($nama ?? '') ?>"
          placeholder="Masukkan nama">
      </div>

      <div class="form-group">
        <label for="email">Email</label>
        <input id="email" name="email" type="email" value="<?= htmlspecialchars($email ?? '') ?>"
          placeholder="Masukkan email">
      </div>

      <?php if ($edit_id): ?>
        <input type="hidden" name="id" value="<?= (int) $edit_id ?>">
        <button type="submit" class="btn">Update</button>
        <a class="link" href="user.php" style="margin-left:10px">Batal</a>
      <?php else: ?>
        <button type="submit" class="btn">Submit</button>
      <?php endif; ?>
    </form>

    <p><a class="link" href="display.php">Lihat semua data (display.php)</a></p>
  </div>
</body>

</html>