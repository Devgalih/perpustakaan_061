# Panduan Troubleshooting phpMyAdmin - Localhost Tidak Bisa Dibuka

## Masalah yang Terjadi
Error: **"Cannot connect: invalid settings"** dan **"No connection could be made because the target machine actively refused it"**

Ini berarti phpMyAdmin tidak bisa terhubung ke MySQL server.

---

## Solusi Langkah Demi Langkah

### 1. **Cek Apakah MySQL/MariaDB Service Berjalan**

#### Untuk XAMPP:
1. Buka **XAMPP Control Panel**
2. Cek apakah **MySQL** berstatus **Running** (hijau)
3. Jika tidak, klik tombol **Start** di sebelah MySQL
4. Tunggu hingga status berubah menjadi **Running**

#### Untuk WAMP:
1. Buka **WAMP Server**
2. Klik ikon WAMP di system tray (bawah kanan)
3. Pastikan **MySQL** berwarna hijau (aktif)
4. Jika merah, klik **Start/Resume Service** → **MySQL**

#### Untuk Laragon:
1. Buka **Laragon**
2. Pastikan **MySQL** berstatus **Running**
3. Jika tidak, klik **Start All**

#### Untuk Standalone MySQL:
1. Buka **Services** (Windows + R, ketik `services.msc`)
2. Cari **MySQL** atau **MariaDB**
3. Klik kanan → **Start** (jika statusnya Stopped)

---

### 2. **Cek Port MySQL**

MySQL biasanya berjalan di port **3306**. Pastikan port ini tidak digunakan aplikasi lain:

1. Buka **Command Prompt** atau **PowerShell** sebagai Administrator
2. Jalankan: `netstat -ano | findstr :3306`
3. Jika ada proses yang menggunakan port 3306, catat PID-nya
4. Cek di Task Manager apakah itu MySQL service

---

### 3. **Periksa Konfigurasi phpMyAdmin**

File konfigurasi phpMyAdmin biasanya ada di:
- **XAMPP**: `C:\xampp\phpMyAdmin\config.inc.php`
- **WAMP**: `C:\wamp64\apps\phpmyadmin\config.inc.php`
- **Laragon**: `C:\laragon\etc\phpmyadmin\config.inc.php`

Buka file `config.inc.php` dan pastikan pengaturan berikut:

```php
$cfg['Servers'][1]['host'] = '127.0.0.1';  // atau 'localhost'
$cfg['Servers'][1]['port'] = '3306';
$cfg['Servers'][1]['user'] = 'root';
$cfg['Servers'][1]['password'] = '';  // kosongkan jika default XAMPP
```

**Catatan**: 
- Untuk XAMPP default, password biasanya **kosong**
- Untuk WAMP, password default juga **kosong**
- Jika Anda sudah mengubah password MySQL, sesuaikan di sini

---

### 4. **Cek Firewall dan Antivirus**

Kadang firewall atau antivirus memblokir koneksi MySQL:

1. **Windows Firewall**: 
   - Buka **Windows Defender Firewall**
   - Pastikan MySQL diizinkan melalui firewall

2. **Antivirus**:
   - Sementara nonaktifkan antivirus untuk testing
   - Atau tambahkan XAMPP/WAMP ke exception list

---

### 5. **Restart Services**

Setelah mengubah konfigurasi:

1. **Stop** MySQL service
2. **Start** kembali MySQL service
3. Refresh halaman phpMyAdmin di browser

---

### 6. **Cek Error Log**

Lihat error log untuk detail lebih lanjut:

- **XAMPP**: `C:\xampp\mysql\data\*.err`
- **WAMP**: `C:\wamp64\logs\mysql*.log`
- **Laragon**: `C:\laragon\bin\mysql\mysql-*\data\*.err`

---

### 7. **Test Koneksi MySQL Manual**

Coba koneksi MySQL melalui Command Prompt:

```bash
# Masuk ke direktori MySQL
cd C:\xampp\mysql\bin

# Coba koneksi
mysql -u root -p
# Tekan Enter jika password kosong
```

Jika berhasil, berarti MySQL berjalan dengan baik, masalahnya di phpMyAdmin.
Jika gagal, berarti MySQL service tidak berjalan atau konfigurasi salah.

---

### 8. **Reinstall/Repair MySQL Service (Jika Semua Gagal)**

Jika semua langkah di atas tidak berhasil:

1. **Backup data** (jika ada)
2. **Uninstall** MySQL service
3. **Reinstall** MySQL service
4. Atau **Repair** instalasi XAMPP/WAMP/Laragon

---

## Solusi Cepat (Paling Umum)

**90% masalah ini disebabkan MySQL service tidak berjalan.**

1. ✅ Buka **XAMPP Control Panel** (atau WAMP/Laragon)
2. ✅ Klik **Start** pada **MySQL**
3. ✅ Tunggu hingga status **Running** (hijau)
4. ✅ Refresh browser phpMyAdmin
5. ✅ Selesai!

---

## Tips Tambahan

- **Jangan tutup XAMPP Control Panel** saat menggunakan phpMyAdmin
- **Pastikan Apache juga Running** jika menggunakan XAMPP/WAMP
- **Gunakan browser yang berbeda** jika masih error (Chrome, Firefox, Edge)
- **Clear cache browser** jika perlu

---

## Jika Masih Bermasalah

1. Screenshot error message yang muncul
2. Cek status MySQL di Control Panel
3. Cek file error log MySQL
4. Hubungi support atau cari solusi spesifik untuk versi XAMPP/WAMP/Laragon Anda

---

**Catatan**: File SQL `perpustakaan.sql` sudah siap digunakan. Setelah phpMyAdmin bisa dibuka, import file tersebut melalui menu **Import** di phpMyAdmin.

