<?php
if (!defined('MY_APP')) {
    die('Akses langsung tidak diperbolehkan!');
}

$members = db()->query("SELECT id_anggota, nama_lengkap FROM anggota ORDER BY nama_lengkap")->fetch_all(MYSQLI_ASSOC);
$books = db()->query("SELECT id_buku, judul, stok FROM buku ORDER BY judul")->fetch_all(MYSQLI_ASSOC);
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create_loan'])) {
    $anggotaId = (int) ($_POST['id_anggota'] ?? 0);
    $bukuId = (int) ($_POST['id_buku'] ?? 0);
    $tanggalPinjam = $_POST['tanggal_pinjam'] ?? date('Y-m-d');
    $tanggalKembali = $_POST['tanggal_kembali'] ?? null;

    if ($anggotaId <= 0 || $bukuId <= 0) {
        $errors[] = 'Anggota dan buku wajib dipilih.';
    }

    $bookCheck = db()->query("SELECT stok FROM buku WHERE id_buku = {$bukuId}")->fetch_assoc();
    if (!$bookCheck) {
        $errors[] = 'Buku tidak ditemukan.';
    } elseif ($bookCheck['stok'] <= 0) {
        $errors[] = 'Stok buku kosong.';
    }

    if (empty($errors)) {
        $stmt = db()->prepare("INSERT INTO peminjaman (tanggal_pinjam, tanggal_kembali, status, id_anggota, id_buku) VALUES (?, ?, 'dipinjam', ?, ?)");
        $stmt->bind_param('ssii', $tanggalPinjam, $tanggalKembali, $anggotaId, $bukuId);
        $stmt->execute();
        $stmt->close();

        db()->query("UPDATE buku SET stok = stok - 1 WHERE id_buku = {$bukuId}");

        setFlash('success', 'Peminjaman berhasil dicatat.');
        redirect('index.php?hal=peminjaman');
    }
}

$loans = db()->query("
    SELECT p.*, b.judul, a.nama_lengkap
    FROM peminjaman p
    JOIN buku b ON b.id_buku = p.id_buku
    JOIN anggota a ON a.id_anggota = p.id_anggota
    ORDER BY p.tanggal_pinjam DESC
")->fetch_all(MYSQLI_ASSOC);
?>

<h2 class="mb-4">Transaksi Peminjaman</h2>

<?php if (!empty($errors)): ?>
    <div class="alert alert-danger">
        <ul class="mb-0">
            <?php foreach ($errors as $error): ?>
                <li><?php echo e($error); ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<div class="card mb-4">
    <div class="card-header">Tambah Peminjaman</div>
    <div class="card-body">
        <form method="post" class="row g-3">
            <input type="hidden" name="create_loan" value="1">
            <div class="col-md-4">
                <label class="form-label">Anggota</label>
                <select name="id_anggota" class="form-select" required>
                    <option value="">-- Pilih Anggota --</option>
                    <?php foreach ($members as $member): ?>
                        <option value="<?php echo $member['id_anggota']; ?>"><?php echo e($member['nama_lengkap']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">Buku</label>
                <select name="id_buku" class="form-select" required>
                    <option value="">-- Pilih Buku --</option>
                    <?php foreach ($books as $book): ?>
                        <option value="<?php echo $book['id_buku']; ?>">
                            <?php echo e($book['judul']); ?> (Stok: <?php echo $book['stok']; ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label">Tanggal Pinjam</label>
                <input type="date" name="tanggal_pinjam" class="form-control" value="<?php echo date('Y-m-d'); ?>">
            </div>
            <div class="col-md-2">
                <label class="form-label">Rencana Kembali</label>
                <input type="date" name="tanggal_kembali" class="form-control">
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header">Riwayat Peminjaman</div>
    <div class="card-body table-responsive">
        <table class="table table-striped" id="datatablesSimple">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Buku</th>
                    <th>Anggota</th>
                    <th>Tanggal Pinjam</th>
                    <th>Tanggal Kembali</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($loans)): ?>
                    <tr>
                        <td colspan="6" class="text-center">Belum ada peminjaman.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($loans as $index => $loan): ?>
                        <tr>
                            <td><?php echo $index + 1; ?></td>
                            <td><?php echo e($loan['judul']); ?></td>
                            <td><?php echo e($loan['nama_lengkap']); ?></td>
                            <td><?php echo e($loan['tanggal_pinjam']); ?></td>
                            <td><?php echo e($loan['tanggal_kembali'] ?: '-'); ?></td>
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

