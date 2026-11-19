$ErrorActionPreference = "Stop"
$ProgressPreference = "SilentlyContinue"

$sourceDir = "c:\xampp\htdocs\e-catering-master"
$packageDir = "$sourceDir\build_infinityfree"
$zipFile = "$sourceDir\sekalori_infinityfree.zip"

Write-Host "1. Membersihkan folder build lama..."
if (Test-Path $packageDir) { Remove-Item -Recurse -Force $packageDir }
if (Test-Path $zipFile) { Remove-Item -Force $zipFile }

New-Item -ItemType Directory -Path "$packageDir\core" | Out-Null

Write-Host "2. Menyalin folder backend ke core/..."
$coreItems = @('app', 'bootstrap', 'config', 'database', 'resources', 'routes', 'storage', 'vendor', 'artisan', 'composer.json')
foreach ($item in $coreItems) {
    $src = "$sourceDir\$item"
    if (Test-Path $src) {
        Write-Host "   -> Menyalin $item..."
        Copy-Item -Path $src -Destination "$packageDir\core\$item" -Recurse -Force
    }
}

# Membersihkan cache lokal agar tidak ada path Windows absolut
Write-Host "3. Membersihkan cache Windows lokal..."
Get-ChildItem -Path "$packageDir\core\bootstrap\cache\*.php" -ErrorAction SilentlyContinue | Remove-Item -Force
Get-ChildItem -Path "$packageDir\core\storage\framework\views\*.php" -ErrorAction SilentlyContinue | Remove-Item -Force
Get-ChildItem -Path "$packageDir\core\storage\framework\cache\data\*" -ErrorAction SilentlyContinue | Remove-Item -Recurse -Force
Get-ChildItem -Path "$packageDir\core\storage\framework\sessions\*" -Exclude '.gitignore' -ErrorAction SilentlyContinue | Remove-Item -Force

# Pastikan folder storage tetap ada strukturnya
$storageDirs = @(
    "$packageDir\core\storage\app\public",
    "$packageDir\core\storage\framework\cache\data",
    "$packageDir\core\storage\framework\sessions",
    "$packageDir\core\storage\framework\views",
    "$packageDir\core\storage\logs",
    "$packageDir\core\bootstrap\cache"
)
foreach ($d in $storageDirs) {
    if (!(Test-Path $d)) { New-Item -ItemType Directory -Path $d -Force | Out-Null }
}

Write-Host "4. Menyalin aset publik ke root htdocs..."
$publicItems = @('assets', 'css', 'js', '.htaccess', 'robots.txt')
foreach ($item in $publicItems) {
    $src = "$sourceDir\public\$item"
    if (Test-Path $src) {
        Write-Host "   -> Menyalin $item..."
        Copy-Item -Path $src -Destination "$packageDir\$item" -Recurse -Force
    }
}

Write-Host "5. Membuat index.php khusus InfinityFree..."
$indexContent = @'
<?php

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

if (file_exists($maintenance = __DIR__.'/core/storage/framework/maintenance.php')) {
    require $maintenance;
}

require __DIR__.'/core/vendor/autoload.php';

$app = require_once __DIR__.'/core/bootstrap/app.php';

// Menyesuaikan public_path ke root htdocs
$app->bind('path.public', function() {
    return __DIR__;
});

$kernel = $app->make(Kernel::class);

$response = $kernel->handle(
    $request = Request::capture()
)->send();

$kernel->terminate($request, $response);
'@

[System.IO.File]::WriteAllText("$packageDir\index.php", $indexContent, [System.Text.Encoding]::UTF8)

# Template .env untuk InfinityFree
$envTemplate = @'
APP_NAME=Sekalori
APP_ENV=production
APP_KEY=base64:XG8d2Lq1m3o9Z9kL4jP5wR8tY1uI3oP5aS7dF9gH1jK=
APP_DEBUG=false
APP_URL=http://YOUR_SUBDOMAIN.infinityfreeapp.com

LOG_CHANNEL=stack
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=debug

DB_CONNECTION=mysql
DB_HOST=sqlxxx.infinityfree.com
DB_PORT=3306
DB_DATABASE=epiz_xxxxxxx_ecatering
DB_USERNAME=epiz_xxxxxxx
DB_PASSWORD=YOUR_CPANEL_PASSWORD

BROADCAST_DRIVER=log
CACHE_DRIVER=file
FILESYSTEM_DISK=local
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
SESSION_LIFETIME=120
'@
[System.IO.File]::WriteAllText("$packageDir\core\.env", $envTemplate, [System.Text.Encoding]::UTF8)

Write-Host "6. Mengompresi menjadi sekalori_infinityfree.zip..."
Compress-Archive -Path "$packageDir\*" -DestinationPath $zipFile -Force

$mb = [math]::Round((Get-Item $zipFile).Length / 1MB, 2)
Write-Host "=========================================="
Write-Host "SUKSES! File zip siap di-upload:"
Write-Host "$zipFile ($mb MB)"
Write-Host "=========================================="
