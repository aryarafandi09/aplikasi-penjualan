<?php
$host = "localhost";        // biasanya tetap localhost
$user = "root";             // user default XAMPP
$pass = "";                 // password default biasanya kosong
$db   = "tokoarya";    // nama database kamu (bisa diganti sesuai kebutuhan)

$conn = mysqli_connect($host, $user, $pass, $db);

// Cek koneksi
if (!$conn) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}
?>
