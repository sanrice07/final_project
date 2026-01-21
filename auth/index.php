<?php
session_start();

if(!isset($_SESSION["user_id"])){
    header("Location: auth/login.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Home</title>
</head>
<body>

    <h2>Selamat Datang! <?php echo $_SESSION["username"]; ?></h2>

    <a href="auth/logout.php">Logout</a>

</body>
</html>
