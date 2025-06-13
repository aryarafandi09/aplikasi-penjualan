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

<h2>Dashboard</h2>
<p>Selamat datang, <?= $username ?> (<?= $role ?>)</p>

<div class="card">
    <p><strong>Total Transaksi Hari Ini:</strong> <?= $t_trans ?></p>
    <p><strong>Total Pendapatan:</strong> Rp <?= number_format($t_income, 0, ',', '.') ?></p>
    <p><strong>Total Barang:</strong> <?= $t_barang ?></p>
</div>

<div class="card">
    <h4>Barang Stok Menipis (≤ 5)</h4>
    <?php if (mysqli_num_rows($stok_menipis) > 0): ?>
        <ul>
            <?php while ($b = mysqli_fetch_assoc($stok_menipis)): ?>
                <li><?= $b['nama_barang'] ?> (<?= $b['stok'] ?>)</li>
            <?php endwhile; ?>
        </ul>
    <?php else: ?>
        <p>Tidak ada barang dengan stok minim.</p>
    <?php endif; ?>
</div>

<?php include 'views/footer.php'; ?>
