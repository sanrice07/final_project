<?php
session_start();

echo "SESSION AKTIF<br>";

if(!isset($_SESSION["user_id"])){
    echo "BELUM LOGIN";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Home</title>
</head>
<body>

<h2>Selamat Datang!</h2>
<p>Username: <?php echo $_SESSION["username"]; ?></p>

</body>
</html>
