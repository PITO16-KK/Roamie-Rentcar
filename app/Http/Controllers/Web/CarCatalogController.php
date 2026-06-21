<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Car;
use Illuminate\Http\Request;

class CarCatalogController extends Controller
{
    /**
     * Display the public promo page.
     */
    public function index(Request $request)
    {
        $query = Car::where('status', 'available');

        // Filter pencarian berdasarkan nama mobil
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Filter berdasarkan tipe mobil
        if ($request->filled('type') && $request->type !== 'all') {
            $query->where('type', $request->type);
        }

        $cars = $query->get();

        return view('catalog', compact('cars'));
    }
}
