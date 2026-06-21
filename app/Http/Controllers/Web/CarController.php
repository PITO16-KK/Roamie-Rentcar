<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CarController extends Controller
{
    /**
     * Display a listing of the cars.
     */
    public function index()
    {
        $cars = Car::all();
        return view('admin.cars.index', compact('cars'));
    }

    /**
     * Show the form for creating a new car.
     */
    public function create()
    {
        return view('admin.cars.create');
    }

    /**
     * Store a newly created car in storage.
     */
    public function store(Request $request)
    {
        if ($request->has('plate_number')) {
            $request->merge([
                'plate_number' => strtoupper(trim($request->plate_number))
            ]);
        }

        $request->validate([
            'name'         => 'required|string|max:255',
            'type'         => 'required|string|max:255',
            'plate_number' => ['required', 'string', 'unique:cars,plate_number', 'regex:/^[A-Z]{1,2}\s?\d{1,4}\s?[A-Z]{1,3}$/i'],
            'rental_price' => 'required|numeric|min:0',
            'status'       => 'required|in:available,booked,on-going',
            'image'        => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'description'  => 'nullable|string',
            'gearbox'      => 'nullable|string|max:50',
            'seats'        => 'nullable|integer|min:1',
            'engine'       => 'nullable|string|max:100',
            'year'         => 'nullable|integer|min:1900|max:' . date('Y'),
        ], [
            'plate_number.regex' => 'Format plat nomor tidak valid. Standar Indonesia: B 1234 ABC atau D 999 XY.',
            'plate_number.unique' => 'Plat nomor ini sudah terdaftar pada mobil lain.',
        ]);

        $data = $request->only([
            'name', 'type', 'plate_number', 'rental_price', 'status',
            'description', 'gearbox', 'seats', 'engine', 'year',
        ]);

        $data['plate_number'] = strtoupper(trim($data['plate_number']));

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('cars', 'public');
        }

        Car::create($data);

        return redirect()->route('admin.cars.index')->with('success', 'Mobil berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified car.
     */
    public function edit($id)
    {
        $car = Car::findOrFail($id);
        return view('admin.cars.edit', compact('car'));
    }

    /**
     * Update the specified car in storage.
     */
    public function update(Request $request, $id)
    {
        $car = Car::findOrFail($id);

        if ($request->has('plate_number')) {
            $request->merge([
                'plate_number' => strtoupper(trim($request->plate_number))
            ]);
        }

        $request->validate([
            'name'         => 'required|string|max:255',
            'type'         => 'required|string|max:255',
            'plate_number' => ['required', 'string', 'unique:cars,plate_number,' . $id, 'regex:/^[A-Z]{1,2}\s?\d{1,4}\s?[A-Z]{1,3}$/i'],
            'rental_price' => 'required|numeric|min:0',
            'status'       => 'required|in:available,booked,on-going',
            'image'        => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'description'  => 'nullable|string',
            'gearbox'      => 'nullable|string|max:50',
            'seats'        => 'nullable|integer|min:1',
            'engine'       => 'nullable|string|max:100',
            'year'         => 'nullable|integer|min:1900|max:' . date('Y'),
        ], [
            'plate_number.regex' => 'Format plat nomor tidak valid. Standar Indonesia: B 1234 ABC atau D 999 XY.',
            'plate_number.unique' => 'Plat nomor ini sudah terdaftar pada mobil lain.',
        ]);

        $data = $request->only([
            'name', 'type', 'plate_number', 'rental_price', 'status',
            'description', 'gearbox', 'seats', 'engine', 'year',
        ]);

        $data['plate_number'] = strtoupper(trim($data['plate_number']));

        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($car->image && Storage::disk('public')->exists($car->image)) {
                Storage::disk('public')->delete($car->image);
            }
            $data['image'] = $request->file('image')->store('cars', 'public');
        }

        $car->update($data);

        return redirect()->route('admin.cars.index')->with('success', 'Data mobil berhasil diperbarui.');
    }

    /**
     * Remove the specified car from storage.
     */
    public function destroy($id)
    {
        $car = Car::findOrFail($id);

        // Hapus gambar dari storage jika ada
        if ($car->image && Storage::disk('public')->exists($car->image)) {
            Storage::disk('public')->delete($car->image);
        }

        $car->delete();

        return redirect()->route('admin.cars.index')->with('success', 'Mobil berhasil dihapus.');
    }
}
