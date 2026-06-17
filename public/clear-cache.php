<?php
/**
 * ROAMIE - Temporary Cache Cleaner
 * DELETE THIS FILE AFTER USE!
 */

// Security: only allow from specific path
define('BASE_PATH', dirname(__DIR__));

$results = [];

// 1. Clear compiled Blade views
$viewCachePath = BASE_PATH . '/storage/framework/views';
if (is_dir($viewCachePath)) {
    $files = glob($viewCachePath . '/*.php');
    $count = 0;
    foreach ($files as $file) {
        if (unlink($file)) $count++;
    }
    $results[] = "✅ Blade views cache cleared: {$count} files deleted";
} else {
    $results[] = "⚠️ View cache directory not found: {$viewCachePath}";
}

// 2. Clear config cache
$configCache = BASE_PATH . '/bootstrap/cache/config.php';
if (file_exists($configCache)) {
    unlink($configCache);
    $results[] = "✅ Config cache cleared";
} else {
    $results[] = "ℹ️ No config cache found (OK)";
}

// 3. Clear route cache
$routeCache = BASE_PATH . '/bootstrap/cache/routes-v7.php';
if (file_exists($routeCache)) {
    unlink($routeCache);
    $results[] = "✅ Route cache cleared";
} else {
    // Try other route cache filenames
    $routeFiles = glob(BASE_PATH . '/bootstrap/cache/routes*.php');
    foreach ($routeFiles as $rf) {
        unlink($rf);
    }
    $results[] = "ℹ️ Route cache: " . (count($routeFiles) > 0 ? count($routeFiles) . " file(s) cleared" : "nothing to clear");
}

// 4. Clear event cache
$eventsCache = BASE_PATH . '/bootstrap/cache/events.php';
if (file_exists($eventsCache)) {
    unlink($eventsCache);
    $results[] = "✅ Events cache cleared";
}

// 5. Check Midtrans service exists
$midtransService = BASE_PATH . '/app/Services/MidtransService.php';
$results[] = file_exists($midtransService)
    ? "✅ MidtransService.php found"
    : "❌ MidtransService.php NOT FOUND";

// 6. Check Rental model cast
$rentalModel = BASE_PATH . '/app/Models/Rental.php';
if (file_exists($rentalModel)) {
    $content = file_get_contents($rentalModel);
    $results[] = str_contains($content, "'duration_days' => 'integer'")
        ? "✅ Rental model: duration_days cast OK"
        : "❌ Rental model: duration_days cast MISSING";
} else {
    $results[] = "❌ Rental.php NOT FOUND";
}

// 7. Check profile.blade.php fix
$profileView = BASE_PATH . '/resources/views/profile.blade.php';
if (file_exists($profileView)) {
    $content = file_get_contents($profileView);
    $results[] = str_contains($content, "(int) \$rental->duration_days")
        ? "✅ profile.blade.php: (int) cast OK"
        : "❌ profile.blade.php: (int) cast MISSING";
} else {
    $results[] = "❌ profile.blade.php NOT FOUND";
}

// 8. Check payment-finish.blade.php
$finishView = BASE_PATH . '/resources/views/payment-finish.blade.php';
$results[] = file_exists($finishView)
    ? "✅ payment-finish.blade.php found"
    : "❌ payment-finish.blade.php NOT FOUND";

// 9. Check config/midtrans.php
$midtransConfig = BASE_PATH . '/config/midtrans.php';
$results[] = file_exists($midtransConfig)
    ? "✅ config/midtrans.php found"
    : "❌ config/midtrans.php NOT FOUND";

// 10. Check vendor/midtrans
$vendorMidtrans = BASE_PATH . '/vendor/midtrans';
$results[] = is_dir($vendorMidtrans)
    ? "✅ vendor/midtrans SDK found"
    : "❌ vendor/midtrans SDK NOT FOUND (run composer require midtrans/midtrans-php)";

?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>ROAMIE - Cache Cleaner</title>
<style>
  body { font-family: monospace; background: #1a1a2e; color: #e0e0e0; padding: 2rem; }
  h1 { color: #e94560; }
  .result { margin: 0.4rem 0; padding: 0.5rem 1rem; border-radius: 6px; background: #16213e; font-size: 1rem; }
  .warn { background: #2d2d1e; color: #ffcc00; padding: 1rem; margin-top: 2rem; border-radius: 8px; border-left: 4px solid #ffcc00; }
</style>
</head>
<body>
<h1>🔧 ROAMIE Cache Cleaner</h1>
<p>Running checks and clearing cache...</p>
<?php foreach ($results as $r): ?>
<div class="result"><?= htmlspecialchars($r) ?></div>
<?php endforeach; ?>
<div class="warn">
  ⚠️ <strong>IMPORTANT:</strong> Hapus file ini setelah selesai!<br>
  Delete: <code>/public_html/roamie-rentcar/public/clear-cache.php</code>
</div>
</body>
</html>
