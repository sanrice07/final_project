<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: auth/login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f9ff;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 80px auto;
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        h2 {
            color: #007bff;
            text-align: center;
        }

        ul {
            list-style: none;
            padding: 0;
        }

        ul li {
            margin: 15px 0;
        }

        ul li a {
            display: block;
            padding: 12px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            text-align: center;
            border-radius: 5px;
        }

        ul li a:hover {
            background-color: #0056b3;
        }

        .logout {
            background-color: #dc3545;
        }

        .logout:hover {
            background-color: #a71d2a;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Selamat Datang, <?php echo htmlspecialchars($_SESSION["username"]); ?> 👋</h2>

    <ul>
        <li><a href="data/tampil.php">📋 Menampilkan Data</a></li>
        <li><a href="data/tambah.php">➕ Menambah Data</a></li>
        <li><a href="auth/logout.php" class="logout">🚪 Logout</a></li>
    </ul>
</div>

</body>
</html>
