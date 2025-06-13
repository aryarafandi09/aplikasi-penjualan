<?php
include '../user/hakakses.php';
cekRole(['Admin', 'Kasir']);
include '../../views/header.php';
include '../../views/sidebar.php';
include '../../config/database.php';

$barang = mysqli_query($conn, "SELECT * FROM barang");
?>

<div class="container mt-4">
    <h2 class="mb-4">Data Barang</h2>

    <a href="tambah.php" class="btn btn-primary mb-3">+ Tambah Barang</a>

    <table class="table table-striped table-bordered">
        <thead class="table-dark">
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Stok</th>
                <th>Harga</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; while ($b = mysqli_fetch_assoc($barang)): ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= $b['nama_barang'] ?></td>
                <td><?= $b['stok'] ?></td>
                <td>Rp <?= number_format($b['harga'], 0, ',', '.') ?></td>
                <td>
                    <a href="edit.php?id=<?= $b['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                    <a href="hapus.php?id=<?= $b['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus?')">Hapus</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<?php include '../../views/footer.php'; ?>
