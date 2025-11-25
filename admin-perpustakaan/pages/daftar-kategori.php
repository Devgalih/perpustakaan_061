<?php
if (!defined('MY_APP')) {
    die('Akses langsung tidak diperbolehkan!');
}

$categories = db()->query("
    SELECT k.*, COUNT(bk.id_buku) AS total_buku
    FROM kategori k
    LEFT JOIN buku_kategori bk ON bk.id_kategori = k.id_kategori
    GROUP BY k.id_kategori
    ORDER BY k.nama_kategori
")->fetch_all(MYSQLI_ASSOC);
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="mb-0">Daftar Kategori</h2>
        <small class="text-muted">Mengelola kategori buku.</small>
    </div>
    <a href="index.php?hal=tambah-kategori" class="btn btn-primary">
        <i class="fas fa-plus me-1"></i> Tambah Kategori
    </a>
</div>

<div class="card">
    <div class="card-body table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama Kategori</th>
                    <th>Total Buku</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($categories)): ?>
                    <tr>
                        <td colspan="3" class="text-center">Belum ada kategori.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($categories as $index => $category): ?>
                        <tr>
                            <td><?php echo $index + 1; ?></td>
                            <td><?php echo e($category['nama_kategori']); ?></td>
                            <td><?php echo e($category['total_buku']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

