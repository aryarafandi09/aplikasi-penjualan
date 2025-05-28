<?php
session_start();

// Cek apakah user sudah login
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Include koneksi database
include 'config/database.php';

// Ambil informasi user dari session
$username = $_SESSION['username'];
$role = $_SESSION['role']; // misalnya: admin, owner, kasir
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - SIM Penjualan</title>
    <link rel="stylesheet" href="assets/css/style.css"> <!-- ganti sesuai path CSS -->
</head>
<body>

<?php include 'views/header.php'; ?>
<?php include 'views/sidebar.php'; ?>

<main class="main-content">
    <h1>Selamat Datang, <?= htmlspecialchars($username); ?>!</h1>
    <p>Anda login sebagai: <strong><?= htmlspecialchars($role); ?></strong></p>

    <section class="dashboard-info">
        <div class="card">
            <h3>Total Transaksi Hari Ini</h3>
            <?php
            $today = date('Y-m-d');
            $query = "SELECT COUNT(*) as total FROM penjualan WHERE DATE(tanggal) = '$today'";
            $result = mysqli_query($conn, $query);
            $data = mysqli_fetch_assoc($result);
            echo "<p>" . $data['total'] . " transaksi</p>";
            ?>
        </div>

        <div class="card">
            <h3>Total Pendapatan Hari Ini</h3>
            <?php
            $query = "SELECT SUM(total_harga) as pendapatan FROM penjualan WHERE DATE(tanggal) = '$today'";
            $result = mysqli_query($conn, $query);
            $data = mysqli_fetch_assoc($result);
            echo "<p>Rp " . number_format($data['pendapatan'], 0, ',', '.') . "</p>";
            ?>
        </div>
    </section>
</main>

<?php include 'views/footer.php'; ?>

</body>
</html>
