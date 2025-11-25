# Script untuk mengecek status MySQL Service di Windows
# Jalankan dengan: PowerShell -ExecutionPolicy Bypass -File "cek_mysql_service.ps1"

Write-Host "========================================" -ForegroundColor Cyan
Write-Host "   CEK STATUS MYSQL SERVICE" -ForegroundColor Cyan
Write-Host "========================================" -ForegroundColor Cyan
Write-Host ""

# Cek service MySQL
$mysqlServices = @("MySQL", "MySQL80", "MySQL57", "MariaDB", "mysql")

Write-Host "Mencari MySQL Service..." -ForegroundColor Yellow
Write-Host ""

$found = $false

foreach ($serviceName in $mysqlServices) {
    $service = Get-Service -Name $serviceName -ErrorAction SilentlyContinue
    if ($service) {
        $found = $true
        Write-Host "Service ditemukan: $serviceName" -ForegroundColor Green
        Write-Host "Status: " -NoNewline
        
        if ($service.Status -eq "Running") {
            Write-Host "RUNNING" -ForegroundColor Green
        } else {
            Write-Host "STOPPED" -ForegroundColor Red
            Write-Host ""
            Write-Host "Service tidak berjalan! Ingin menjalankan sekarang? (Y/N): " -NoNewline -ForegroundColor Yellow
            $response = Read-Host
            if ($response -eq "Y" -or $response -eq "y") {
                try {
                    Start-Service -Name $serviceName
                    Write-Host "Service berhasil dijalankan!" -ForegroundColor Green
                } catch {
                    Write-Host "Gagal menjalankan service. Coba jalankan sebagai Administrator." -ForegroundColor Red
                }
            }
        }
        Write-Host ""
        break
    }
}

if (-not $found) {
    Write-Host "MySQL Service tidak ditemukan!" -ForegroundColor Red
    Write-Host ""
    Write-Host "Coba cek manual di Services (services.msc)" -ForegroundColor Yellow
    Write-Host "Atau pastikan XAMPP/WAMP/Laragon sudah terinstall." -ForegroundColor Yellow
}

Write-Host ""
Write-Host "========================================" -ForegroundColor Cyan
Write-Host "   CEK PORT 3306" -ForegroundColor Cyan
Write-Host "========================================" -ForegroundColor Cyan
Write-Host ""

# Cek port 3306
$port3306 = Get-NetTCPConnection -LocalPort 3306 -ErrorAction SilentlyContinue

if ($port3306) {
    Write-Host "Port 3306 sedang digunakan" -ForegroundColor Green
    Write-Host "State: $($port3306.State)" -ForegroundColor Cyan
} else {
    Write-Host "Port 3306 tidak digunakan (MySQL mungkin tidak berjalan)" -ForegroundColor Red
}

Write-Host ""
Write-Host "========================================" -ForegroundColor Cyan
Write-Host "   CEK XAMPP/WAMP/LARAGON" -ForegroundColor Cyan
Write-Host "========================================" -ForegroundColor Cyan
Write-Host ""

# Cek XAMPP
if (Test-Path "C:\xampp\mysql\bin\mysqld.exe") {
    Write-Host "XAMPP ditemukan di: C:\xampp" -ForegroundColor Green
}

# Cek WAMP
if (Test-Path "C:\wamp64\bin\mysql\mysql*\bin\mysqld.exe") {
    Write-Host "WAMP ditemukan di: C:\wamp64" -ForegroundColor Green
}

# Cek Laragon
if (Test-Path "C:\laragon\bin\mysql\mysql*\bin\mysqld.exe") {
    Write-Host "Laragon ditemukan di: C:\laragon" -ForegroundColor Green
}

Write-Host ""
Write-Host "Tekan Enter untuk keluar..."
Read-Host

