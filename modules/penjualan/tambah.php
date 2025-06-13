<?php
include '../../config/database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $barang_id = $_POST['barang_id'];
    $jumlah = $_POST['jumlah'];

    $b = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM barang WHERE id='$barang_id'"));
    $total = $b['harga'] * $jumlah;

    mysqli_query($conn, "INSERT INTO penjualan (barang_id, jumlah, total_harga, tanggal) VALUES ('$barang_id', '$jumlah', '$total', NOW())");

    $new_stok = $b['stok'] - $jumlah;
    mysqli_query($conn, "UPDATE barang SET stok='$new_stok' WHERE id='$barang_id'");

    echo "<script>window.location.href='index.php';</script>";
}

include '../../views/header.php';
include '../../views/sidebar.php';

$barang = mysqli_query($conn, "SELECT * FROM barang");
?>

<div class="container mt-4">
    <h2>Transaksi Baru</h2>

    <form method="POST" class="mt-3">
        <div class="mb-3">
            <label for="barang" class="form-label">Pilih Barang</label>
            <select name="barang_id" id="barang" class="form-select" required>
                <option value="">-- Pilih Barang --</option>
                <?php while ($b = mysqli_fetch_assoc($barang)): ?>
                    <option value="<?= $b['id'] ?>"><?= $b['nama_barang'] ?> (Stok: <?= $b['stok'] ?>)</option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="jumlah" class="form-label">Jumlah</label>
            <input type="number" name="jumlah" id="jumlah" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success">Simpan Transaksi</button>
        <a href="index.php" class="btn btn-secondary">Batal</a>
    </form>
</div>

<?php include '../../views/footer.php'; ?>
