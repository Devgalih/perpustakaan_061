<?php
if (!defined('MY_APP')) {
    die('Akses langsung tidak diperbolehkan!');
}

$bookId = (int) ($_GET['id'] ?? 0);
if ($bookId <= 0) {
    setFlash('error', 'Buku tidak ditemukan.');
    redirect('index.php?hal=daftar-buku');
}

$bookStmt = db()->prepare("SELECT * FROM buku WHERE id_buku = ?");
$bookStmt->bind_param('i', $bookId);
$bookStmt->execute();
$book = $bookStmt->get_result()->fetch_assoc();
$bookStmt->close();

if (!$book) {
    setFlash('error', 'Buku tidak ditemukan.');
    redirect('index.php?hal=daftar-buku');
}

$categories = db()->query("SELECT id_kategori, nama_kategori FROM kategori ORDER BY nama_kategori")->fetch_all(MYSQLI_ASSOC);
$selectedCategories = db()->query("SELECT id_kategori FROM buku_kategori WHERE id_buku = {$bookId}")
    ->fetch_all(MYSQLI_ASSOC);
$selectedCategories = array_column($selectedCategories, 'id_kategori');

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
        $stmt = db()->prepare("UPDATE buku SET judul = ?, penulis = ?, penerbit = ?, tahun_terbit = ?, stok = ? WHERE id_buku = ?");
        $stmt->bind_param('sssiii', $judul, $penulis, $penerbit, $tahun, $stok, $bookId);
        $stmt->execute();
        $stmt->close();

        db()->query("DELETE FROM buku_kategori WHERE id_buku = {$bookId}");
        if (!empty($selectedCategories)) {
            $catStmt = db()->prepare("INSERT INTO buku_kategori (id_buku, id_kategori) VALUES (?, ?)");
            foreach ($selectedCategories as $catId) {
                $catStmt->bind_param('ii', $bookId, $catId);
                $catStmt->execute();
            }
            $catStmt->close();
        }

        setFlash('success', 'Perubahan buku tersimpan.');
        redirect('index.php?hal=daftar-buku');
    }
}
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="mb-0">Edit Buku</h2>
        <small class="text-muted">Perbarui informasi buku.</small>
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
                    <input type="text" name="judul" class="form-control" required value="<?php echo e($_POST['judul'] ?? $book['judul']); ?>">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Penulis</label>
                    <input type="text" name="penulis" class="form-control" value="<?php echo e($_POST['penulis'] ?? $book['penulis']); ?>">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Penerbit</label>
                    <input type="text" name="penerbit" class="form-control" value="<?php echo e($_POST['penerbit'] ?? $book['penerbit']); ?>">
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Tahun Terbit</label>
                    <input type="number" name="tahun_terbit" class="form-control" min="1900" max="<?php echo date('Y'); ?>" value="<?php echo e($_POST['tahun_terbit'] ?? $book['tahun_terbit']); ?>">
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Stok</label>
                    <input type="number" name="stok" class="form-control" min="0" value="<?php echo e($_POST['stok'] ?? $book['stok']); ?>">
                </div>
                <div class="col-md-12 mb-3">
                    <label class="form-label">Kategori</label>
                    <?php if (empty($categories)): ?>
                        <div class="alert alert-info">Belum ada kategori.</div>
                    <?php else: ?>
                        <select name="kategori[]" class="form-select" multiple size="5">
                            <?php foreach ($categories as $category): ?>
                                <option value="<?php echo $category['id_kategori']; ?>" <?php echo in_array($category['id_kategori'], $selectedCategories) ? 'selected' : ''; ?>>
                                    <?php echo e($category['nama_kategori']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    <?php endif; ?>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        </form>
    </div>
</div>

