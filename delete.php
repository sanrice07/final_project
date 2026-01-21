<?php
require_once __DIR__ . '/db_mahasiswa.php';

if (!isset($con) || !($con instanceof mysqli)) {
    die('Variabel koneksi $con tidak ditemukan. Periksa db_mahasiswa.php');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id']) && is_numeric($_POST['id'])) {
    $id = (int) $_POST['id'];

    $stmt = mysqli_prepare($con, "DELETE FROM mahasiswa WHERE id_mhs = ?");
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $id);
        if (mysqli_stmt_execute($stmt)) {
            header('Location: display.php');
            exit;
        } else {
            die('Gagal menghapus: ' . mysqli_error($con));
        }
    } else {
        die('Prepare gagal: ' . mysqli_error($con));
    }
} else {
    header('Location: display.php');
    exit;
}
