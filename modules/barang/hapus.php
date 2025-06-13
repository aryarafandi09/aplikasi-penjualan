<?php
include '../../config/database.php';
$id = $_GET['id'];
mysqli_query($conn, "DELETE FROM barang WHERE id='$id'");
echo "<script>window.location.href='index.php';</script>";
