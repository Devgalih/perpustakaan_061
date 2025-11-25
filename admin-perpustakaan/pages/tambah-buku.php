<?php
if (!defined('MY_APP')) {
    die('Akses langsung tidak diperbolehkan!');
}

$categories = db()->query("SELECT id_kategori, nama_kategori FROM kategori ORDER BY nama_kategori")->fetch_all(MYSQLI_ASSOC);
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $judul = trim($_POST['judul'] ?? '');
    $penulis = trim($_POST['penulis'] ?? '');
    $penerbit = trim($_POST['penerbit'] ?? '');
    $tahun = (int) ($_POST['tahun_terbit'] ?? 0);
    $stok = (int) ($_POST['stok'] ?? 0);
    $selectedCategories = $_POST['kategori'] ?? [];

    if ($judul === '') {
        $errors[] = 'Judul wajib diisi.';
    }
    if ($tahun <= 0) {
        $errors[] = 'Tahun terbit tidak valid.';
    }
    if ($stok < 0) {
        $errors[] = 'Stok minimal 0.';
    }

    if (empty($errors)) {
        $stmt = db()->prepare("INSERT INTO buku (judul, penulis, penerbit, tahun_terbit, stok) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param('sssii', $judul, $penulis, $penerbit, $tahun, $stok);
        $stmt->execute();
        $bookId = $stmt->insert_id;
        $stmt->close();

        if (!empty($selectedCategories)) {
            $catStmt = db()->prepare("INSERT INTO buku_kategori (id_buku, id_kategori) VALUES (?, ?)");
            foreach ($selectedCategories as $catId) {
                $catStmt->bind_param('ii', $bookId, $catId);
                $catStmt->execute();
            }
            $catStmt->close();
        }

        setFlash('success', 'Buku berhasil ditambahkan.');
        redirect('index.php?hal=daftar-buku');
    }
}
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="mb-0">Tambah Buku</h2>
        <small class="text-muted">Isi data buku secara lengkap.</small>
    </div>
    <a href="index.php?hal=daftar-buku" class="btn btn-secondary">Kembali</a>
</div>

<?php if (!empty($errors)): ?>
    <div class="alert alert-danger">
        <ul class="mb-0">
            <?php foreach ($errors as $error): ?>
                <li><?php echo e($error); ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<div class="card">
    <div class="card-body">
        <form method="post">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Judul Buku</label>
                    <input type="text" name="judul" class="form-control" required value="<?php echo e($_POST['judul'] ?? ''); ?>">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Penulis</label>
                    <input type="text" name="penulis" class="form-control" value="<?php echo e($_POST['penulis'] ?? ''); ?>">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Penerbit</label>
                    <input type="text" name="penerbit" class="form-control" value="<?php echo e($_POST['penerbit'] ?? ''); ?>">
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Tahun Terbit</label>
                    <input type="number" name="tahun_terbit" class="form-control" min="1900" max="<?php echo date('Y'); ?>" value="<?php echo e($_POST['tahun_terbit'] ?? date('Y')); ?>">
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Stok</label>
                    <input type="number" name="stok" class="form-control" min="0" value="<?php echo e($_POST['stok'] ?? 0); ?>">
                </div>
                <div class="col-md-12 mb-3">
                    <label class="form-label d-flex justify-content-between">
                        <span>Kategori</span>
                        <a href="index.php?hal=tambah-kategori" class="small">Tambah kategori baru</a>
                    </label>
                    <?php if (empty($categories)): ?>
                        <div class="alert alert-info">Belum ada kategori. Tambahkan terlebih dahulu.</div>
                    <?php else: ?>
                        <select name="kategori[]" class="form-select" multiple size="5">
                            <?php foreach ($categories as $category): ?>
                                <option value="<?php echo $category['id_kategori']; ?>" <?php echo (!empty($_POST['kategori']) && in_array($category['id_kategori'], $_POST['kategori'])) ? 'selected' : ''; ?>>
                                    <?php echo e($category['nama_kategori']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <small class="text-muted">Tekan CTRL (atau CMD di Mac) untuk memilih lebih dari satu.</small>
                    <?php endif; ?>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
</div>

