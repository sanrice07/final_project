<?php
require_once __DIR__ . '/db_mahasiswa.php';
$msg = '';
$selected_mhs = '';
$tgl = '';
$jml = '';
$edit_id = isset($_GET['edit']) ? (int) $_GET['edit'] : null;

if ($edit_id) {
    $st = mysqli_prepare($con, "SELECT id_mhs,jml_bayar,tgl_bayar FROM pembayaran WHERE id_pembayaran=?");
    mysqli_stmt_bind_param($st, "i", $edit_id);
    mysqli_stmt_execute($st);
    mysqli_stmt_bind_result($st, $idm, $jb, $tb);
    if (mysqli_stmt_fetch($st)) {
        $selected_mhs = $idm;
        $jml = $jb;
        $tgl = $tb;
    }
    mysqli_stmt_close($st);
}

$mahs = mysqli_query($con, "SELECT id_mhs, npm, nama FROM mahasiswa ORDER BY nama");
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $selected_mhs = (int) ($_POST['id_mhs'] ?? 0);
    $tgl = $_POST['tgl_bayar'] ?? date('Y-m-d');
    $jml = $_POST['jml_bayar'] ?? '';
    if ($selected_mhs <= 0 || $jml === '')
        $msg = 'Lengkapi field';
    else {
        if (!empty($_POST['id'])) {
            $id = (int) $_POST['id'];
            $st = mysqli_prepare($con, "UPDATE pembayaran SET id_mhs=?, jml_bayar=?, tgl_bayar=? WHERE id_pembayaran=?");
            mysqli_stmt_bind_param($st, "idsi", $selected_mhs, $jml, $tgl, $id);
            mysqli_stmt_execute($st);
            mysqli_stmt_close($st);
            header('Location: display_pembayaran.php');
            exit;
        } else {
            $st = mysqli_prepare($con, "INSERT INTO pembayaran (id_mhs,jml_bayar,tgl_bayar) VALUES (?,?,?)");
            mysqli_stmt_bind_param($st, "ids", $selected_mhs, $jml, $tgl);
            mysqli_stmt_execute($st);
            mysqli_stmt_close($st);
            header('Location: display_pembayaran.php');
            exit;
        }
    }
}
?>
<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title>Tambah/Edit Pembayaran</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
        <h2><?= $edit_id ? "Edit Pembayaran" : "Tambah Pembayaran" ?></h2>
        <?php if ($msg)
            echo "<div class='msg error'>" . htmlspecialchars($msg) . "</div>"; ?>
        <form method="post">
            <label>Mahasiswa</label>
            <select name="id_mhs">
                <option value="0">-- Pilih --</option>
                <?php while ($m = mysqli_fetch_assoc($mahs)) {
                    $sel = ($m['id_mhs'] == $selected_mhs) ? 'selected' : '';
                    echo "<option value='{$m['id_mhs']}' {$sel}>" . htmlspecialchars($m['npm'] . ' - ' . $m['nama']) . "</option>";
                } ?>
            </select>
            <label>Jumlah Bayar</label><input type="number" step="0.01" name="jml_bayar"
                value="<?= htmlspecialchars($jml) ?>">
            <label>Tanggal Bayar</label><input type="date" name="tgl_bayar"
                value="<?= htmlspecialchars($tgl ?: date('Y-m-d')) ?>">
            <?php if ($edit_id): ?><input type="hidden" name="id" value="<?= $edit_id ?>"><?php endif; ?>
            <button class="btn" type="submit"><?= $edit_id ? "Update" : "Simpan" ?></button>
            <a class="btn secondary" href="display_pembayaran.php">Batal</a>
        </form>
    </div>
</body>

</html>