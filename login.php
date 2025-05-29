<?php
session_start();

// Simulasi login sederhana (belum terhubung database)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Login default sementara (bisa diganti nanti dengan database)
    if ($username == "admin" && $password == "admin123") {
        $_SESSION['username'] = $username;
        $_SESSION['role'] = 'admin'; // role bisa: admin, kasir, owner
        header("Location: index.php");
        exit();
    } else {
        $error = "Username atau password salah!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login - SIM Penjualan</title>
</head>
<body>
    <h2>Login SIM Penjualan</h2>

    <?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>

    <form method="POST" action="">
        <label>Username:</label><br>
        <input type="text" name="username" required><br><br>

        <label>Password:</label><br>
        <input type="password" name="password" required><br><br>

        <button type="submit">Login</button>
    </form>
</body>
</html>
