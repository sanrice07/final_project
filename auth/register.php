<?php
include "../koneksi.php";
$msg = "";

if($_SERVER["REQUEST_METHOD"]=="POST"){
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);

    $sql = "INSERT INTO users VALUES(NULL,'$username','$email','$password',NOW())";
    if(mysqli_query($conn,$sql)){
        $msg = "Registrasi berhasil! <a href='login.php'>Login</a>";
    } else {
        $msg = "Gagal register!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Register</title>
<style>
body{background:#E6F2FF;font-family:Arial;}
.box{width:350px;margin:auto;margin-top:60px;background:white;padding:20px;border-radius:10px;}
input,button{width:100%;padding:10px;margin:8px;}
button{background:#007BFF;color:white;border:none;}
</style>
</head>
<body>
<div class="box">
<h2>Register</h2>
<form method="POST">
<input name="username" placeholder="Username" required>
<input name="email" type="email" placeholder="Email" required>
<input name="password" type="password" placeholder="Password" required>
<button>Daftar</button>
</form>
<?= $msg ?>
</div>
</body>
</html>