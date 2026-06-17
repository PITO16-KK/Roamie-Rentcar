<?php
/**
 * ROAMIE - Fix Permissions Script
 * Run once, then DELETE this file!
 */

$basePath = dirname(__DIR__);
$fixed = 0;
$errors = [];

function fixPerms($path, &$fixed, &$errors) {
    if (is_dir($path)) {
        // Fix directory: 755
        if (!chmod($path, 0755)) {
            $errors[] = "chmod 755 failed: $path";
        } else {
            $fixed++;
        }
        $items = scandir($path);
        foreach ($items as $item) {
            if ($item === '.' || $item === '..') continue;
            fixPerms($path . '/' . $item, $fixed, $errors);
        }
    } elseif (is_file($path)) {
        // Fix file: 644
        if (!chmod($path, 0644)) {
            $errors[] = "chmod 644 failed: $path";
        } else {
            $fixed++;
        }
    }
}

// Fix vendor/midtrans permissions
$midtransVendor = $basePath . '/vendor/midtrans';
if (is_dir($midtransVendor)) {
    fixPerms($midtransVendor, $fixed, $errors);
}

// Fix vendor/composer (autoload files) permissions
$composerVendor = $basePath . '/vendor/composer';
if (is_dir($composerVendor)) {
    fixPerms($composerVendor, $fixed, $errors);
}

// Fix app/Services permissions
$services = $basePath . '/app/Services';
if (is_dir($services)) {
    fixPerms($services, $fixed, $errors);
}

// Fix app/Http/Controllers/Api permissions
$apiControllers = $basePath . '/app/Http/Controllers/Api';
if (is_dir($apiControllers)) {
    fixPerms($apiControllers, $fixed, $errors);
}

// Fix specific modified files
$specificFiles = [
    '/app/Models/Rental.php',
    '/app/Http/Controllers/Web/BookingController.php',
    '/app/Http/Controllers/Web/PaymentController.php',
    '/resources/views/profile.blade.php',
    '/resources/views/payment.blade.php',
    '/resources/views/payment-finish.blade.php',
    '/config/midtrans.php',
    '/routes/web.php',
    '/routes/api.php',
];

foreach ($specificFiles as $file) {
    $fullPath = $basePath . $file;
    if (file_exists($fullPath)) {
        if (chmod($fullPath, 0644)) {
            $fixed++;
        } else {
            $errors[] = "Failed: $fullPath";
        }
    }
}

// Also clear Blade cache
$viewCache = $basePath . '/storage/framework/views';
$cleared = 0;
if (is_dir($viewCache)) {
    $views = glob($viewCache . '/*.php');
    foreach ($views as $view) {
        if (unlink($view)) $cleared++;
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>ROAMIE - Fix Permissions</title>
<style>
  body { font-family: monospace; background: #1a1a2e; color: #e0e0e0; padding: 2rem; max-width: 800px; margin: auto; }
  h1 { color: #e94560; }
  .ok { color: #00d2d3; margin: 0.3rem 0; }
  .err { color: #ff6b6b; margin: 0.3rem 0; background: #2d1e1e; padding: 0.3rem 0.8rem; border-radius: 4px; }
  .info { background: #0f3460; padding: 1rem 1.5rem; border-radius: 8px; margin: 1.5rem 0; }
  .warn { background: #2d2d1e; color: #ffcc00; padding: 1rem; margin-top: 1.5rem; border-radius: 8px; border-left: 4px solid #ffcc00; }
  .done { background: #0d2e1e; color: #00ff87; padding: 1rem 1.5rem; border-radius: 8px; margin: 1rem 0; font-size: 1.1rem; }
</style>
</head>
<body>
<h1>🔧 ROAMIE Permission Fixer</h1>

<div class="info">
  <strong>Status:</strong><br>
  ✅ Files/Dirs fixed: <strong><?= $fixed ?></strong><br>
  🗑️ Blade cache cleared: <strong><?= $cleared ?> views</strong><br>
  <?php if (empty($errors)): ?>
  ✅ No errors!
  <?php else: ?>
  ⚠️ <?= count($errors) ?> error(s):
  <?php foreach ($errors as $e): ?>
  <div class="err"><?= htmlspecialchars($e) ?></div>
  <?php endforeach; ?>
  <?php endif; ?>
</div>

<?php if (empty($errors) || count($errors) < 5): ?>
<div class="done">
  ✅ Permission fix selesai! Silakan coba booking mobil lagi.<br>
  <a href="https://roamie.zytraxo.com" style="color:#00d2d3;">→ Buka ROAMIE</a>
</div>
<?php endif; ?>

<div class="warn">
  ⚠️ <strong>PENTING:</strong> Hapus file ini setelah selesai!<br>
  Path: <code>/public_html/roamie-rentcar/public/fix-perms.php</code>
</div>
</body>
</html>
