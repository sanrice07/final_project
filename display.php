<?php
// display.php
require_once __DIR__ . '/db_mahasiswa.php';

if (!isset($con) || !($con instanceof mysqli)) {
  die('Variabel koneksi $con tidak ditemukan. Periksa db_mahasiswa.php');
}

$sql = "SELECT * FROM `mahasiswa` ORDER BY id_mhs DESC";
$result = mysqli_query($con, $sql);
?>
<!doctype html>
<html lang="id">

<head>
  <meta charset="utf-8">
  <title>Data Mahasiswa</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <style>
    body {
      font-family: Arial;
      padding: 18px
    }

    .container {
      max-width: 900px;
      margin: 0 auto
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 12px
    }

    th,
    td {
      padding: 8px;
      border: 1px solid #ddd;
      text-align: left
    }

    th {
      background: #f4f4f4
    }

    .btn {
      padding: 6px 8px;
      border-radius: 6px;
      text-decoration: none;
      border: none;
      cursor: pointer
    }

    .btn-edit {
      background: #4caf50;
      color: #fff
    }

    .btn-delete {
      background: #e74c3c;
      color: #fff
    }

    form.inline {
      display: inline
    }
  </style>
  <script>
    function confirmDelete() {
      return confirm('Yakin ingin menghapus data ini?');
    }
  </script>
</head>

<body>
  <div class="container">
    <h2>Data Mahasiswa</h2>
    <p><a href="user.php">Tambah data</a></p>

    <?php
    if (!$result) {
      echo '<div style="padding:10px;background:#fff0f0;border:1px solid #f0b7b7">Error ambil data: ' . htmlspecialchars(mysqli_error($con)) . '</div>';
    } else {
      if (mysqli_num_rows($result) === 0) {
        echo '<div style="padding:10px;background:#fff7e6;border:1px solid #f0d8b7">Belum ada data.</div>';
      } else {
        echo '<table>';
        echo '<thead><tr><th>No</th><th>NPM</th><th>Nama</th><th>Email</th><th>Aksi</th></tr></thead><tbody>';
        $no = 1;
        while ($row = mysqli_fetch_assoc($result)) {
          $id_label = htmlspecialchars($row['id_mhs'] ?? $no);
          $npm = htmlspecialchars($row['npm'] ?? '');
          $nama = htmlspecialchars($row['nama'] ?? '');
          $email = htmlspecialchars($row['email'] ?? '');

          $edit_link = "user.php?edit=" . urlencode($row['id_mhs']);

          echo "<tr>
                        <td>{$id_label}</td>
                        <td>{$npm}</td>
                        <td>{$nama}</td>
                        <td>{$email}</td>
                        <td>
                          <a class='btn btn-edit' href='{$edit_link}'>Edit</a>
                          <form class='inline' method='post' action='delete.php' onsubmit='return confirmDelete();'>
                            <input type='hidden' name='id' value='" . htmlspecialchars($row['id_mhs']) . "'>
                            <button type='submit' class='btn btn-delete'>Delete</button>
                          </form>
                        </td>
                      </tr>";
          $no++;
        }
        echo '</tbody></table>';
      }
    }
    ?>
  </div>
</body>

</html>