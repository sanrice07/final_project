<?php
require_once __DIR__ . '/db_mahasiswa.php';
$sql = "SELECT p.id_pendaftaran, p.id_mhs, p.tgl_daftar, m.nama_lengkap, m.npm FROM pendaftaran p
        LEFT JOIN mahasiswa m ON p.id_mhs = m.id_mhs ORDER BY p.id_pendaftaran DESC";
$res = mysqli_query($con, $sql);
?>
<!doctype html><html><head><meta charset="utf-8"><title>Pendaftaran</title><link rel="stylesheet" href="style.css"></head><body>
<div class="container"><h2>Data Pendaftaran</h2><a class="btn" href="add_pendaftaran.php">Tambah Pendaftaran</a>
<?php
if (!$res) echo "<div class='msg error'>".htmlspecialchars(mysqli_error($con))."</div>";
else {
  if (mysqli_num_rows($res)===0) echo "<div class='msg'>Belum ada data.</div>";
  else {
    echo "<table class='table'><thead><tr><th>ID</th><th>NPM</th><th>Nama</th><th>Tgl Daftar</th><th>Aksi</th></tr></thead><tbody>";
    while($r=mysqli_fetch_assoc($res)){
      $id=$r['id_pendaftaran']; $npm=htmlspecialchars($r['npm']); $nama=htmlspecialchars($r['nama_lengkap']); $tgl=$r['tgl_daftar'];
      echo "<tr><td>{$id}</td><td>{$npm}</td><td>{$nama}</td><td>{$tgl}</td>
             <td class='actions'><a class='btn' href='add_pendaftaran.php?edit={$id}'>Edit</a>
              <form class='inline-form' method='post' action='delete_pendaftaran.php' onsubmit='return confirm(\"Hapus?\");'>
                <input type='hidden' name='id' value='{$id}'><button class='btn secondary' type='submit'>Delete</button>
              </form></td></tr>";
    }
    echo "</tbody></table>";
  }
}
?>
</div></body></html>
