<?php
/**
 * ROAMIE RENTCAR — Database Migration Helper untuk cPanel
 * Upload file ini ke: public_html/migrate-cpanel.php (folder yang sama dengan clear-cache.php)
 * Akses via browser: http://roamie.zytraxo.com/migrate-cpanel.php
 * !! HAPUS FILE INI SETELAH SELESAI DIGUNAKAN !!
 */

// Kunci keamanan
$secret = 'roamie-migrate-2026';

if (!isset($_GET['key']) || $_GET['key'] !== $secret) {
    echo '<!DOCTYPE html><html><head><title>Akses Ditolak</title></head><body style="font-family:monospace;background:#0f172a;color:#f8fafc;padding:2rem;">';
    echo '<h2>403 — Akses ditolak. Tambahkan ?key=roamie-migrate-2026 ke URL untuk keamanan.</h2>';
    echo '</body></html>';
    exit;
}

define('BASE_PATH', dirname(__DIR__));

// Bootstrap Laravel
if (!file_exists(BASE_PATH . '/vendor/autoload.php')) {
    // Jika struktur folder dipisah (roamie-core), sesuaikan path
    define('ALT_PATH', dirname(dirname(__DIR__)) . '/roamie-core');
    if (file_exists(ALT_PATH . '/vendor/autoload.php')) {
        require ALT_PATH . '/vendor/autoload.php';
        $app = require_once ALT_PATH . '/bootstrap/app.php';
    } else {
        die('Bootstrap Laravel tidak ditemukan. Pastikan path bootstrap benar.');
    }
} else {
    require BASE_PATH . '/vendor/autoload.php';
    $app = require_once BASE_PATH . '/bootstrap/app.php';
}

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo '<!DOCTYPE html><html><head><meta charset="UTF-8">
<title>ROAMIE DB Migrator</title>
<style>
  body { font-family: monospace; background: #0b111e; color: #f8fafc; padding: 2rem; }
  h1 { color: #6366f1; margin-bottom: 1.5rem; }
  .box { background: #1e293b; border-radius: 8px; padding: 1.5rem; border-left: 4px solid #6366f1; }
  pre { white-space: pre-wrap; color: #94a3b8; font-size: 0.9rem; margin: 0; }
  .warning { background: rgba(239,68,68,0.1); border: 1px solid #ef4444; border-radius: 8px; padding: 1rem; margin-top: 2rem; color: #ef4444; }
</style></head><body>';
echo '<h1>🚀 ROAMIE Rentcar — Database Migration</h1>';

try {
    echo '<div class="box">';
    echo '<strong>Menjalankan migrasi database...</strong><br><br>';
    
    \Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);
    $output = \Illuminate\Support\Facades\Artisan::output();
    
    echo '<pre>' . htmlspecialchars(trim($output)) . '</pre>';
    echo '<br><strong style="color:#10b981;">✅ Migrasi database berhasil dijalankan!</strong>';
    echo '</div>';
} catch (\Exception $e) {
    echo '<div class="box" style="border-left-color:#ef4444;">';
    echo '<strong style="color:#ef4444;">❌ Terjadi kesalahan saat migrasi database:</strong><br><br>';
    echo '<pre>' . htmlspecialchars($e->getMessage()) . '</pre>';
    echo '</div>';
}

echo '<div class="warning">
  <strong>⚠️ PERINGATAN KEAMANAN:</strong><br>
  Segera hapus file <code>migrate-cpanel.php</code> ini dari server cPanel Anda setelah sukses dijalankan!
</div>';
echo '</body></html>';
