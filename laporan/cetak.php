<?php
include '../config/database.php';

$bulan = $_GET['bulan'] ?? date('m');
$tahun = $_GET['tahun'] ?? date('Y');

// Ambil data
$query = mysqli_query($conn, "
    SELECT p.*, b.nama_barang 
    FROM penjualan p 
    JOIN barang b ON p.barang_id = b.id 
    WHERE MONTH(p.tanggal) = '$bulan' AND YEAR(p.tanggal) = '$tahun'
    ORDER BY p.tanggal ASC
");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Cetak Laporan Penjualan</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 14px; }
        h2, h4 { text-align: center; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        table, th, td { border: 1px solid #000; }
        th, td { padding: 8px; text-align: center; }
        .text-left { text-align: left; }
        .footer { margin-top: 50px; text-align: right; padding-right: 20px; }
        @media print {
            .no-print { display: none; }
        }
    </style>
</head>
<body onload="window.print()">

    <h2>LAPORAN PENJUALAN</h2>
    <h4>Bulan <?= $bulan ?> Tahun <?= $tahun ?></h4>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th class="text-left">Nama Barang</th>
                <th>Jumlah</th>
                <th>Total Harga</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            $totalSeluruh = 0;
            while ($row = mysqli_fetch_assoc($query)) :
                $totalSeluruh += $row['total_harga'];
            ?>
            <tr>
                <td><?= $no++ ?></td>
                <td class="text-left"><?= $row['nama_barang'] ?></td>
                <td><?= $row['jumlah'] ?></td>
                <td>Rp <?= number_format($row['total_harga'], 0, ',', '.') ?></td>
                <td><?= $row['tanggal'] ?></td>
            </tr>
            <?php endwhile; ?>
            <tr>
                <td colspan="3"><strong>Total Pendapatan</strong></td>
                <td colspan="2"><strong>Rp <?= number_format($totalSeluruh, 0, ',', '.') ?></strong></td>
            </tr>
        </tbody>
    </table>

    <div class="footer">
        <p>Jayapura, <?= date('d-m-Y') ?></p>
        <p><br><br>__________________________</p>
        <p>TTD</p>
    </div>

    <div class="no-print">
        <hr>
        <a href="javascript:window.print()">🖨️ Klik untuk cetak ulang</a> |
        <a href="../modules/lapora
