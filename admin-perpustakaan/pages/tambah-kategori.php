<?php
if (!defined('MY_APP')) {
    die('Akses langsung tidak diperbolehkan!');
}

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = trim($_POST['nama_kategori'] ?? '');

    if ($nama === '') {
        $errors[] = 'Nama kategori wajib diisi.';
    }

    if (empty($errors)) {
        $stmt = db()->prepare("INSERT INTO kategori (nama_kategori) VALUES (?)");
        $stmt->bind_param('s', $nama);
        $stmt->execute();
        $stmt->close();

        setFlash('success', 'Kategori berhasil ditambahkan.');
        redirect('index.php?hal=daftar-kategori');
    }
}
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="mb-0">Tambah Kategori</h2>
        <small class="text-muted">Kategori membantu mengelompokkan buku.</small>
    </div>
    <a href="index.php?hal=daftar-kategori" class="btn btn-secondary">Kembali</a>
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
            <div class="mb-3">
                <label class="form-label">Nama Kategori</label>
                <input type="text" name="nama_kategori" class="form-control" required value="<?php echo e($_POST['nama_kategori'] ?? ''); ?>">
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
</div>

