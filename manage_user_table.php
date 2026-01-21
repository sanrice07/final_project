<?php
require_once __DIR__ . '/db_mahasiswa.php';
$msg=''; $username=''; $edit_id = isset($_GET['edit'])? (int)$_GET['edit'] : null;
if ($edit_id) {
  $st = mysqli_prepare($con,"SELECT username FROM `user` WHERE id_user=?");
  mysqli_stmt_bind_param($st,"i",$edit_id); mysqli_stmt_execute($st); mysqli_stmt_bind_result($st,$u); if(mysqli_stmt_fetch($st)) $username=$u; mysqli_stmt_close($st);
}
if ($_SERVER['REQUEST_METHOD']==='POST') {
  $username = trim($_POST['username'] ?? '');
  $password = trim($_POST['password'] ?? '');
  if ($username==='') $msg='Isi username';
  else {
    if (!empty($_POST['id'])) {
      $id=(int)$_POST['id'];
      if ($password==='') {
        $st=mysqli_prepare($con,"UPDATE `user` SET username=? WHERE id_user=?");
        mysqli_stmt_bind_param($st,"si",$username,$id); mysqli_stmt_execute($st); mysqli_stmt_close($st);
      } else {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $st=mysqli_prepare($con,"UPDATE `user` SET username=?, password=? WHERE id_user=?");
        mysqli_stmt_bind_param($st,"ssi",$username,$hash,$id); mysqli_stmt_execute($st); mysqli_stmt_close($st);
      }
      header('Location: display_user_table.php'); exit;
    } else {
      // insert
      if ($password==='') $msg='Isi password';
      else {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $st=mysqli_prepare($con,"INSERT INTO `user` (username,password) VALUES (?,?)");
        mysqli_stmt_bind_param($st,"ss",$username,$hash); mysqli_stmt_execute($st); mysqli_stmt_close($st);
        header('Location: display_user_table.php'); exit;
      }
    }
  }
}
?>
<!doctype html><html><head><meta charset="utf-8"><title>Tambah/Edit User</title><link rel="stylesheet" href="style.css"></head><body>
<div class="container"><h2><?= $edit_id ? "Edit User":"Tambah User" ?></h2>
<?php if($msg) echo "<div class='msg error'>".htmlspecialchars($msg)."</div>"; ?>
<form method="post">
<label>Username</label><input type="text" name="username" value="<?= htmlspecialchars($username) ?>">
<label>Password <?= $edit_id ? "(biarkan kosong kalau tidak ingin mengganti)" : "" ?></label><input type="password" name="password">
<?php if($edit_id): ?><input type="hidden" name="id" value="<?= $edit_id ?>"><?php endif; ?>
<button class="btn" type="submit"><?= $edit_id ? "Update":"Simpan" ?></button>
<a class="btn secondary" href="display_user_table.php">Batal</a>
</form></div></body></html>
