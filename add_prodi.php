<?php
require_once __DIR__ . '/db_mahasiswa.php';
$msg=''; $nama=''; $fak='';
$edit_id = isset($_GET['edit'])? (int)$_GET['edit'] : null;
if ($edit_id) {
  $st = mysqli_prepare($con,"SELECT nama_prodi,fakultas FROM prodi WHERE id_prodi=?");
  mysqli_stmt_bind_param($st,"i",$edit_id); mysqli_stmt_execute($st); mysqli_stmt_bind_result($st,$n,$fa); if(mysqli_stmt_fetch($st)){ $nama=$n;$fak=$fa;} mysqli_stmt_close($st);
}
if ($_SERVER['REQUEST_METHOD']==='POST'){
  $nama = trim($_POST['nama_prodi'] ?? '');
  $fak  = trim($_POST['fakultas'] ?? '');
  if ($nama===''||$fak==='') $msg='Tolong isi semua field';
  else {
    if (!empty($_POST['id'])){ // update
      $id=(int)$_POST['id'];
      $st=mysqli_prepare($con,"UPDATE prodi SET nama_prodi=?, fakultas=? WHERE id_prodi=?");
      mysqli_stmt_bind_param($st,"ssi",$nama,$fak,$id); mysqli_stmt_execute($st); mysqli_stmt_close($st);
      header('Location: display_prodi.php'); exit;
    } else {
      $st=mysqli_prepare($con,"INSERT INTO prodi (nama_prodi,fakultas) VALUES (?,?)");
      mysqli_stmt_bind_param($st,"ss",$nama,$fak); mysqli_stmt_execute($st); mysqli_stmt_close($st);
      header('Location: display_prodi.php'); exit;
    }
  }
}
?>
<!doctype html><html><head><meta charset="utf-8"><title>Tambah/Edit Prodi</title><link rel="stylesheet" href="style.css"></head><body>
<div class="container"><h2><?= $edit_id ? "Edit Prodi" : "Tambah Prodi" ?></h2>
<?php if($msg) echo "<div class='msg error'>".htmlspecialchars($msg)."</div>"; ?>
<form method="post">
<label>Nama Prodi</label><input type="text" name="nama_prodi" value="<?= htmlspecialchars($nama) ?>">
<label>Fakultas</label><input type="text" name="fakultas" value="<?= htmlspecialchars($fak) ?>">
<?php if($edit_id): ?><input type="hidden" name="id" value="<?= $edit_id ?>"><?php endif; ?>
<button class="btn" type="submit"><?= $edit_id ? "Update":"Simpan" ?></button>
<a class="btn secondary" href="display_prodi.php">Batal</a>
</form></div></body></html>
