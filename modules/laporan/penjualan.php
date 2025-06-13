<?php
include '../user/hakakses.php';
cekRole(['Admin', 'Owner']); // sesuaikan role

include '../../views/header.php';
include '../../views/sidebar.php';
include '../../config/database.php';

// Atur nilai default awal
$bulan = date('m');
$tahun = date('Y');

// Jika user klik tombol filter
if (isset($_POST['filter'])) {
    $bulan = $_POST['bulan'];
    $tahun = $_POST['tahun'];
}

// Query data penjualan
$query = mysqli_query($conn, "
    SELECT p.*, b.nama_barang 
    FROM penjualan p 
    JOIN barang b ON p.barang_id = b.id 
    WHERE MONTH(p.tanggal) = '$bulan' AND YEAR(p.tanggal) = '$tahun'
    ORDER BY p.tanggal ASC
");

// Summary data
$summary = mysqli_fetch_assoc(mysqli_query($conn, "
    SELECT COUNT(*) as total_transaksi, SUM(total_harga) as total_pendapatan 
    FROM penjualan 
    WHERE MONTH(tanggal) = '$bulan' AND YEAR(tanggal) = '$tahun'
"));
?>

<div class="container mt-4">
    <h2 class="mb-4">Laporan Penjualan Bulanan</h2>

    <form method="POST" class="row g-3 mb-4">
        <div class="col-md-2">
            <label class="form-label">Bulan:</label>
            <select name="bulan" class="form-select">
                <?php for ($i = 1; $i <= 12; $i++): ?>
                    <option value="<?= sprintf('%02d', $i) ?>" <?= $bulan == sprintf('%02d', $i) ? 'selected' : '' ?>>
                        <?= sprintf('%02d', $i) ?>
                    </option>
                <?php endfor; ?>
            </select>
        </div>
        <div class="col-md-2">
            <label class="form-label">Tahun:</label>
            <select name="tahun" class="form-select">
                <?php for ($y = 2023; $y <= date('Y'); $y++): ?>
                    <option value="<?= $y ?>" <?= $tahun == $y ? 'selected' : '' ?>><?= $y ?></option>
                <?php endfor; ?>
            </select>
        </div>
        <div class="col-md-3 d-flex align-items-end">
            <button type="submit" name="filter" class="btn btn-primary me-2">Tampilkan</button>
            <a href="../../laporan/cetak.php?bulan=<?= $bulan ?>&tahun=<?= $tahun ?>" class="btn btn-success" target="_blank">🖨️ Cetak</a>
        </div>
    </form>

    <div class="mb-3">
        <p><strong>Total Transaksi:</strong> <?= $summary['total_transaksi'] ?? 0 ?></p>
        <p><strong>Total Pendapatan:</strong> Rp <?= number_format($summary['total_pendapatan'] ?? 0, 0, ',', '.') ?></p>
    </div>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>No</th>
                <th>Barang</th>
                <th>Jumlah</th>
                <th>Total Harga</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            <?php if (mysqli_num_rows($query) > 0): ?>
                <?php $no = 1; while ($row = mysqli_fetch_assoc($query)): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= $row['nama_barang'] ?></td>
                        <td><?= $row['jumlah'] ?></td>
                        <td>Rp <?= number_format($row['total_harga'], 0, ',', '.') ?></td>
                        <td><?= $row['tanggal'] ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="5" class="text-center text-muted">Tidak ada data penjualan</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php include '../../views/footer.php'; ?>
