<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;

$users = User::all();
foreach ($users as $user) {
    echo "User: {$user->name} ({$user->email})\n";
    echo "  Hash: " . $user->getAuthPassword() . "\n";
    
    // Test some candidate passwords
    $candidates = ['password', '12345678', 'password123', 'customer', 'customer123', 'admin', 'admin123'];
    foreach ($candidates as $cand) {
        if (Hash::check($cand, $user->getAuthPassword())) {
            echo "  MATCH FOUND: '$cand'\n";
        }
    }
}
