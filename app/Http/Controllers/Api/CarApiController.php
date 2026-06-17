<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Car;
use Illuminate\Http\Request;

class CarApiController extends Controller
{
    /**
     * List all available cars.
     */
    public function index(Request $request)
    {
        $status = $request->query('status');

        if ($status) {
            $cars = Car::where('status', $status)->get();
        } else {
            $cars = Car::all();
        }

        $cars = $cars->map(function ($car) {
            if ($car->image && !filter_var($car->image, FILTER_VALIDATE_URL)) {
                $car->image = asset('car-images/' . $car->image);
            }
            return $car;
        });

        return response()->json([
            'status' => 'success',
            'data' => $cars
        ]);
    }

    /**
     * Get details of a specific car.
     */
    public function show($id)
    {
        $car = Car::find($id);

        if (!$car) {
            return response()->json([
                'status' => 'error',
                'message' => 'Car not found'
            ], 404);
        }

        if ($car->image && !filter_var($car->image, FILTER_VALIDATE_URL)) {
            $car->image = asset('car-images/' . $car->image);
        }

        return response()->json([
            'status' => 'success',
            'data' => $car
        ]);
    }
}
