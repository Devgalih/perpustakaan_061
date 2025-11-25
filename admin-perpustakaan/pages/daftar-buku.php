<?php
if (!defined('MY_APP')) {
    die('Akses langsung tidak diperbolehkan!');
}

$books = db()->query("
    SELECT b.*, GROUP_CONCAT(k.nama_kategori SEPARATOR ', ') AS kategori
    FROM buku b
    LEFT JOIN buku_kategori bk ON bk.id_buku = b.id_buku
    LEFT JOIN kategori k ON k.id_kategori = bk.id_kategori
    GROUP BY b.id_buku
    ORDER BY b.judul ASC
")->fetch_all(MYSQLI_ASSOC);
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="mb-0">Daftar Buku</h2>
        <small class="text-muted">Manajemen data buku perpustakaan</small>
    </div>
    <a href="index.php?hal=tambah-buku" class="btn btn-primary">
        <i class="fas fa-plus me-1"></i> Tambah Buku
    </a>
</div>

<div class="card">
    <div class="card-body table-responsive">
        <table class="table table-striped align-middle" id="datatablesSimple">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Judul</th>
                    <th>Penulis</th>
                    <th>Penerbit</th>
                    <th>Tahun</th>
                    <th>Stok</th>
                    <th>Kategori</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($books)): ?>
                    <tr>
                        <td colspan="8" class="text-center">Belum ada data buku.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($books as $index => $book): ?>
                        <tr>
                            <td><?php echo $index + 1; ?></td>
                            <td><?php echo e($book['judul']); ?></td>
                            <td><?php echo e($book['penulis']); ?></td>
                            <td><?php echo e($book['penerbit']); ?></td>
                            <td><?php echo e($book['tahun_terbit']); ?></td>
                            <td><?php echo e($book['stok']); ?></td>
                            <td><?php echo e($book['kategori'] ?: '-'); ?></td>
                            <td>
                                <a href="index.php?hal=edit-buku&id=<?php echo $book['id_buku']; ?>" class="btn btn-sm btn-outline-secondary">
                                    Edit
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

