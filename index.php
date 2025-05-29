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
$role = $_SESSION['role']; // admin, kasir, owner
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - SIM Penjualan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0; padding: 0;
            background-color: #f3f3f3;
        }
        header {
            background-color: #007bff;
            color: white;
            padding: 1em;
            text-align: center;
        }
        .container {
            padding: 2em;
        }
        .card {
            background-color: white;
            padding: 1.5em;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            margin-bottom: 1em;
        }
        .logout {
            float: right;
            margin-top: -40px;
        }
        .logout a {
            color: white;
            background-color: red;
            padding: 5px 10px;
            border-radius: 4px;
            text-decoration: none;
        }
    </style>
</head>
<body>

<header>
    <h1>Dashboard - SIM Penjualan</h1>
    <div class="logout">
        <a href="logout.php">Logout</a>
    </div>
</header>

<div class="container">
    <div class="card">
        <h2>Selamat Datang, <?= htmlspecialchars($username); ?>!</h2>
        <p>Anda login sebagai: <strong><?= htmlspecialchars(
