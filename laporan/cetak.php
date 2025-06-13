<?php
include '../config/database.php';

$bulan = $_GET['bulan'] ?? date('m');
$tahun = $_GET['tahun'] ?? date('Y');

$data = mysqli_query($conn, "
    SELECT p.*, b.nama_barang FROM penjualan p
    JOIN barang b ON p.barang_id = b.id
    WHERE MONTH(p.tanggal) = '$bulan' AND YEAR(p.tanggal) = '$tahun'
");

$summary = mysqli_fetch_assoc(mysqli_query($conn, "
    SELECT COUNT(*) as total_transaksi, SUM(total_harga) as total_pendapatan
    FROM penjualan
    WHERE MONTH(tanggal) = '$bulan' AND YEAR(tanggal) = '$tahun'
"));
?>

<!DOCTYPE html>
<html>
<head>
    <title>Cetak Laporan</title>
    <style>
        body { font-family: Arial; }
        h2, h4 { text-align: center; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        table, th, td { border: 1px solid black; }
        th, td { padding: 6px; text-align: center; }
        @media print {
            .noprint { display: none; }
        }
    </style>
</head>
<body onload="window.print()">

<div class="noprint" style="text-align:right;">
    <a href="javascript:window.print()">🖨️ Cetak Manual</a> |
    <a href="../index.php">⬅️ Kembali</a>
</div>

<h2>LAPORAN PENJUALAN</h2>
<h4>Periode: <?= $bulan ?>/<?= $tahun ?></h4>

<table>
    <tr>
        <th>No</th>
        <th>Barang</th>
        <th>Jumlah</th>
        <th>Total Harga</th>
        <th>Tanggal</th>
    </tr>
    <?php
    $no = 1;
    while ($row = mysqli_fetch_assoc($data)) {
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

<br>
<p><strong>Total Transaksi:</strong> <?= $summary['total_transaksi'] ?? 0 ?></p>
<p><strong>Total Pendapatan:</strong> Rp <?= number_format($summary['total_pendapatan'] ?? 0, 0, ',', '.') ?></p>

</body>
</html>
