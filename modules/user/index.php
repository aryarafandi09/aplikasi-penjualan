<?php
include 'hakakses.php';
cekRole(['Admin']);

include '../../views/header.php';
include '../../views/sidebar.php';
include '../../config/database.php';

// Tambah
if (isset($_POST['tambah'])) {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role     = $_POST['Role'];
    mysqli_query($conn, "INSERT INTO user (username, password, Role) VALUES ('$username', '$password', '$Role')");
    echo "<script>window.location.href='index.php';</script>";
}

// Edit
if (isset($_POST['update'])) {
    $id = $_POST['id_user'];
    $username = $_POST['username'];
    $role = $_POST['Role'];

    if (!empty($_POST['password'])) {
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        mysqli_query($conn, "UPDATE user SET username='$username', password='$password', Role='$Role' WHERE id_user='$id_user'");
    } else {
        mysqli_query($conn, "UPDATE user SET username='$username', Role='$Role' WHERE id_user='$id_user'");
    }
    echo "<script>window.location.href='index.php';</script>";
}

// Hapus
if (isset($_GET['hapus'])) {
    mysqli_query($conn, "DELETE FROM user WHERE id_user='{$_GET['hapus']}'");
    echo "<script>window.location.href='index.php';</script>";
}

// Ambil user untuk edit
$edit = null;
if (isset($_GET['edit'])) {
    $edit = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM user WHERE id_user='{$_GET['edit']}'"));
}
?>

<h3><?= $edit ? 'Edit User' : 'Tambah User' ?></h3>
<form method="POST">
    <?php if ($edit): ?><input type="hidden" name="id" value="<?= $edit['id'] ?>"><?php endif; ?>
    Username:<br>
    <input type="text" name="username" value="<?= $edit['username'] ?? '' ?>" required><br>
    Password:<br>
    <input type="password" name="password" <?= $edit ? '' : 'required' ?>><br>
    Role:<br>
    <select name="Role" required>
        <?php foreach (['admin', 'kasir', 'owner'] as $r): ?>
            <option value="<?= $r ?>" <?= isset($edit['Role']) && $edit['Role'] == $r ? 'selected' : '' ?>><?= ucfirst($r) ?></option>
        <?php endforeach; ?>
    </select><br><br>
    <button type="submit" name="<?= $edit ? 'update' : 'tambah' ?>">
        <?= $edit ? 'Update' : 'Simpan' ?>
    </button>
    <?php if ($edit): ?><a href="index.php">Batal</a><?php endif; ?>
</form>

<hr>

<h3>Daftar Pengguna</h3>
<table border="1" cellpadding="6" cellspacing="0">
    <tr>
        <th>No</th>
        <th>Username</th>
        <th>Role</th>
        <th>Aksi</th>
    </tr>
    <?php
    $no = 1;
    $data = mysqli_query($conn, "SELECT * FROM user");
    while ($row = mysqli_fetch_assoc($data)) {
        echo "<tr>
            <td>$no</td>
            <td>{$row['username']}</td>
            <td>{$row['Role']}</td>
            <td>
                <a href='index.php?edit={$row['id_user']}'>Edit</a> |
                <a href='index.php?hapus={$row['id_user']}' onclick=\"return confirm('Yakin hapus?')\">Hapus</a>
            </td>
        </tr>";
        $no++;
    }
    ?>
</table>

<?php include '../../views/footer.php'; ?>
