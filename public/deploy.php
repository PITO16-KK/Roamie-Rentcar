<?php
/**
 * ============================================================
 * ROAMIE RENTCAR — cPanel Deployment Helper
 * Upload file ini ke: public_html/roamie/public/deploy.php
 * Akses via browser: https://roamie.zytraxo.com/deploy.php
 * !! HAPUS FILE INI SETELAH SELESAI DIGUNAKAN !!
 * ============================================================
 */

// Kunci keamanan — ganti dengan string random Anda
$secret = 'roamie-deploy-2026';

if (!isset($_GET['key']) || $_GET['key'] !== $secret) {
    http_response_code(403);
    die('<h2>403 — Akses ditolak. Tambahkan ?key=roamie-deploy-2026 ke URL.</h2>');
}

// Bootstrap Laravel
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$output = [];

// Jalankan perintah artisan
$commands = [
    ['optimize:clear',   []],
    ['migrate',          ['--force' => true]],
    ['storage:link',     []],
    ['config:cache',     []],
    ['route:cache',      []],
    ['view:cache',       []],
];

echo '<!DOCTYPE html><html><head><meta charset="UTF-8">
<title>ROAMIE Deploy Helper</title>
<style>
  body { font-family: monospace; background: #0b111e; color: #f8fafc; padding: 2rem; }
  h1 { color: #a855f7; margin-bottom: 1.5rem; }
  .step { background: #1e293b; border-radius: 8px; padding: 1rem; margin-bottom: 1rem; }
  .ok { color: #10b981; font-weight: bold; }
  .err { color: #ef4444; font-weight: bold; }
  pre { white-space: pre-wrap; margin-top: 0.5rem; color: #94a3b8; font-size: 0.85rem; }
  .warning { background: rgba(245,158,11,0.1); border: 1px solid #f59e0b; border-radius: 8px; padding: 1rem; margin-top: 2rem; color: #f59e0b; }
</style></head><body>';
echo '<h1>🚀 ROAMIE Rentcar — Deployment ke cPanel</h1>';

foreach ($commands as [$cmd, $params]) {
    $buf = new \Symfony\Component\Console\Output\BufferedOutput();
    try {
        $code = \Illuminate\Support\Facades\Artisan::call($cmd, $params);
        $result = \Illuminate\Support\Facades\Artisan::output();
        echo '<div class="step">';
        echo '<span class="ok">✅ php artisan ' . $cmd . '</span>';
        echo '<pre>' . htmlspecialchars(trim($result)) . '</pre>';
        echo '</div>';
    } catch (\Exception $e) {
        echo '<div class="step">';
        echo '<span class="err">❌ php artisan ' . $cmd . ' — GAGAL</span>';
        echo '<pre>' . htmlspecialchars($e->getMessage()) . '</pre>';
        echo '</div>';
    }
}

echo '<div class="warning">
  <strong>⚠️ PERINGATAN KEAMANAN:</strong><br>
  Segera hapus file <code>public/deploy.php</code> ini setelah selesai digunakan!
</div>';
echo '</body></html>';
