<?php
include '../user/hakakses.php';
include '../../views/header.php';
include '../../views/sidebar.php';
include '../../config/database.php';

$bulan = date('m');
$tahun = date('Y');

if (isset($_POST['filter'])) {
    $bulan = $_POST['bulan'];
    $tahun = $_POST['tahun'];
}

$query = mysqli_query($conn, "
    SELECT p.*, b.nama_barang 
    FROM penjualan p 
    JOIN barang b ON p.barang_id = b.id 
    WHERE MONTH(p.tanggal) = '$bulan' AND YEAR(p.tanggal) = '$tahun'
");

$total = mysqli_fetch_assoc(mysqli_query($conn, "
    SELECT COUNT(*) as total_transaksi, SUM(total_harga) as total_pendapatan 
    FROM penjualan 
    WHERE MONTH(tanggal) = '$bulan' AND YEAR(tanggal) = '$tahun'
"));
?>

<h2>Laporan Penjualan Bulanan</h2>

<form method="POST">
    <label>Bulan:</label>
    <select name="bulan">
        <?php for ($i = 1; $i <= 12; $i++): ?>
            <option value="<?= sprintf('%02d', $i) ?>" <?= $i == $bulan ? 'selected' : '' ?>><?= sprintf('%02d', $i) ?></option>
        <?php endfor; ?>
    </select>

    <label>Tahun:</label>
    <select name="tahun">
        <?php for ($y = 2023; $y <= date('Y'); $y++): ?>
            <option value="<?= $y ?>" <?= $y == $tahun ? 'selected' : '' ?>><?= $y ?></option>
        <?php endfor; ?>
    </select>

    <button type="submit" name="filter">Tampilkan</button>
</form>

<hr>
<p><strong>Total Transaksi:</strong> <?= $total['total_transaksi'] ?? 0 ?></p>
<p><strong>Total Pendapatan:</strong> Rp <?= number_format($total['total_pendapatan'] ?? 0, 0, ',', '.') ?></p>
<a href="../../laporan/cetak.php?bulan=<?= $bulan ?>&tahun=<?= $tahun ?>" target="_blank">🖨️ Cetak</a>

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
    while ($row = mysqli_fetch_assoc($query)) {
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

<?php include '../../views/footer.php'; ?>
