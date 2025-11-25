# Admin Perpustakaan - Aplikasi Web

Aplikasi web admin untuk sistem manajemen perpustakaan menggunakan PHP dan Bootstrap.

**Sumber**: Repository ini diambil dari [https://github.com/r3zbun/admin-perpustakaan.git](https://github.com/r3zbun/admin-perpustakaan.git)

---

## 📁 Struktur Folder

```
admin-perpustakaan/
├── assets/
│   ├── css/
│   │   └── styles.css          # File CSS custom
│   └── js/
│       ├── scripts.js           # JavaScript utama
│       └── datatables-simple-demo.js  # Script untuk DataTables
├── includes/
│   ├── header.php               # Header template
│   ├── footer.php               # Footer template
│   ├── nav.php                  # Navigation bar
│   └── sidebar.php              # Sidebar menu
├── pages/
│   └── dashboard.php            # Halaman dashboard
├── index.php                    # File utama (router)
└── login.php                    # Halaman login
```

---


### 1. **Persiapan**
- Pastikan XAMPP/WAMP/Laragon sudah terinstall
- Pastikan MySQL dan Apache berjalan
- Import database `perpustakaan.sql` ke phpMyAdmin

### 2. **Instalasi**
1. Copy folder `admin-perpustakaan` ke dalam folder `htdocs` (XAMPP) atau `www` (WAMP/Laragon)
   - **XAMPP**: `C:\xampp\htdocs\admin-perpustakaan`
   - **WAMP**: `C:\wamp64\www\admin-perpustakaan`
   - **Laragon**: `C:\laragon\www\admin-perpustakaan`

2. Buka browser dan akses:
   ```
   http://localhost/admin-perpustakaan/login.php
   ```

### 3. **Konfigurasi Database** (Jika diperlukan)
Jika aplikasi memerlukan koneksi database, buat file `config.php` di root folder:

```php
<?php
$host = 'localhost';
$dbname = 'perpustakaan';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Koneksi gagal: " . $e->getMessage());
}
?>
```

---

## 📋 Fitur

### Halaman yang Tersedia:
-  **Login** - Halaman autentikasi admin
-  **Dashboard** - Halaman utama dengan statistik
  - Total Buku
  - Total Anggota
  - Buku Dipinjam
  - DataTable contoh

### Teknologi yang Digunakan:
- **PHP** - Backend language
- **Bootstrap 5.2.3** - CSS Framework
- **Font Awesome 6.3.0** - Icons
- **Chart.js 2.8.0** - Charts library
- **Simple DataTables 7.1.2** - Table plugin

---

## 🔧 Pengembangan

### Menambah Halaman Baru

1. Buat file PHP baru di folder `pages/`, contoh: `pages/buku.php`
2. Tambahkan proteksi di awal file:
   ```php
   <?php
   if(!defined('MY_APP')) {
       die('Akses langsung tidak diperbolehkan!');
   }
   ?>
   ```
3. Akses halaman melalui URL:
   ```
   http://localhost/admin-perpustakaan/index.php?hal=buku
   ```

### Routing System

Aplikasi menggunakan sistem routing sederhana:
- File `index.php` membaca parameter `hal` dari URL
- File yang sesuai akan di-include dari folder `pages/`
- Contoh: `?hal=dashboard` → `pages/dashboard.php`

---

##  Catatan

- Aplikasi ini adalah **template/admin panel** untuk sistem perpustakaan
- Halaman login saat ini masih **static** (belum terhubung dengan database)
- Dashboard menggunakan **data dummy** untuk contoh
- Perlu dikembangkan lebih lanjut untuk integrasi dengan database

---

## Koneksi dengan Database

Untuk menghubungkan aplikasi dengan database `perpustakaan`:

1. Buat file `config/database.php`:
```php
<?php
$host = 'localhost';
$dbname = 'perpustakaan';
$username = 'root';
$password = '';

$conn = mysqli_connect($host, $username, $password, $dbname);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>
```

2. Include di file yang membutuhkan:
```php
require_once 'config/database.php';
```

---

##  Database Schema

Aplikasi ini dirancang untuk bekerja dengan database `perpustakaan` yang memiliki tabel:
- `admin` - Data administrator
- `anggota` - Data anggota perpustakaan
- `buku` - Data buku
- `kategori` - Kategori buku
- `buku_kategori` - Relasi buku dan kategori
- `booking` - Data pemesanan buku
- `peminjaman` - Data peminjaman buku

Lihat file `../perpustakaan.sql` untuk struktur database lengkap.

---

##  Troubleshooting

### Halaman tidak muncul
- Pastikan file berada di folder `htdocs` atau `www`
- Cek apakah Apache berjalan
- Pastikan nama file sesuai dengan parameter `hal` di URL

### Error koneksi database
- Pastikan MySQL service berjalan
- Cek konfigurasi username dan password
- Pastikan database `perpustakaan` sudah dibuat

### CSS/JS tidak load
- Pastikan path ke folder `assets` benar
- Cek apakah file CSS/JS ada di folder `assets`
- Clear cache browser

---

**Dikembangkan untuk**: Tugas UTS - Atmaluhur University  
**Template Source**: [r3zbun/admin-perpustakaan](https://github.com/r3zbun/admin-perpustakaan)

