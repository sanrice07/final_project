<?php
require_once __DIR__ . '/db_mahasiswa.php';
if ($_SERVER['REQUEST_METHOD']==='POST' && isset($_POST['id'])) {
  $id=(int)$_POST['id'];
  $st = mysqli_prepare($con,"DELETE FROM pendaftaran WHERE id_pendaftaran=?");
  mysqli_stmt_bind_param($st,"i",$id); mysqli_stmt_execute($st);
}
header('Location: display_pendaftaran.php'); exit;
