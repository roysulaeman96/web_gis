# ============================================================
# Script Fix MySQL XAMPP v2 - Full InnoDB Reset + Restore
# Jalankan sebagai Administrator!
# ============================================================

Write-Host "========================================" -ForegroundColor Cyan
Write-Host "  Fix MySQL XAMPP v2 - Full Reset" -ForegroundColor Cyan
Write-Host "========================================" -ForegroundColor Cyan

$myIniPath  = "C:\xampp\mysql\bin\my.ini"
$dataDir    = "C:\xampp\mysql\data"
$mysqld     = "C:\xampp\mysql\bin\mysqld.exe"
$mysql      = "C:\xampp\mysql\bin\mysql.exe"
$mysqldump  = "C:\xampp\mysql\bin\mysqldump.exe"
$backupSql  = "C:\xampp\htdocs\web_gis\bakcup_db_web_gis_03052026.sql"

# ---- Step 1: Matikan MySQL ----
Write-Host "`n[1/7] Menghentikan semua proses MySQL..." -ForegroundColor Yellow
Stop-Process -Name "mysqld" -Force -ErrorAction SilentlyContinue
Start-Sleep -Seconds 3
Write-Host "     Selesai." -ForegroundColor Green

# ---- Step 2: Backup folder data asli ----
Write-Host "`n[2/7] Backup folder data MySQL ke data_backup_lama..." -ForegroundColor Yellow
$backupDir = "C:\xampp\mysql\data_backup_lama"
if (-not (Test-Path $backupDir)) {
    Copy-Item -Recurse -Force $dataDir $backupDir
    Write-Host "     Backup berhasil ke: $backupDir" -ForegroundColor Green
} else {
    Write-Host "     Backup sudah ada, skip." -ForegroundColor Gray
}

# ---- Step 3: Hapus file InnoDB yang rusak ----
Write-Host "`n[3/7] Menghapus file InnoDB yang rusak..." -ForegroundColor Yellow
$filesToDelete = @(
    "$dataDir\ibdata1",
    "$dataDir\ib_logfile0",
    "$dataDir\ib_logfile1",
    "$dataDir\ibtmp1",
    "$dataDir\ib_buffer_pool",
    "$dataDir\mysql.pid"
)
foreach ($f in $filesToDelete) {
    if (Test-Path $f) {
        Remove-Item $f -Force
        Write-Host "     Dihapus: $f" -ForegroundColor Green
    }
}

# Pastikan innodb_force_recovery tidak ada di my.ini
Write-Host "`n[4/7] Membersihkan my.ini dari recovery mode..." -ForegroundColor Yellow
$content = Get-Content $myIniPath -Raw
$content = $content -replace "innodb_force_recovery=\d+\r?\n", ""
Set-Content $myIniPath -Value $content -Encoding UTF8
Write-Host "     my.ini bersih." -ForegroundColor Green

# ---- Step 5: Start MySQL fresh ----
Write-Host "`n[5/7] Menjalankan MySQL fresh..." -ForegroundColor Yellow
Start-Process -FilePath $mysqld -ArgumentList "--defaults-file=`"$myIniPath`"" -WindowStyle Hidden
Write-Host "     Menunggu MySQL siap (15 detik)..." -ForegroundColor Gray
Start-Sleep -Seconds 15

$mysqlRunning = Get-Process -Name "mysqld" -ErrorAction SilentlyContinue
if (-not $mysqlRunning) {
    Write-Host "[ERROR] MySQL gagal start. Cek log: $dataDir\mysql_error.log" -ForegroundColor Red
    Read-Host "Tekan Enter untuk keluar"
    exit 1
}
Write-Host "     MySQL berhasil start!" -ForegroundColor Green

# ---- Step 6: Buat database dan restore ----
Write-Host "`n[6/7] Membuat database db_web_gis dan restore data..." -ForegroundColor Yellow
$createDb = "CREATE DATABASE IF NOT EXISTS db_web_gis CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;"
& $mysql --port=3307 -u root -e $createDb
if ($LASTEXITCODE -eq 0) {
    Write-Host "     Database db_web_gis dibuat." -ForegroundColor Green
} else {
    Write-Host "     Gagal buat database!" -ForegroundColor Red
    Read-Host "Tekan Enter untuk keluar"
    exit 1
}

if (Test-Path $backupSql) {
    Write-Host "     Merestore dari: $backupSql" -ForegroundColor Gray
    Get-Content $backupSql | & $mysql --port=3307 -u root db_web_gis
    if ($LASTEXITCODE -eq 0) {
        Write-Host "     Restore berhasil!" -ForegroundColor Green
    } else {
        Write-Host "     Restore gagal! Coba import manual lewat phpMyAdmin." -ForegroundColor Red
    }
} else {
    Write-Host "     File backup tidak ditemukan: $backupSql" -ForegroundColor Red
    Write-Host "     Import manual lewat phpMyAdmin." -ForegroundColor Yellow
}

# ---- Step 7: Selesai ----
Write-Host "`n[7/7] Verifikasi koneksi..." -ForegroundColor Yellow
$testConn = & $mysql --port=3307 -u root -e "SHOW DATABASES;" 2>&1
if ($testConn -match "db_web_gis") {
    Write-Host "`n========================================" -ForegroundColor Green
    Write-Host "  SUKSES! MySQL berjalan normal." -ForegroundColor Green
    Write-Host "  Database db_web_gis siap digunakan." -ForegroundColor Green
    Write-Host "  Buka: http://localhost/web_gis/public" -ForegroundColor Green
    Write-Host "========================================" -ForegroundColor Green
} else {
    Write-Host "`n  MySQL running tapi database belum restore." -ForegroundColor Yellow
    Write-Host "  Import manual: buka phpMyAdmin -> import $backupSql" -ForegroundColor Yellow
}

Read-Host "`nTekan Enter untuk keluar"
