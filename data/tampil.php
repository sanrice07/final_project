<?php
include "../koneksi.php";
$data = mysqli_query($conn, "SELECT * FROM data_user");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Data User</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>

<div class="container">
    <h2>Data User</h2>

    <table>
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Email</th>
            <th>Aksi</th>
        </tr>

        <?php $no=1; foreach ($data as $d): ?>
        <tr>
            <td><?= $no++ ?></td>
            <td><?= htmlspecialchars($d['nama']) ?></td>
            <td><?= htmlspecialchars($d['email']) ?></td>
            <td>
                <a href="edit.php?id=<?= $d['id'] ?>" class="btn">Edit</a>
                <a href="hapus.php?id=<?= $d['id'] ?>" class="btn btn-danger"
                   onclick="return confirm('Yakin hapus data?')">Hapus</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>

    <br>
    <a href="../index.php" class="btn">⬅ Kembali</a>
</div>

</body>
</html>
