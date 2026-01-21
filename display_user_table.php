<?php
require_once __DIR__ . '/db_mahasiswa.php';
$res = mysqli_query($con, "SELECT id_user, username FROM `user` ORDER BY id_user DESC");
?>
<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title>User</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
        <h2>User</h2><a class="btn" href="manage_user_table.php">Tambah User</a>
        <?php
        if (!$res)
            echo "<div class='msg error'>" . htmlspecialchars(mysqli_error($con)) . "</div>";
        else {
            if (mysqli_num_rows($res) === 0)
                echo "<div class='msg'>Belum ada user.</div>";
            else {
                echo "<table class='table'><thead><tr><th>ID</th><th>Username</th><th>Aksi</th></tr></thead><tbody>";
                while ($r = mysqli_fetch_assoc($res)) {
                    $id = $r['id_user'];
                    $u = htmlspecialchars($r['username']);
                    echo "<tr><td>{$id}</td><td>{$u}</td>
            <td class='actions'><a class='btn' href='manage_user_table.php?edit={$id}'>Edit</a>
              <form class='inline-form' method='post' action='delete_user_table.php' onsubmit='return confirm(\"Hapus user?\");'>
                <input type='hidden' name='id' value='{$id}'><button class='btn secondary' type='submit'>Delete</button>
              </form></td></tr>";
                }
                echo "</tbody></table>";
            }
        }
        ?>
    </div>
</body>

</html>