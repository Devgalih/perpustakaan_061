<?php
if (!defined('MY_APP')) {
    die('Akses langsung tidak diperbolehkan!');
}

$members = db()->query("SELECT * FROM anggota ORDER BY nama_lengkap ASC")->fetch_all(MYSQLI_ASSOC);
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="mb-0">Daftar Anggota</h2>
        <small class="text-muted">Data anggota perpustakaan.</small>
    </div>
    <a href="index.php?hal=tambah-anggota" class="btn btn-primary">
        <i class="fas fa-user-plus me-1"></i> Tambah Anggota
    </a>
</div>

<div class="card">
    <div class="card-body table-responsive">
        <table class="table table-striped" id="datatablesSimple">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama Lengkap</th>
                    <th>Email</th>
                    <th>Alamat</th>
                    <th>No. Telepon</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($members)): ?>
                    <tr>
                        <td colspan="5" class="text-center">Belum ada anggota.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($members as $index => $member): ?>
                        <tr>
                            <td><?php echo $index + 1; ?></td>
                            <td><?php echo e($member['nama_lengkap']); ?></td>
                            <td><?php echo e($member['email']); ?></td>
                            <td><?php echo e($member['alamat']); ?></td>
                            <td><?php echo e($member['no_telepon']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

