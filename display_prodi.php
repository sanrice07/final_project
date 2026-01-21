<?php
require_once __DIR__ . '/db_mahasiswa.php';
$sql = "SELECT * FROM `prodi` ORDER BY id_prodi DESC";
$res = mysqli_query($con, $sql);
?>
<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title>Prodi</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
        <h2>Daftar Prodi</h2><a class="btn" href="add_prodi.php">Tambah Prodi</a>
        <?php
        if (!$res)
            echo "<div class='msg error'>Error: " . htmlspecialchars(mysqli_error($con)) . "</div>";
        else {
            if (mysqli_num_rows($res) === 0)
                echo "<div class='msg'>Belum ada data.</div>";
            else {
                echo "<table class='table'><thead><tr><th>No</th><th>Nama Prodi</th><th>Fakultas</th><th>Aksi</th></tr></thead><tbody>";
                $no = 1;
                while ($r = mysqli_fetch_assoc($res)) {
                    $id = $r['id_prodi'];
                    $np = htmlspecialchars($r['nama_prodi']);
                    $f = htmlspecialchars($r['fakultas']);
                    echo "<tr><td>{$id}</td><td>{$np}</td><td>{$f}</td>
            <td class='actions'>
              <a class='btn' href='add_prodi.php?edit={$id}'>Edit</a>
              <form class='inline-form' method='post' action='delete_prodi.php' onsubmit='return confirm(\"Hapus data?\");'>
                <input type='hidden' name='id' value='{$id}'>
                <button class='btn secondary' type='submit'>Delete</button>
              </form>
            </td></tr>";
                    $no++;
                }
                echo "</tbody></table>";
            }
        }
        ?>
    </div>
</body>

</html>