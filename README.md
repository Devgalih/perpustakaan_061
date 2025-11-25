# Database Perpustakaan - SQL Script

Folder ini berisi file-file untuk membuat database sistem perpustakaan sesuai dengan ERD yang diberikan.

## 📁 File yang Tersedia

### 1. `perpustakaan.sql` / `db_perpus.sql`
File SQL utama untuk membuat database dan semua tabel:
- Database: `perpustakaan`
- Tabel: `admin`, `anggota`, `buku`, `kategori`, `buku_kategori`, `booking`, `peminjaman`

**Cara menggunakan:**
1. Buka phpMyAdmin di browser (http://localhost/phpmyadmin)
2. Klik tab **SQL** atau menu **Import**
3. Copy-paste isi file `perpustakaan.sql` atau upload file tersebut
4. Klik **Go** atau **Import**
5. Database akan dibuat otomatis

### 2. `TROUBLESHOOTING_PHPMYADMIN.md`
Panduan lengkap untuk mengatasi masalah localhost phpMyAdmin yang tidak bisa dibuka.

**Baca file ini jika:**
- phpMyAdmin menampilkan error "Cannot connect"
- MySQL service tidak berjalan
- Port 3306 tidak bisa diakses

### 3. `cek_mysql_service.ps1`
Script PowerShell untuk mengecek status MySQL service di Windows.

**Cara menggunakan:**
1. Klik kanan pada file → **Run with PowerShell**
2. Atau buka PowerShell, lalu jalankan:
   ```powershell
   cd "pemrograman data base"
   .\cek_mysql_service.ps1
   ```

---

## 🚀 Quick Start

### Langkah 1: Pastikan MySQL Berjalan
- Buka **XAMPP Control Panel** (atau WAMP/Laragon)
- Pastikan **MySQL** statusnya **Running** (hijau)
- Jika tidak, klik **Start**

### Langkah 2: Buka phpMyAdmin
- Buka browser
- Akses: `http://localhost/phpmyadmin`
- Login dengan:
  - Username: `root`
  - Password: (kosongkan jika default XAMPP)

### Langkah 3: Import Database
- Klik tab **SQL** di phpMyAdmin
- Copy-paste isi file `perpustakaan.sql` atau `db_perpus.sql`
- Klik **Go**
- Database `perpustakaan` akan dibuat dengan semua tabel

---

## 📊 Struktur Database

### Tabel Utama:
1. **admin** - Data administrator sistem
2. **anggota** - Data anggota perpustakaan
3. **buku** - Data buku
4. **kategori** - Kategori buku
5. **buku_kategori** - Relasi many-to-many buku dan kategori
6. **booking** - Data pemesanan buku
7. **peminjaman** - Data peminjaman buku

### Relasi:
- `anggota` → `booking` (1 to many)
- `anggota` → `peminjaman` (1 to many)
- `buku` → `booking` (1 to many)
- `buku` → `peminjaman` (1 to many)
- `buku` ↔ `kategori` (many to many via `buku_kategori`)

---

## ⚠️ Troubleshooting

Jika mengalami masalah, baca file **TROUBLESHOOTING_PHPMYADMIN.md** untuk solusi lengkap.

**Masalah umum:**
- ❌ phpMyAdmin error "Cannot connect"
  - ✅ **Solusi**: Start MySQL service di XAMPP Control Panel

- ❌ Port 3306 sudah digunakan
  - ✅ **Solusi**: Stop aplikasi lain yang menggunakan port 3306

- ❌ Password MySQL tidak cocok
  - ✅ **Solusi**: Cek konfigurasi di `config.inc.php` phpMyAdmin

---

## 📝 Catatan

- File SQL menggunakan charset `utf8mb4` untuk support emoji dan karakter khusus
- Semua foreign key menggunakan `ON UPDATE CASCADE` dan `ON DELETE RESTRICT/CASCADE`
- Primary key menggunakan `AUTO_INCREMENT` untuk auto-generate ID

---

**Selamat menggunakan!** 🎉
