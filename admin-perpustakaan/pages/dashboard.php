<?php
if (!defined('MY_APP')) {
    die('Akses langsung tidak diperbolehkan!');
}

$bookCount = db()->query("SELECT COUNT(*) AS total FROM buku")->fetch_assoc()['total'] ?? 0;
$memberCount = db()->query("SELECT COUNT(*) AS total FROM anggota")->fetch_assoc()['total'] ?? 0;
$loanActive = db()->query("SELECT COUNT(*) AS total FROM peminjaman WHERE status = 'dipinjam'")->fetch_assoc()['total'] ?? 0;

$recentLoans = db()->query("
    SELECT p.id_peminjaman, p.tanggal_pinjam, p.status, b.judul, a.nama_lengkap
    FROM peminjaman p
    JOIN buku b ON b.id_buku = p.id_buku
    JOIN anggota a ON a.id_anggota = p.id_anggota
    ORDER BY p.tanggal_pinjam DESC
    LIMIT 10
")->fetch_all(MYSQLI_ASSOC);
?>

<h1 class="mt-2">Dashboard</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item active">Ringkasan</li>
</ol>
<div class="row">
    <div class="col-xl-4 col-md-6">
        <div class="card bg-danger text-white mb-4">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <div class="h2 font-weight-bold mb-0"><?php echo $bookCount; ?></div>
                    <div class="text-uppercase small">Total Buku</div>
                </div>
                <i class="fas fa-book fa-2x"></i>
            </div>
            <a class="card-footer text-white small d-flex justify-content-between" href="index.php?hal=daftar-buku">
                Lihat Buku
                <i class="fas fa-angle-right"></i>
            </a>
        </div>
    </div>
    <div class="col-xl-4 col-md-6">
        <div class="card bg-info text-white mb-4">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <div class="h2 font-weight-bold mb-0"><?php echo $memberCount; ?></div>
                    <div class="text-uppercase small">Total Anggota</div>
                </div>
            <i class="fas fa-user fa-2x"></i>
            </div>
            <a class="card-footer text-white small d-flex justify-content-between" href="index.php?hal=daftar-anggota">
                Lihat Anggota
                <i class="fas fa-angle-right"></i>
            </a>
        </div>
    </div>
    <div class="col-xl-4 col-md-6">
        <div class="card bg-success text-white mb-4">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <div class="h2 font-weight-bold mb-0"><?php echo $loanActive; ?></div>
                    <div class="text-uppercase small">Sedang Dipinjam</div>
                </div>
                <i class="fas fa-hand-holding fa-2x"></i>
            </div>
            <a class="card-footer text-white small d-flex justify-content-between" href="index.php?hal=peminjaman">
                Lihat Peminjaman
                <i class="fas fa-angle-right"></i>
            </a>
        </div>
    </div>
</div>

<div class="card mb-4">
    <div class="card-header">
        <i class="fas fa-table me-1"></i>
        Peminjaman Terbaru
    </div>
    <div class="card-body table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Judul Buku</th>
                    <th>Anggota</th>
                    <th>Tanggal Pinjam</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($recentLoans)): ?>
                    <tr>
                        <td colspan="5" class="text-center">Belum ada data peminjaman.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($recentLoans as $loan): ?>
                        <tr>
                            <td><?php echo e($loan['id_peminjaman']); ?></td>
                            <td><?php echo e($loan['judul']); ?></td>
                            <td><?php echo e($loan['nama_lengkap']); ?></td>
                            <td><?php echo e($loan['tanggal_pinjam']); ?></td>
                            <td>
                                <span class="badge bg-<?php echo $loan['status'] === 'dipinjam' ? 'warning text-dark' : 'success'; ?>">
                                    <?php echo e(ucwords($loan['status'])); ?>
                                </span>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
