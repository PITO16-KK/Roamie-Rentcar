<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Rental;
use Illuminate\Http\Request;

class ExportController extends Controller
{
    /**
     * Export all rentals to CSV (with preview screen support)
     */
    public function exportRentals(Request $request)
    {
        $rentals = Rental::with('car', 'user')->orderByDesc('created_at')->get();

        if ($request->has('download')) {
            $filename = 'data-rental-roamie-' . now()->format('Ymd-His') . '.csv';

            $headers = [
                'Content-Type'        => 'text/csv; charset=UTF-8',
                'Content-Disposition' => "attachment; filename=\"{$filename}\"",
                'Pragma'              => 'no-cache',
                'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
                'Expires'             => '0',
            ];

            $callback = function () use ($rentals) {
                $handle = fopen('php://output', 'w');

                // BOM for UTF-8 Excel compatibility
                fputs($handle, "\xEF\xBB\xBF");

                // Header Row
                fputcsv($handle, [
                    'ID Rental',
                    'Nama Pelanggan',
                    'Email Pelanggan',
                    'Nama Mobil',
                    'Tipe Mobil',
                    'Harga/Hari (Rp)',
                    'Tanggal Mulai',
                    'Durasi (Hari)',
                    'Total Harga (Rp)',
                    'Status Sewa',
                    'Status Pembayaran',
                    'Metode Pembayaran',
                    'Tanggal Dibuat',
                ]);

                foreach ($rentals as $rental) {
                    $totalPrice = ($rental->car->rental_price ?? 0) * $rental->duration_days;

                    fputcsv($handle, [
                        $rental->id,
                        $rental->user->name ?? '-',
                        $rental->user->email ?? '-',
                        $rental->car->name ?? '-',
                        $rental->car->type ?? '-',
                        $rental->car->rental_price ?? 0,
                        $rental->start_date,
                        $rental->duration_days,
                        $totalPrice,
                        $rental->status,
                        $rental->payment_status ?? 'unpaid',
                        $rental->payment_method ?? '-',
                        $rental->created_at->format('Y-m-d H:i:s'),
                    ]);
                }

                fclose($handle);
            };

            return response()->stream($callback, 200, $headers);
        }

        // Show preview: display first 20 records
        $totalCount = $rentals->count();
        $previewRentals = $rentals->take(20);

        return view('admin.export.preview', compact('previewRentals', 'totalCount'));
    }
}

