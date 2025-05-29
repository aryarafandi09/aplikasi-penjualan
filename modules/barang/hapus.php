<?php
include '../../config/database.php';

$id = $_GET['id'];

$hapus = mysqli_query($conn, "DELETE FROM barang WHERE id = '$id'");

if ($hapus) {
    echo "<script>alert('Barang berhasil dihapus!'); window.location.href='index.php';</script>";
} else {
    echo "Gagal hapus: " . mysqli_error($conn);
}
?>
