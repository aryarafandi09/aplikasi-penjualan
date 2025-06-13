<?php
include '../../config/database.php';

$id = $_GET['id'];
$data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM barang WHERE id='$id'"));

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST['nama_barang'];
    $stok = $_POST['stok'];
    $harga = $_POST['harga'];

    mysqli_query($conn, "UPDATE barang SET nama_barang='$nama', stok='$stok', harga='$harga' WHERE id='$id'");
    echo "<script>window.location.href='index.php';</script>";
}

include '../../views/header.php';
include '../../views/sidebar.php';
?>

<div class="container mt-4">
    <h2>Edit Barang</h2>

    <form method="POST" class="mt-3">
        <div class="mb-3">
            <label for="nama" class="form-label">Nama Barang</label>
            <input type="text" name="nama_barang" id="nama" class="form-control" value="<?= $data['nama_barang'] ?>" required>
        </div>
        <div class="mb-3">
            <label for="stok" class="form-label">Stok</label>
            <input type="number" name="stok" id="stok" class="form-control" value="<?= $data['stok'] ?>" required>
        </div>
        <div class="mb-3">
            <label for="harga" class="form-label">Harga</label>
            <input type="number" name="harga" id="harga" class="form-control" value="<?= $data['harga'] ?>" required>
        </div>
        <button type="submit" class="btn btn-warning">Update</button>
        <a href="index.php" class="btn btn-secondary">Batal</a>
    </form>
</div>

<?php include '../../views/footer.php'; ?>
