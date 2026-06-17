<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Car;
use Illuminate\Http\Request;

class CarCatalogController extends Controller
{
    /**
     * Display the public car catalog.
     */
    public function index(Request $request)
    {
        $query = Car::query();

        // Handle Search
        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Handle Type Filter
        if ($request->has('type') && $request->type != '') {
            $query->where('type', $request->type);
        }

        $cars = $query->get();
        
        // Get unique types for filter
        $types = Car::distinct()->pluck('type');

        return view('catalog', compact('cars', 'types'));
    }
}
