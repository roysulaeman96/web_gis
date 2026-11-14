# ============================================================
# Script Fix MySQL XAMPP - InnoDB Recovery
# Jalankan sebagai Administrator!
# ============================================================

Write-Host "========================================" -ForegroundColor Cyan
Write-Host "  Fix MySQL XAMPP - InnoDB Recovery" -ForegroundColor Cyan
Write-Host "========================================" -ForegroundColor Cyan

$myIniPath   = "C:\xampp\mysql\bin\my.ini"
$dataDir     = "C:\xampp\mysql\data"
$mysqldPath  = "C:\xampp\mysql\bin\mysqld.exe"
$mysqldump   = "C:\xampp\mysql\bin\mysqldump.exe"
$backupPath  = "C:\xampp\htdocs\web_gis\backup_recovery_$(Get-Date -Format 'yyyyMMdd_HHmmss').sql"

# ---- Step 1: Stop MySQL jika masih running ----
Write-Host "`n[1/6] Menghentikan MySQL..." -ForegroundColor Yellow
Stop-Process -Name "mysqld" -Force -ErrorAction SilentlyContinue
Start-Sleep -Seconds 2
Write-Host "     MySQL dihentikan." -ForegroundColor Green

# ---- Step 2: Tambah innodb_force_recovery=1 ke my.ini ----
Write-Host "`n[2/6] Menambahkan innodb_force_recovery=1 ke my.ini..." -ForegroundColor Yellow
$content = Get-Content $myIniPath -Raw

if ($content -notmatch "innodb_force_recovery") {
    $content = $content -replace "innodb_data_home_dir", "innodb_force_recovery=1`ninnodb_data_home_dir"
    Set-Content $myIniPath -Value $content -Encoding UTF8
    Write-Host "     Berhasil ditambahkan." -ForegroundColor Green
} else {
    Write-Host "     innodb_force_recovery sudah ada, skip." -ForegroundColor Gray
}

# ---- Step 3: Start MySQL dengan recovery mode ----
Write-Host "`n[3/6] Menjalankan MySQL dalam recovery mode..." -ForegroundColor Yellow
Start-Process -FilePath $mysqldPath -ArgumentList "--defaults-file=`"$myIniPath`"" -WindowStyle Hidden
Start-Sleep -Seconds 5

$mysqlRunning = Get-Process -Name "mysqld" -ErrorAction SilentlyContinue
if ($mysqlRunning) {
    Write-Host "     MySQL berhasil start!" -ForegroundColor Green
} else {
    Write-Host "     MySQL gagal start dengan recovery=1. Mencoba recovery=2..." -ForegroundColor Red
    $content = $content -replace "innodb_force_recovery=1", "innodb_force_recovery=2"
    Set-Content $myIniPath -Value $content -Encoding UTF8
    Start-Process -FilePath $mysqldPath -ArgumentList "--defaults-file=`"$myIniPath`"" -WindowStyle Hidden
    Start-Sleep -Seconds 5
}

# ---- Step 4: Backup database ----
Write-Host "`n[4/6] Backup database db_web_gis..." -ForegroundColor Yellow
$mysqlRunning = Get-Process -Name "mysqld" -ErrorAction SilentlyContinue
if ($mysqlRunning) {
    & $mysqldump --port=3307 -u root db_web_gis | Out-File -FilePath $backupPath -Encoding UTF8
    if (Test-Path $backupPath) {
        $size = (Get-Item $backupPath).Length / 1KB
        Write-Host "     Backup berhasil: $backupPath ($([math]::Round($size,1)) KB)" -ForegroundColor Green
    } else {
        Write-Host "     Backup gagal!" -ForegroundColor Red
    }
} else {
    Write-Host "     MySQL tidak running, backup dilewati." -ForegroundColor Red
}

# ---- Step 5: Stop MySQL, hapus InnoDB log lama ----
Write-Host "`n[5/6] Menghapus InnoDB log lama dan reset recovery mode..." -ForegroundColor Yellow
Stop-Process -Name "mysqld" -Force -ErrorAction SilentlyContinue
Start-Sleep -Seconds 3

$logFiles = @("$dataDir\ib_logfile0", "$dataDir\ib_logfile1")
foreach ($f in $logFiles) {
    if (Test-Path $f) {
        Remove-Item $f -Force
        Write-Host "     Dihapus: $f" -ForegroundColor Green
    }
}

# Hapus innodb_force_recovery dari my.ini
$content = Get-Content $myIniPath -Raw
$content = $content -replace "innodb_force_recovery=\d+`n", ""
$content = $content -replace "innodb_force_recovery=\d+\r\n", ""
Set-Content $myIniPath -Value $content -Encoding UTF8
Write-Host "     innodb_force_recovery dihapus dari my.ini." -ForegroundColor Green

# ---- Step 6: Start MySQL normal ----
Write-Host "`n[6/6] Menjalankan MySQL normal..." -ForegroundColor Yellow
Start-Process -FilePath $mysqldPath -ArgumentList "--defaults-file=`"$myIniPath`"" -WindowStyle Hidden
Start-Sleep -Seconds 5

$mysqlRunning = Get-Process -Name "mysqld" -ErrorAction SilentlyContinue
if ($mysqlRunning) {
    Write-Host "`n========================================" -ForegroundColor Green
    Write-Host "  MySQL berhasil berjalan normal!" -ForegroundColor Green
    Write-Host "  Buka: http://localhost/web_gis/public" -ForegroundColor Green
    Write-Host "========================================" -ForegroundColor Green
} else {
    Write-Host "`n[ERROR] MySQL masih gagal start. Cek log di:" -ForegroundColor Red
    Write-Host "  $dataDir\mysql_error.log" -ForegroundColor Red
}

Read-Host "`nTekan Enter untuk keluar"
