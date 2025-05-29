<?php
include '../../config/database.php';

$penjualan = mysqli_query($conn, "
    SELECT p.*, b.nama_barang 
    FROM penjualan p 
    JOIN barang b ON p.barang_id = b.id 
    ORDER BY p.tanggal DESC
");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Riwayat Transaksi Penjualan</title>
</head>
<body>
    <h2>Riwayat Transaksi Penjualan</h2>
    <a href="tambah.php">+ Tambah Transaksi</a>
    <br><br>
    <table border="1" cellpadding="8" cellspacing="0">
        <tr>
            <th>No</th>
            <th>Nama Barang</th>
            <th>Jumlah</th>
            <th>Total Harga</th>
            <th>Tanggal</th>
        </tr>
        <?php
        $no = 1;
        while ($row = mysqli_fetch_assoc($penjualan)) {
            echo "<tr>
                <td>{$no}</td>
                <td>{$row['nama_barang']}</td>
                <td>{$row['jumlah']}</td>
                <td>Rp " . number_format($row['total_harga'], 0, ',', '.') . "</td>
                <td>{$row['tanggal']}</td>
            </tr>";
            $no++;
        }
        ?>
    </table>
</body>
</html>
