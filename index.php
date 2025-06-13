<?php
include 'modules/user/hakakses.php';
include 'views/header.php';
include 'views/sidebar.php';
include 'config/database.php';

$username = $_SESSION['username'];
$role     = $_SESSION['role'];

$today = date('Y-m-d');
$t_trans = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM penjualan WHERE DATE(tanggal)='$today'"))['total'];
$t_income = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(total_harga) as total FROM penjualan WHERE DATE(tanggal)='$today'"))['total'] ?? 0;
$t_barang = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM barang"))['total'];

$stok_menipis = mysqli_query($conn, "SELECT * FROM barang WHERE stok <= 5");
?>

<div class="container mt-4">
    <h2>Dashboard</h2>
    <p class="text-muted">Halo, <strong><?= $username ?></strong> (<?= ucfirst($role) ?>)</p>

    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card border-primary mb-3">
                <div class="card-body">
                    <h5 class="card-title">Transaksi Hari Ini</h5>
                    <p class="card-text fs-4"><?= $t_trans ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-success mb-3">
                <div class="card-body">
                    <h5 class="card-title">Pendapatan Hari Ini</h5>
                    <p class="card-text fs-4">Rp <?= number_format($t_income, 0, ',', '.') ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-warning mb-3">
                <div class="card-body">
                    <h5 class="card-title">Jumlah Barang</h5>
                    <p class="card-text fs-4"><?= $t_barang ?></p>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header bg-warning text-dark fw-bold">
            Barang Stok Menipis (≤ 5)
        </div>
        <div class="card-body">
            <?php if (mysqli_num_rows($stok_menipis) > 0): ?>
                <ul class="list-group">
                    <?php while ($b = mysqli_fetch_assoc($stok_menipis)): ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <?= $b['nama_barang'] ?>
                            <span class="badge bg-danger rounded-pill"><?= $b['stok'] ?></span>
                        </li>
                    <?php endwhile; ?>
                </ul>
            <?php else: ?>
                <p class="text-muted">Tidak ada barang dengan stok minim.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include 'views/footer.php'; ?>
