<?php
/**
 * ROAMIE RENTCAR — Database Debugger and repair script
 * Upload file ini ke: public_html/roamie/public/auth_debug.php
 * Akses via browser: https://roamie.zytraxo.com/auth_debug.php
 * !! HAPUS FILE INI SETELAH SELESAI DIGUNAKAN !!
 */

// Kunci keamanan
$secret = 'roamie-debug-2026';

if (!isset($_GET['key']) || $_GET['key'] !== $secret) {
    http_response_code(403);
    die('<h2>403 — Akses ditolak.</h2>');
}

// Bootstrap Laravel
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Artisan;

header('Content-Type: text/plain');

echo "=== ROAMIE DATABASE DIAGNOSTIC ===\n\n";

try {
    // Check DB Connection info
    $connection = DB::getDefaultConnection();
    echo "Default DB Connection: " . $connection . "\n";
    
    if ($connection === 'mysql') {
        echo "DB Host: " . config('database.connections.mysql.host') . "\n";
        echo "DB Database: " . config('database.connections.mysql.database') . "\n";
        echo "DB Username: " . config('database.connections.mysql.username') . "\n";
    } else if ($connection === 'sqlite') {
        echo "SQLite Database File: " . config('database.connections.sqlite.database') . "\n";
    }

    // Check action parameter
    $action = $_GET['action'] ?? null;
    if ($action === 'migrate') {
        echo "\n[INFO] Running database migrations...\n";
        Artisan::call('migrate', ['--force' => true]);
        echo "Migration Output:\n";
        echo Artisan::output() . "\n";
        echo "[INFO] Migrations finished!\n\n";
    }

    // Try a simple query
    $userCount = User::count();
    echo "Total Users in DB: " . $userCount . "\n\n";

    // Check columns
    $columns = Schema::getColumnListing('users');
    echo "Users Columns: " . implode(', ', $columns) . "\n\n";

    // Check specific users
    $targetEmails = ['admin@roamie.com', 'customer@gmail.com', 'testcustomer@gmail.com'];
    
    foreach ($targetEmails as $email) {
        $user = User::where('email', $email)->first();
        if ($user) {
            echo "User found: {$user->name} ({$user->email})\n";
            echo "  Role: {$user->role}\n";
            echo "  Password Hash: {$user->password}\n";
            
            // Check if password matches 'password'
            $matchesDefault = Hash::check('password', $user->password);
            $matchesProdPass = Hash::check('password123', $user->password);
            
            echo "  Matches 'password': " . ($matchesDefault ? "YES" : "NO") . "\n";
            echo "  Matches 'password123': " . ($matchesProdPass ? "YES" : "NO") . "\n";
            
            // If they don't match either, let's fix it!
            if (!$matchesDefault && !$matchesProdPass) {
                echo "  -> Repairing password: resetting to 'password'...";
                $user->password = Hash::make('password');
                $user->save();
                echo " FIXED!\n";
            }
        } else {
            echo "User NOT found: {$email}\n";
            if ($email === 'customer@gmail.com') {
                echo "  -> Creating user: customer@gmail.com with password 'password'...";
                User::create([
                    'name' => 'John Doe',
                    'email' => 'customer@gmail.com',
                    'password' => Hash::make('password'),
                    'role' => 'customer'
                ]);
                echo " CREATED!\n";
            } else if ($email === 'admin@roamie.com') {
                echo "  -> Creating user: admin@roamie.com with password 'password'...";
                User::create([
                    'name' => 'Admin Roamie',
                    'email' => 'admin@roamie.com',
                    'password' => Hash::make('password'),
                    'role' => 'admin'
                ]);
                echo " CREATED!\n";
            }
        }
        echo "\n";
    }

} catch (\Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo $e->getTraceAsString() . "\n";
}
