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
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            background: #f2f8ff;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 90%;
            max-width: 900px;
            margin: 40px auto;
            background: #ffffff;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
        }

        h2 {
            margin: 0 0 20px;
            color: #1e88e5;
        }

        .btn {
            display: inline-block;
            padding: 8px 14px;
            background: #64b5f6;
            color: #fff;
            text-decoration: none;
            border-radius: 6px;
            font-size: 14px;
            border: none;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .btn:hover {
            background: #42a5f5;
        }

        .btn.secondary {
            background: #ef5350;
        }

        .btn.secondary:hover {
            background: #e53935;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .table th {
            background: #e3f2fd;
            color: #1e88e5;
            text-align: left;
            padding: 10px;
            border-bottom: 2px solid #bbdefb;
        }

        .table td {
            padding: 10px;
            border-bottom: 1px solid #e0e0e0;
        }

        .table tr:hover {
            background: #f5faff;
        }

        .actions {
            display: flex;
            gap: 8px;
        }

        .inline-form {
            display: inline;
        }

        .msg {
            margin-top: 15px;
            padding: 10px;
            background: #e3f2fd;
            border-left: 5px solid #1e88e5;
            border-radius: 5px;
            color: #0d47a1;
        }

        .msg.error {
            background: #ffebee;
            border-left-color: #e53935;
            color: #b71c1c;
        }
    </style>
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