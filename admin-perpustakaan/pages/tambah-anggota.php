<?php
if (!defined('MY_APP')) {
    die('Akses langsung tidak diperbolehkan!');
}

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = trim($_POST['nama_lengkap'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $alamat = trim($_POST['alamat'] ?? '');
    $telepon = trim($_POST['no_telepon'] ?? '');

    if ($nama === '') {
        $errors[] = 'Nama wajib diisi.';
    }
    if ($email === '') {
        $errors[] = 'Email wajib diisi.';
    }
    if ($password === '') {
        $errors[] = 'Password wajib diisi.';
    }

    if (empty($errors)) {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = db()->prepare("INSERT INTO anggota (nama_lengkap, email, password, alamat, no_telepon) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param('sssss', $nama, $email, $hash, $alamat, $telepon);
        $stmt->execute();
        $stmt->close();

        setFlash('success', 'Anggota baru berhasil ditambahkan.');
        redirect('index.php?hal=daftar-anggota');
    }
}
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="mb-0">Tambah Anggota</h2>
        <small class="text-muted">Masukkan data anggota baru.</small>
    </div>
    <a href="index.php?hal=daftar-anggota" class="btn btn-secondary">Kembali</a>
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
                    <label class="form-label">Nama Lengkap</label>
                    <input type="text" name="nama_lengkap" class="form-control" required value="<?php echo e($_POST['nama_lengkap'] ?? ''); ?>">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" required value="<?php echo e($_POST['email'] ?? ''); ?>">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Password</label>
                    <input type="text" name="password" class="form-control" required>
                    <small class="text-muted">Password akan di-hash secara otomatis.</small>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">No. Telepon</label>
                    <input type="text" name="no_telepon" class="form-control" value="<?php echo e($_POST['no_telepon'] ?? ''); ?>">
                </div>
                <div class="col-12 mb-3">
                    <label class="form-label">Alamat</label>
                    <textarea name="alamat" class="form-control" rows="3"><?php echo e($_POST['alamat'] ?? ''); ?></textarea>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
</div>

