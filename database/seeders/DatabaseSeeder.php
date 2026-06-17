<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Car;
use App\Models\Rental;
use App\Models\VehicleLocation;
use App\Models\TripHistory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * Default Accounts:
     * ┌─────────────────────────────┬──────────────────────┬──────────┬─────────┐
     * │ Name                        │ Email                │ Password │ Role    │
     * ├─────────────────────────────┼──────────────────────┼──────────┼─────────┤
     * │ Admin Roamie                │ admin@roamie.com     │ password │ admin   │
     * │ John Doe                    │ customer@gmail.com   │ password │ customer│
     * └─────────────────────────────┴──────────────────────┴──────────┴─────────┘
     */
    public function run(): void
    {
        // ── Admin ─────────────────────────────────────────────────────────────
        User::create([
            'name'     => 'Admin Roamie',
            'email'    => 'admin@roamie.com',
            'password' => Hash::make('password'),
            'role'     => 'admin',
        ]);

        // ── Customer ──────────────────────────────────────────────────────────
        $customer = User::create([
            'name'     => 'John Doe',
            'email'    => 'customer@gmail.com',
            'password' => Hash::make('password'),
            'role'     => 'customer',
            'phone'    => '081234567890',
            'address'  => 'Jl. Kemang Raya No. 12, Jakarta Selatan',
        ]);

        // ── Cars ──────────────────────────────────────────────────────────────
        $car1 = Car::create(['name' => 'Toyota Avanza',     'type' => 'MPV',   'rental_price' => 350000,  'status' => 'available']);
        $car2 = Car::create(['name' => 'Honda Civic',       'type' => 'Sedan', 'rental_price' => 600000,  'status' => 'booked']);
        $car3 = Car::create(['name' => 'Mitsubishi Pajero', 'type' => 'SUV',   'rental_price' => 800000,  'status' => 'on-going']);
        $car4 = Car::create(['name' => 'Suzuki Ertiga',     'type' => 'MPV',   'rental_price' => 300000,  'status' => 'available']);
        $car5 = Car::create(['name' => 'Hyundai Ioniq 5',  'type' => 'EV',    'rental_price' => 1200000, 'status' => 'available']);

        // ── Rental 1: On-going, sudah bayar ───────────────────────────────────
        $rental = Rental::create([
            'car_id'         => $car3->id,
            'user_id'        => $customer->id,
            'start_date'     => now()->subDays(1)->format('Y-m-d'),
            'duration_days'  => 3,
            'status'         => 'on-going',
            'payment_status' => 'paid',
            'payment_method' => 'bank_transfer',
            'order_id'       => 'ROAMIE-1-SEED001',
            'total_price'    => 800000 * 3,
        ]);

        // ── Rental 2: Pending payment (belum bayar) ───────────────────────────
        Rental::create([
            'car_id'         => $car2->id,
            'user_id'        => $customer->id,
            'start_date'     => now()->addDays(2)->format('Y-m-d'),
            'duration_days'  => 2,
            'status'         => 'booked',
            'payment_status' => 'pending',
            'order_id'       => 'ROAMIE-2-SEED002',
            'snap_token'     => 'snap-token-dummy-sandbox',
            'total_price'    => 600000 * 2,
        ]);

        // ── Vehicle Location ──────────────────────────────────────────────────
        VehicleLocation::create([
            'car_id'    => $car3->id,
            'latitude'  => -6.229728,
            'longitude' => 106.829898,
            'timestamp' => now(),
        ]);

        // ── Trip History ──────────────────────────────────────────────────────
        TripHistory::create(['rental_id' => $rental->id, 'latitude' => -6.175392, 'longitude' => 106.827153, 'timestamp' => now()->subHours(4)]);
        TripHistory::create(['rental_id' => $rental->id, 'latitude' => -6.193125, 'longitude' => 106.821825, 'timestamp' => now()->subHours(3)]);
        TripHistory::create(['rental_id' => $rental->id, 'latitude' => -6.211544, 'longitude' => 106.844125, 'timestamp' => now()->subHours(2)]);
        TripHistory::create(['rental_id' => $rental->id, 'latitude' => -6.229728, 'longitude' => 106.829898, 'timestamp' => now()->subHours(1)]);
    }
}
