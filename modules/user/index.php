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
    $role     = $_POST['role'];
    mysqli_query($conn, "INSERT INTO user (username, password, Role, nama_lengkap) VALUES ('$username', '$password', '$role', '-')");
    echo "<script>window.location.href='index.php';</script>";
}

// Edit
if (isset($_POST['update'])) {
    $id = $_POST['id_user'];
    $username = $_POST['username'];
    $role = $_POST['role'];

    if (!empty($_POST['password'])) {
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        mysqli_query($conn, "UPDATE user SET username='$username', password='$password', Role='$role' WHERE id_user='$id'");
    } else {
        mysqli_query($conn, "UPDATE user SET username='$username', Role='$role' WHERE id_user='$id'");
    }
    echo "<script>window.location.href='index.php';</script>";
}

// Hapus
if (isset($_GET['hapus'])) {
    mysqli_query($conn, "DELETE FROM user WHERE id_user='{$_GET['hapus']}'");
    echo "<script>window.location.href='index.php';</script>";
}

// Ambil data untuk edit
$edit = null;
if (isset($_GET['edit'])) {
    $edit = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM user WHERE id_user='{$_GET['edit']}'"));
}
?>

<div class="container mt-4">
    <h3 class="mb-3"><?= $edit ? 'Edit Pengguna' : 'Tambah Pengguna' ?></h3>

    <form method="POST" class="mb-4">
        <?php if ($edit): ?>
            <input type="hidden" name="id_user" value="<?= $edit['id_user'] ?>">
        <?php endif; ?>

        <div class="mb-3">
            <label>Username</label>
            <input type="text" name="username" class="form-control" value="<?= $edit['username'] ?? '' ?>" required>
        </div>

        <div class="mb-3">
            <label>Password <?= $edit ? '<small class="text-muted">(Kosongkan jika tidak diubah)</small>' : '' ?></label>
            <input type="password" name="password" class="form-control" <?= $edit ? '' : 'required' ?>>
        </div>

        <div class="mb-3">
            <label>Role</label>
            <select name="role" class="form-select" required>
                <?php foreach (['Admin', 'Kasir', 'Owner'] as $r): ?>
                    <option value="<?= $r ?>" <?= isset($edit['Role']) && $edit['Role'] == $r ? 'selected' : '' ?>><?= $r ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <button type="submit" name="<?= $edit ? 'update' : 'tambah' ?>" class="btn btn-primary">
            <?= $edit ? 'Update' : 'Simpan' ?>
        </button>
        <?php if ($edit): ?>
            <a href="index.php" class="btn btn-secondary">Batal</a>
        <?php endif; ?>
    </form>

    <h4>Daftar Pengguna</h4>
    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>No</th>
                <th>Username</th>
                <th>Role</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            $data = mysqli_query($conn, "SELECT * FROM user");
            while ($row = mysqli_fetch_assoc($data)):
                $badge = match($row['Role']) {
                    'Admin' => 'danger',
                    'Kasir' => 'success',
                    'Owner' => 'warning',
                    default => 'secondary'
                };
            ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $row['username'] ?></td>
                    <td><span class="badge bg-<?= $badge ?>"><?= $row['Role'] ?></span></td>
                    <td>
                        <a href="index.php?edit=<?= $row['id_user'] ?>" class="btn btn-sm btn-warning">Edit</a>
                        <a href="index.php?hapus=<?= $row['id_user'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus?')">Hapus</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<?php include '../../views/footer.php'; ?>
