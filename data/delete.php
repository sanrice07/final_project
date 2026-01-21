<?php
include "../koneksi.php";
$id = $_GET['id'];

mysqli_query($conn, "DELETE FROM data_user WHERE id=$id");
header("Location: tampil.php");
