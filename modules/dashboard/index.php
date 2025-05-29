<?php
session_start();

// Cek login
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

include 'config/database.php';

$username = $_SESSION['username'];
$role = $_SESSION['role'];

$today = date('Y-m-d');

// Total transaksi hari ini
$q1 = mysqli_query($conn, "SELECT COUNT(*) as total FROM penjualan WHERE DATE(tanggal) = '$today'");
$total_transaksi = mysqli_fetch_assoc($q1)['total'] ?? 0;

// Total pendapatan hari ini
$q2 = mysqli_query($conn, "SELECT SUM(total_harga) as pendapatan FROM penjualan WHERE DATE(tanggal) = '$today'");
$pendapatan = mysqli_fetch_assoc($q2)['pendapatan'] ?? 0;

// Total barang
$q3 = mysqli_query($conn, "SELECT COUNT(*) as total_barang FROM barang");
$total_barang = mysqli_fetch_assoc($q3)['total_barang'] ?? 0;

// Barang stok menipis
$q4 = mysqli_query($conn, "SELECT * FROM barang WHERE stok <= 5");
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Dashboard - SIM Penjualan</title>
    <style>
        body {
            font-family: Arial;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
        }
        header {
            background: #007bff;
            color: white;
            padding: 15px;
            text-align: center;
        }
        .container {
            padding: 20px;
        }
        .card {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
            padding: 20px;
            margin-bottom: 15px;
        }
        .logout {
            float: right;
            margin-top: -40px;
        }
        .logout a {
            background-color: red;
            color: white;
            padding: 6px 12px;
            border-radius: 4px;
            text-decoration: none;
        }
    </style>
</head>
<body>

<header>
    <h2>Dashboard - SIM Penjualan</h2>
    <div class="logout">
        <a href="logout.php">Logout</a>
    </div>
</header>

<div class="container">
    <div class="card">
        <h3>Selamat datang, <?= htmlspecialchars($username) ?> (<?= htmlspecialchars($role) ?>)</h3>
    </div>

    <div class="card">
        <p><strong>Total Transaksi Hari Ini:</strong> <?= $total_transaksi ?></p>
        <p><strong>Total Pendapatan Hari Ini:</strong> Rp <?= number_format($pendapatan, 0, ',', '.') ?></p>
        <p><strong>Total Jenis Barang:</strong> <?= $total_barang ?></p>
    </div>

    <div class="card">
        <h4>Barang dengan Stok Menipis (≤ 5)</h4>
        <?php if (mysqli_num_rows($q4) > 0): ?>
            <ul>
                <?php while ($b = mysqli_fetch_assoc($q4)): ?>
                    <li><?= $b['nama_barang'] ?> - Stok: <?= $b['stok'] ?></li>
                <?php endwhile; ?>
            </ul>
        <?php else: ?>
            <p>Tidak ada barang dengan stok menipis.</p>
        <?php endif; ?>
    </div>
</div>

</body>
</html>
