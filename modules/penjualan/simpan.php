if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $barang_id = $_POST['barang_id'];
    $jumlah = $_POST['jumlah'];

    // Ambil harga barang
    $query_barang = mysqli_query($conn, "SELECT harga, stok FROM barang WHERE id = '$barang_id'");
    $barang = mysqli_fetch_assoc($query_barang);
    $harga = $barang['harga'];
    $stok = $barang['stok'];

    if ($jumlah > $stok) {
        echo "<script>alert('Stok tidak mencukupi!'); window.location.href='tambah.php';</script>";
        exit();
    }

    $total = $harga * $jumlah;

    // Simpan ke penjualan
    $query_insert = "INSERT INTO penjualan (barang_id, jumlah, total_harga, tanggal) VALUES ('$barang_id', '$jumlah', '$total', NOW())";
    $result = mysqli_query($conn, $query_insert);

    // Update stok barang
    if ($result) {
        $new_stok = $stok - $jumlah;
        mysqli_query($conn, "UPDATE barang SET stok = '$new_stok' WHERE id = '$barang_id'");

        echo "<script>alert('Transaksi berhasil!'); window.location.href='index.php';</script>";
    } else {
        echo "Gagal: " . mysqli_error($conn);
    }
}
