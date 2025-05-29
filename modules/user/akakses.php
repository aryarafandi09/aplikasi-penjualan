<?php
session_start();

if (!isset($_SESSION['username'])) {
    echo "<script>alert('Anda harus login dulu!'); window.location.href='../../login.php';</script>";
    exit();
}

// Fungsi pembatasan role
function cekRole($role_izin = []) {
    if (!in_array($_SESSION['role'], $role_izin)) {
        echo "<script>alert('Akses ditolak!'); window.location.href='../../index.php';</script>";
        exit();
    }
}
