$zipPath = "manual_payment_cpanel_v2.zip"
if (Test-Path $zipPath) {
    Remove-Item $zipPath -Force
}

$tempDir = New-Item -ItemType Directory -Path "temp_zip_dir" -Force

$files = @(
    "app/Http/Controllers/Web/BookingController.php",
    "app/Http/Controllers/Web/PaymentController.php",
    "resources/views/payment.blade.php",
    "resources/views/invoice.blade.php",
    "resources/views/profile.blade.php",
    "routes/web.php",
    "routes/api.php",
    "app/Http/Controllers/Api/PaymentController.php",
    "app/Http/Controllers/Web/PaymentVerificationController.php",
    "app/Mail/PaymentUploadedNotification.php",
    "resources/views/emails/payment_uploaded.blade.php",
    "resources/views/admin/payments/index.blade.php",
    "database/migrations/2026_06_04_000001_add_midtrans_columns_to_rentals_table.php",
    "database/migrations/2026_06_05_000001_add_spec_columns_to_cars_table.php",
    "database/migrations/2026_06_06_000001_create_payments_table.php",
    "database/migrations/2026_06_06_000002_add_specifications_to_cars_table.php",
    "database/migrations/2026_06_08_144839_create_personal_access_tokens_table.php",
    "app/Http/Controllers/Web/AuthController.php",
    "resources/views/auth/login.blade.php",
    "resources/views/auth/register.blade.php"
)

foreach ($file in $files) {
    $destFile = Join-Path $tempDir.FullName $file
    $destDir = Split-Path $destFile -Parent
    if (!(Test-Path $destDir)) {
        New-Item -ItemType Directory -Path $destDir -Force | Out-Null
    }
    Copy-Item $file $destFile -Force
}

Compress-Archive -Path "temp_zip_dir\*" -DestinationPath $zipPath -Force
Remove-Item -Recurse -Force "temp_zip_dir"
Write-Host "Success! Created manual_payment_cpanel_v2.zip"
