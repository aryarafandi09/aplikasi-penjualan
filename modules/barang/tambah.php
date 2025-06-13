<?php
include '../../config/database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST['nama_barang'];
    $stok = $_POST['stok'];
    $harga = $_POST['harga'];

    mysqli_query($conn, "INSERT INTO barang (nama_barang, stok, harga) VALUES ('$nama', '$stok', '$harga')");
    echo "<script>window.location.href='index.php';</script>";
}

include '../../views/header.php';
include '../../views/sidebar.php';
?>

<div class="container mt-4">
    <h2>Tambah Barang</h2>

    <form method="POST" class="mt-3">
        <div class="mb-3">
            <label for="nama" class="form-label">Nama Barang</label>
            <input type="text" name="nama_barang" id="nama" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="stok" class="form-label">Stok</label>
            <input type="number" name="stok" id="stok" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="harga" class="form-label">Harga</label>
            <input type="number" name="harga" id="harga" cl
