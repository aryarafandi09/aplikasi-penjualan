<?php
include '../../config/database.php';

$barang = mysqli_query($conn, "SELECT * FROM barang");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Daftar Barang</title>
</head>
<body>
    <h2>Daftar Barang</h2>
    <a href="tambah.php">+ Tambah Barang</a>
    <br><br>
    <table border="1" cellpadding="8" cellspacing="0">
        <tr>
            <th>No</th>
            <th>Nama Barang</th>
            <th>Stok</th>
            <th>Harga</th>
        </tr>
        <?php
        $no = 1;
        while ($row = mysqli_fetch_assoc($barang)) {
            echo "<tr>
                <td>{$no}</td>
                <td>{$row['nama_barang']}</td>
                <td>{$row['stok']}</td>
                <td>Rp " . number_format($row['harga'], 0, ',', '.') . "</td>
            </tr>";
            $no++;
        }
        ?>
    </table>
</body>
</html>
