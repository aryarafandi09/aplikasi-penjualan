<?php
session_start();
include 'config/database.php';
include 'views/header.php';
include 'views/sidebar.php';

// Ambil data summary
$totalBarang = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM barang"))['total'];
$totalTransaksi = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM penjualan"))['total'];
$totalPendapatan = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(total_harga) AS total FROM penjualan"))['total'] ?? 0;
$stokMinimal = mysqli_query($conn, "SELECT * FROM barang WHERE stok <= 5");
?>

<div class="container mt-4">

    <!-- 👤 Info User -->
    <div class="alert alert-info d-flex justify-content-between align-items-center">
        <div>
            👋 Selamat datang, <strong><?= $_SESSION['nama'] ?? $_SESSION['username'] ?></strong>
            <small class="text-muted">(Role: <?= $_SESSION['role'] ?>)</small>
        </div>
        <a href="logout.php" class="btn btn-sm btn-outline-danger">Logout</a>
    </div>

    <h2 class="mb-4">Dashboard</h2>

    <!-- 📊 Ringkasan -->
    <div class="row g-3">
        <div class="col-md-4">
            <div class="card border-start border-primary border-4 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Total Barang</h5>
                    <h3 class="text-primary"><?= $totalBarang ?></h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-start border-success border-4 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Total Transaksi</h5>
                    <h3 class="text-success"><?= $totalTransaksi ?></h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-start border-warning border-4 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Total Pendapatan</h5>
                    <h3 class="text-warning">Rp <?= number_format($totalPendapatan, 0, ',', '.') ?></h3>
                </div>
            </div>
        </div>
    </div>

    <!-- ⚠️ Barang Stok Minim -->
    <?php if (mysqli_num_rows($stokMinimal) > 0): ?>
        <div class="alert alert-danger mt-4">
            <strong>⚠️ Barang dengan stok rendah (≤ 5):</strong>
            <ul class="mb-0">
                <?php while ($b = mysqli_fetch_assoc($stokMinimal)): ?>
                    <li><?= $b['nama_barang'] ?> — Stok: <strong><?= $b['stok'] ?></strong></li>
                <?php endwhile; ?>
            </ul>
        </div>
    <?php endif; ?>

</div>

<?php include 'views/footer.php'; ?>
