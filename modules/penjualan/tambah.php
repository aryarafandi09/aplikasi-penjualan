<?php
include '../../config/database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $barang_id = $_POST['barang_id'];
    $jumlah = $_POST['jumlah'];

    $query_barang = mysqli_query($conn, "SELECT harga FROM barang WHERE id = '$barang_id'");
    $barang = mysqli_fetch_assoc($query_barang);
    $harga = $barang['harga'];
    $total = $harga * $jumlah;

    $query_insert = "INSERT INTO penjualan (barang_id, jumlah, total_harga, tanggal) VALUES ('$barang_id', '$jumlah', '$total', NOW())";
    $result = mysqli_query($conn, $query_insert);

    if ($result) {
        echo "<script>alert('Transaksi berhasil!'); window.location.href='index.php';</script>";
    } else {
        echo "Gagal: " . mysqli_error($conn);
    }
}

$barang_list = mysqli_query($conn, "SELECT * FROM barang");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Transaksi Penjualan</title>
</head>
<body>
    <h2>Transaksi Penjualan</h2>
    <form method="POST" action="">
        <label>Pilih Barang:</label><br>
        <select name="barang_id" required>
            <option value="">-- Pilih Barang --</option>
            <?php while ($b = mysqli_fetch_assoc($barang_list)): ?>
                <option value="<?= $b['id'] ?>"><?= $b['nama_barang'] ?> (Stok: <?= $b['stok'] ?>)</option>
            <?php endwhile; ?>
        </select><br><br>

        <label>Jumlah:</label><br>
        <input type="number" name="jumlah" required><br><br>

        <button type="submit">Proses</button>
    </form>
</body>
</html>
