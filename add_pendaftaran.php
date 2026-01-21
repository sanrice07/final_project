<?php
require_once __DIR__ . '/db_mahasiswa.php';
$msg=''; $selected_mhs=''; $tgl='';
$edit_id = isset($_GET['edit']) ? (int)$_GET['edit'] : null;

if ($edit_id) {
  $st = mysqli_prepare($con,"SELECT id_mhs,tgl_daftar FROM pendaftaran WHERE id_pendaftaran=?");
  mysqli_stmt_bind_param($st,"i",$edit_id);
  mysqli_stmt_execute($st);
  mysqli_stmt_bind_result($st,$idm,$td);
  if(mysqli_stmt_fetch($st)){ $selected_mhs=$idm; $tgl=$td; }
  mysqli_stmt_close($st);
}

$mahs = mysqli_query($con,"SELECT id_mhs, npm, nama FROM mahasiswa ORDER BY nama");
if ($_SERVER['REQUEST_METHOD']==='POST'){
  $selected_mhs = (int)($_POST['id_mhs'] ?? 0);
  $tgl = $_POST['tgl_daftar'] ?? date('Y-m-d');
  if ($selected_mhs<=0) $msg='Pilih mahasiswa';
  else {
    if (!empty($_POST['id'])) {
      $id=(int)$_POST['id'];
      $st=mysqli_prepare($con,"UPDATE pendaftaran SET id_mhs=?, tgl_daftar=? WHERE id_pendaftaran=?");
      mysqli_stmt_bind_param($st,"isi",$selected_mhs,$tgl,$id);
      mysqli_stmt_execute($st);
      mysqli_stmt_close($st);
      header('Location: display_pendaftaran.php'); exit;
    } else {
      $st=mysqli_prepare($con,"INSERT INTO pendaftaran (id_mhs,tgl_daftar) VALUES (?,?)");
      mysqli_stmt_bind_param($st,"is",$selected_mhs,$tgl);
      mysqli_stmt_execute($st);
      mysqli_stmt_close($st);
      header('Location: display_pendaftaran.php'); exit;
    }
  }
}
?>
<!doctype html><html><head><meta charset="utf-8"><title>Tambah/Edit Pendaftaran</title>
<link rel="stylesheet" href="style.css"></head><body>
<div class="container"><h2><?= $edit_id ? "Edit Pendaftaran":"Tambah Pendaftaran" ?></h2>
<?php if($msg) echo "<div class='msg error'>".htmlspecialchars($msg)."</div>"; ?>
<form method="post">
<label>Mahasiswa</label>
<select name="id_mhs">
  <option value="0">-- Pilih --</option>
  <?php while($m=mysqli_fetch_assoc($mahs)){
    $sel = ($m['id_mhs']==$selected_mhs) ? 'selected':'';
    // Gunakan kolom nama (bukan nama_lengkap)
    echo "<option value='{$m['id_mhs']}' {$sel}>".htmlspecialchars($m['npm'].' - '.$m['nama'])."</option>";
  } ?>
</select>
<label>Tanggal Daftar</label>
<input type="date" name="tgl_daftar" value="<?= htmlspecialchars($tgl ?: date('Y-m-d')) ?>">
<?php if($edit_id): ?><input type="hidden" name="id" value="<?= $edit_id ?>"><?php endif; ?>
<button class="btn" type="submit"><?= $edit_id ? "Update":"Simpan" ?></button>
<a class="btn secondary" href="display_pendaftaran.php">Batal</a>
</form></div></body></html>
