<?php
session_start();
include "../koneksi.php";
$error="";

if($_SERVER["REQUEST_METHOD"]=="POST"){
    $email=$_POST["email"];
    $pass=$_POST["password"];

    $q=mysqli_query($conn,"SELECT * FROM users WHERE email='$email'");
    if(mysqli_num_rows($q)==1){
        $user=mysqli_fetch_assoc($q);
        if(password_verify($pass,$user["password"])){
            $_SESSION["user_id"]=$user["id"];
            $_SESSION["username"]=$user["username"];
            header("Location: ../index.php");
            exit;
        } else $error="Password salah";
    } else $error="Email tidak ditemukan";
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Login</title>
<style>
body{background:#E6F2FF;font-family:Arial;}
.box{width:350px;margin:auto;margin-top:60px;background:white;padding:20px;border-radius:10px;}
input,button{width:100%;padding:10px;margin:8px;}
button{background:#007BFF;color:white;border:none;}
</style>
</head>
<body>
<div class="box">
<h2>Login</h2>
<form method="POST">
<input name="email" type="email" placeholder="Email" required>
<input name="password" type="password" placeholder="Password" required>
<button>Login</button>
</form>
<p style="color:red"><?= $error ?></p>
</div>
</body>
</html>
