<?php
include '../../config/database.php';
include '../../views/header.php';
include '../../views/sidebar.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $barang_id = $_POST['barang_id'];
    $jumlah = $_POST['jumlah'];

    $barang = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM barang WHERE id='$barang_id'"));
    $total = $barang['harga'] * $jumlah;

    mysqli_query($conn, "INSERT INTO penjualan (barang_id, jumlah, total_harga, tanggal) 
        VALUES ('$barang_id', '$jumlah', '$total', NOW())");

    // Update stok
    $stok_baru = $barang['stok'] - $jumlah;
    mysqli_query($conn, "UPDATE barang SET stok='$stok_baru' WHERE id='$barang_id'");

    echo "<script>window.location.href='index.php';</script>";
}

$barang = mysqli_query($conn, "SELECT * FROM barang");
?>

<div class="container mt-4">
    <h2 class="mb-4">Tambah Transaksi Penjualan</h2>

    <form method="POST" class="shadow p-4 rounded bg-white">
        <div class="mb-3">
            <label for="barang" class="form-label">Pilih Barang</label>
            <select name="barang_id" id="barang" class="form-select" required>
                <option value="">-- Pilih Barang --</option>
                <?php while ($b = mysqli_fetch_assoc($barang)): ?>
                    <option value="<?= $b['id'] ?>">
                        <?= $b['nama_barang'] ?> (Stok: <?= $b['stok'] ?> | Harga: Rp<?= number_format($b['harga'], 0, ',', '.') ?>)
                    </option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="jumlah" class="form-label">Jumlah</label>
            <input type="number" name="jumlah" id="jumlah" class="form-control" min="1" required>
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-success"><i class="bi bi-cart-plus"></i> Simpan Transaksi</button>
            <a href="index.php" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>

<?php include '../../views/footer.php'; ?>
