<?php

use App\Http\Controllers\Web\AdminDashboardController;
use App\Http\Controllers\Web\CarController;
use App\Http\Controllers\Web\AuthController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('landing');
})->name('landing');

Route::get('/cars', [App\Http\Controllers\Web\CarCatalogController::class, 'index'])->name('catalog.index');

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::any('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

// Protected Customer Routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [App\Http\Controllers\Web\ProfileController::class, 'index'])->name('profile');
    Route::post('/profile/update', [App\Http\Controllers\Web\ProfileController::class, 'update'])->name('profile.update');
    Route::post('/cars/{id}/book', [App\Http\Controllers\Web\BookingController::class, 'book'])->name('booking.book');
    Route::get('/payment/finish', [App\Http\Controllers\Web\PaymentController::class, 'finish'])->name('payment.finish');
    Route::get('/payment/{rental_id}', [App\Http\Controllers\Web\PaymentController::class, 'show'])->name('payment.show');
    Route::post('/payment/{rental_id}/confirm', [App\Http\Controllers\Web\PaymentController::class, 'confirm'])->name('payment.confirm');
    Route::post('/chatbot', [App\Http\Controllers\ChatbotController::class, 'chat'])->name('chatbot.chat');
});

// Invoice route supports both web session and Sanctum token auth
Route::get('/payment/{rental_id}/invoice', [App\Http\Controllers\Web\PaymentController::class, 'invoice'])->name('payment.invoice');

Route::middleware(['auth', App\Http\Middleware\CheckAdmin::class])->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

    Route::prefix('admin')->name('admin.')->group(function () {
        Route::resource('cars', CarController::class);
        Route::get('/export/rentals', [App\Http\Controllers\Web\ExportController::class, 'exportRentals'])->name('export.rentals');
        
        // Verifikasi Pembayaran
        Route::get('/payments', [App\Http\Controllers\Web\PaymentVerificationController::class, 'index'])->name('payments.index');
        Route::post('/payments/{payment}/approve', [App\Http\Controllers\Web\PaymentVerificationController::class, 'approve'])->name('payments.approve');
        Route::post('/payments/{payment}/reject', [App\Http\Controllers\Web\PaymentVerificationController::class, 'reject'])->name('payments.reject');
    });
});

// Helper Route untuk menjalankan optimasi/cache langsung dari browser di cPanel
Route::get('/optimize-cpanel', function () {
    try {
        // Hapus folder/symlink storage lama di public jika ada (karena symlink dinonaktifkan oleh cPanel)
        // Ini memastikan Apache meneruskan request /storage ke Laravel router fallback
        $shortcut = public_path('storage');
        if (file_exists($shortcut) || is_link($shortcut)) {
            if (is_link($shortcut)) {
                @unlink($shortcut);
            } else {
                // Jika berupa direktori, hapus isinya lalu hapus direktorinya
                $files = new \RecursiveIteratorIterator(
                    new \RecursiveDirectoryIterator($shortcut, \RecursiveDirectoryIterator::SKIP_DOTS),
                    \RecursiveIteratorIterator::CHILD_FIRST
                );
                foreach ($files as $fileinfo) {
                    $todo = ($fileinfo->isDir() ? 'rmdir' : 'unlink');
                    @$todo($fileinfo->getRealPath());
                }
                @rmdir($shortcut);
            }
        }

        // Bersihkan cache lama terlebih dahulu
        \Illuminate\Support\Facades\Artisan::call('optimize:clear');
        
        // Buat cache rute, config, dan blade views untuk performa produksi terbaik
        \Illuminate\Support\Facades\Artisan::call('config:cache');
        \Illuminate\Support\Facades\Artisan::call('route:cache');
        \Illuminate\Support\Facades\Artisan::call('view:cache');
        
        return '<h3>🚀 Laravel Roamie Rentcar Berhasil Dioptimasi di cPanel!</h3>
                <p>Cache rute, konfigurasi .env, dan view blade telah dibuat langsung di server.</p>';
    } catch (\Exception $e) {
        return '<h3>❌ Terjadi kesalahan saat optimasi:</h3><pre>' . $e->getMessage() . '</pre>';
    }
});

// Helper Route untuk menjalankan migrasi database langsung dari browser di cPanel
Route::get('/migrate-cpanel', function () {
    try {
        // Jalankan migrasi database
        \Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);
        $output = \Illuminate\Support\Facades\Artisan::output();
        
        return '<h3>🚀 Migrasi Database Roamie Rentcar Berhasil Dijalankan di cPanel!</h3>
                <pre>' . nl2br(e($output)) . '</pre>';
    } catch (\Exception $e) {
        return '<h3>❌ Terjadi kesalahan saat migrasi database:</h3><pre>' . $e->getMessage() . '</pre>';
    }
});

// Helper Route untuk membaca log laravel di cPanel langsung dari browser
Route::get('/view-log', function () {
    $logPath = storage_path('logs/laravel.log');
    if (!file_exists($logPath)) {
        return 'Log file does not exist.';
    }
    $content = file_get_contents($logPath);
    return response(substr($content, -20000), 200)
        ->header('Content-Type', 'text/plain');
});

// Fallback Route untuk melayani file storage secara dinamis menggunakan path alternatif tanpa konflik symlink cPanel
Route::get('car-images/{path}', function ($path) {
    $path = str_replace(['../', '..\\'], '', $path); // Mencegah directory traversal
    $fullPath = storage_path('app/public/' . $path);

    if (!\Illuminate\Support\Facades\File::exists($fullPath)) {
        abort(404);
    }

    $file = \Illuminate\Support\Facades\File::get($fullPath);
    $type = \Illuminate\Support\Facades\File::mimeType($fullPath);

    $response = \Illuminate\Support\Facades\Response::make($file, 200);
    $response->header("Content-Type", $type);

    return $response;
})->where('path', '.*');
