<?php
include 'koneksi.php';

if(isset($_GET['id'])){
    $id = $_GET['id'];

    $query = "DELETE FROM users WHERE id='$id'";
    $result = mysqli_query($conn, $query);

    if($result){
        header("Location: ../index.php");
        exit;
    } else {
        echo "Gagal menghapus data!";
    }
}else{
    echo "ID tidak ditemukan!";
}