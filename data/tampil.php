<?php
include "../koneksi.php";
$data = mysqli_query($conn, "SELECT * FROM data_user");
?>

<h2>Data User</h2>
<table border="1" cellpadding="8">
<tr>
  <th>No</th>
  <th>Nama</th>
  <th>Email</th>
  <th>Aksi</th>
</tr>

<?php $no=1; foreach ($data as $d): ?>
<tr>
  <td><?= $no++ ?></td>
  <td><?= $d['nama'] ?></td>
  <td><?= $d['email'] ?></td>
  <td>
    <a href="edit.php?id=<?= $d['id'] ?>">Edit</a> |
    <a href="hapus.php?id=<?= $d['id'] ?>" onclick="return confirm('Hapus?')">Hapus</a>
  </td>
</tr>
<?php endforeach; ?>
</table>

<br>
<a href="../index.php">Kembali</a>
