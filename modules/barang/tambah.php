<?php
include '../../config/database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_barang = $_POST['nama_barang'];
    $stok = $_POST['stok'];
    $harga = $_POST['harga'];

    $query = "INSERT INTO barang (nama_barang, stok, harga) VALUES ('$nama_barang', '$stok', '$harga')";
    $result = mysqli_query($conn, $query);

    if ($result) {
        echo "<script>alert('Barang berhasil ditambahkan!'); window.location.href='index.php';</script>";
    } else {
        echo "Gagal menambahkan barang: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Barang</title>
</head>
<body>
    <h2>Tambah Barang</h2>
    <form method="POST" action="">
        <label>Nama Barang:</label><br>
        <input type="text" name="nama_barang" required><br><br>

        <label>Stok:</label><br>
        <input type="number" name="stok" required><br><br>

        <label>Harga (Rp):</label><br>
        <input type="number" name="harga" required><br><br>

        <button type="submit">Simpan</button>
    </form>
</body>
</html>