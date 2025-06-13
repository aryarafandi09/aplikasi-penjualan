<?php
include '../user/hakakses.php';
cekRole(['Admin', 'Kasir']);
include '../../views/header.php';
include '../../views/sidebar.php';
include '../../config/database.php';

$data = mysqli_query($conn, "
    SELECT p.*, b.nama_barang FROM penjualan p
    JOIN barang b ON p.barang_id = b.id
    ORDER BY p.tanggal DESC
");
?>

<h2>Transaksi Penjualan</h2>
<a href="tambah.php">+ Tambah Transaksi</a><br><br>

<table border="1" cellpadding="8">
    <tr>
        <th>No</th>
        <th>Barang</th>
        <th>Jumlah</th>
        <th>Total Harga</th>
        <th>Tanggal</th>
        <th>Aksi</th>
    </tr>
    <?php $no = 1; while ($p = mysqli_fetch_assoc($data)): ?>
    <tr>
        <td><?= $no++ ?></td>
        <td><?= $p['nama_barang'] ?></td>
        <td><?= $p['jumlah'] ?></td>
        <td>Rp <?= number_format($p['total_harga'], 0, ',', '.') ?></td>
        <td><?= $p['tanggal'] ?></td>
        <td><a href="hapus.php?id=<?= $p['id'] ?>" onclick="return confirm('Yakin?')">Hapus</a></td>
    </tr>
    <?php endwhile; ?>
</table>

<?php include '../../views/footer.php'; ?>
