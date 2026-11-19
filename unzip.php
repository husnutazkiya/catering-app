<?php
ini_set('max_execution_time', 300);
ini_set('memory_limit', '256M');

$zipFile = __DIR__ . '/sekalori_infinityfree.zip';

if (!file_exists($zipFile)) {
    die("Error: File 'sekalori_infinityfree.zip' tidak ditemukan di folder ini! Pastikan sudah di-upload ke /htdocs.");
}

$zip = new ZipArchive;
if ($zip->open($zipFile) === TRUE) {
    $zip->extractTo(__DIR__);
    $zip->close();
    
    // Pastikan file .env ada jika sistem Linux menyembunyikannya
    if (!file_exists(__DIR__ . '/core/.env') && file_exists(__DIR__ . '/core/env.txt')) {
        copy(__DIR__ . '/core/env.txt', __DIR__ . '/core/.env');
    }
    if (!file_exists(__DIR__ . '/.env') && file_exists(__DIR__ . '/env.txt')) {
        copy(__DIR__ . '/env.txt', __DIR__ . '/.env');
    }
    
    echo "<div style='font-family: Arial; padding: 25px; border: 2px solid #22714e; border-radius: 10px; max-width: 600px; margin: 40px auto; background: #eaf5ee;'>";
    echo "<h2 style='color: #22714e; margin-top: 0;'> Berhasil Diekstrak 100%!</h2>";
    echo "<p style='color: #333;'>Seluruh file proyek Sekalori (folder <b>core</b>, <b>assets</b>, file <b>index.php</b>, dan file <b>.env</b>) telah lengkap terekstrak ke server.</p>";
    echo "<p style='color: #666;'>Langkah selanjutnya: silakan hapus file <code>sekalori_infinityfree.zip</code> dan <code>unzip.php</code> ini, lalu hubungkan database Anda di <code>core/.env</code>.</p>";
    echo "</div>";
} else {
    echo "Gagal mengekstrak sekalori_infinityfree.zip. Pastikan file zip tidak korup saat upload.";
}

