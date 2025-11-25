<?php
if (!defined('MY_APP')) {
    die('Akses langsung tidak diperbolehkan!');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['return_id'])) {
    $loanId = (int) $_POST['return_id'];
    $loan = db()->query("SELECT id_buku FROM peminjaman WHERE id_peminjaman = {$loanId} AND status = 'dipinjam'")->fetch_assoc();

    if ($loan) {
        db()->query("UPDATE peminjaman SET status = 'dikembalikan', tanggal_kembali = CURDATE() WHERE id_peminjaman = {$loanId}");
        db()->query("UPDATE buku SET stok = stok + 1 WHERE id_buku = {$loan['id_buku']}");
        setFlash('success', 'Buku berhasil dikembalikan.');
    } else {
        setFlash('error', 'Peminjaman tidak ditemukan atau sudah dikembalikan.');
    }
    redirect('index.php?hal=pengembalian');
}

$activeLoans = db()->query("
    SELECT p.id_peminjaman, p.tanggal_pinjam, b.judul, a.nama_lengkap
    FROM peminjaman p
    JOIN buku b ON b.id_buku = p.id_buku
    JOIN anggota a ON a.id_anggota = p.id_anggota
    WHERE p.status = 'dipinjam'
    ORDER BY p.tanggal_pinjam ASC
")->fetch_all(MYSQLI_ASSOC);
?>

<h2 class="mb-4">Pengembalian Buku</h2>

<div class="card">
    <div class="card-body table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Judul Buku</th>
                    <th>Anggota</th>
                    <th>Tanggal Pinjam</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($activeLoans)): ?>
                    <tr>
                        <td colspan="5" class="text-center">Tidak ada buku yang sedang dipinjam.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($activeLoans as $index => $loan): ?>
                        <tr>
                            <td><?php echo $index + 1; ?></td>
                            <td><?php echo e($loan['judul']); ?></td>
                            <td><?php echo e($loan['nama_lengkap']); ?></td>
                            <td><?php echo e($loan['tanggal_pinjam']); ?></td>
                            <td>
                                <form method="post" onsubmit="return confirm('Pastikan buku sudah diterima?');">
                                    <input type="hidden" name="return_id" value="<?php echo $loan['id_peminjaman']; ?>">
                                    <button type="submit" class="btn btn-success btn-sm">Konfirmasi Pengembalian</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

