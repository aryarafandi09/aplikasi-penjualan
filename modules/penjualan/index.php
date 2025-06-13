<?php
include '../../views/header.php';
include '../../views/sidebar.php';
include '../../config/database.php';

// Fungsi format tanggal Indonesia
function formatTanggalIndo($tanggal) {
    $hari = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
    $bulan = [1=>'Januari','Februari','Maret','April','Mei','Juni',
              'Juli','Agustus','September','Oktober','November','Desember'];

    $date = date('Y-m-d H:i', strtotime($tanggal));
    $pecah = explode(' ', $date);
    $tgl = explode('-', $pecah[0]);

    $namaHari = $hari[date('w', strtotime($tanggal))];
    $namaBulan = $bulan[(int)$tgl[1]];
    $waktu = substr($pecah[1], 0, 5);

    return "$namaHari, {$tgl[2]} $namaBulan {$tgl[0]} - $waktu";
}

// Filter
$bulan = $_POST['bulan'] ?? date('m');
$tahun = $_POST['tahun'] ?? date('Y');

// Query transaksi
$data = mysqli_query($conn, "
    SELECT p.*, b.nama_barang 
    FROM penjualan p 
    JOIN barang b ON p.barang_id = b.id 
    WHERE MONTH(p.tanggal) = '$bulan' AND YEAR(p.tanggal) = '$tahun'
    ORDER BY p.tanggal DESC
");

$summary = mysqli_fetch_assoc(mysqli_query($conn, "
    SELECT COUNT(*) AS total_transaksi, SUM(total_harga) AS total_pendapatan 
    FROM penjualan 
    WHERE MONTH(tanggal) = '$bulan' AND YEAR(tanggal) = '$tahun'
"));

// Data grafik
$grafikData = mysqli_query($conn, "
    SELECT DATE(tanggal) AS tgl, SUM(total_harga) AS total 
    FROM penjualan 
    WHERE MONTH(tanggal) = '$bulan' AND YEAR(tanggal) = '$tahun'
    GROUP BY DATE(tanggal)
    ORDER BY tgl ASC
");

$labels = [];
$totals = [];

while ($g = mysqli_fetch_assoc($grafikData)) {
    $labels[] = date('d M', strtotime($g['tgl']));
    $totals[] = $g['total'];
}
?>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Transaksi Penjualan</h2>
        <a href="tambah.php" class="btn btn-primary">+ Tambah Transaksi</a>
    </div>

    <!-- Filter Bulan & Tahun -->
    <form method="POST" class="row g-3 mb-3">
        <div class="col-md-2">
            <label>Bulan:</label>
            <select name="bulan" class="form-select">
                <?php for ($i = 1; $i <= 12; $i++): ?>
                    <option value="<?= sprintf('%02d', $i) ?>" <?= ($bulan == sprintf('%02d', $i)) ? 'selected' : '' ?>>
                        <?= date('F', mktime(0, 0, 0, $i, 10)) ?>
                    </option>
                <?php endfor; ?>
            </select>
        </div>
        <div class="col-md-2">
            <label>Tahun:</label>
            <select name="tahun" class="form-select">
                <?php for ($y = 2023; $y <= date('Y'); $y++): ?>
                    <option value="<?= $y ?>" <?= ($tahun == $y) ? 'selected' : '' ?>>
                        <?= $y ?>
                    </option>
                <?php endfor; ?>
            </select>
        </div>
        <div class="col-md-3 d-flex align-items-end">
            <button type="submit" name="filter" class="btn btn-success">Tampilkan</button>
        </div>
    </form>

    <!-- Ringkasan -->
    <div class="mb-3">
        <p><strong>Total Transaksi:</strong> <?= $summary['total_transaksi'] ?? 0 ?></p>
        <p><strong>Total Pendapatan:</strong> Rp <?= number_format($summary['total_pendapatan'] ?? 0, 0, ',', '.') ?></p>
    </div>

    <!-- Tabel Transaksi -->
    <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Barang</th>
                    <th>Jumlah</th>
                    <th>Total Harga</th>
                    <th>Tanggal</th>
                </tr>
            </thead>
            <tbody>
                <?php if (mysqli_num_rows($data) > 0): ?>
                    <?php $no = 1; while ($row = mysqli_fetch_assoc($data)): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $row['nama_barang'] ?></td>
                            <td><?= $row['jumlah'] ?></td>
                            <td>Rp <?= number_format($row['total_harga'], 0, ',', '.') ?></td>
                            <td><span class="badge bg-light text-dark"><?= formatTanggalIndo($row['tanggal']) ?></span></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center text-muted">Belum ada transaksi bulan ini</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Grafik Penjualan -->
    <div class="card mt-4">
        <div class="card-header bg-dark text-white">📊 Grafik Pendapatan Harian</div>
        <div class="card-body">
            <canvas id="grafikPenjualan"></canvas>
        </div>
    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('grafikPenjualan').getContext('2d');
const chart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: <?= json_encode($labels) ?>,
        datasets: [{
            label: 'Pendapatan (Rp)',
            data: <?= json_encode($totals) ?>,
            backgroundColor: 'rgba(13, 110, 253, 0.7)',
            borderRadius: 5
        }]
    },
    options: {
        responsive: true,
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    callback: function(value) {
                        return 'Rp ' + value.toLocaleString('id-ID');
                    }
                }
            }
        }
    }
});
</script>

<?php include '../../views/footer.php'; ?>
