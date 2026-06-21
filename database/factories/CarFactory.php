<?php

namespace Database\Factories;

use App\Models\Car;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Car>
 */
class CarFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Generate a standard Indonesian plate number (e.g. B 1234 ABC)
        $prefix = fake()->randomElement(['B', 'D', 'F', 'T', 'AB', 'AD', 'AE', 'L', 'N', 'S', 'W', 'DK']);
        $number = fake()->numberBetween(1, 9999);
        $suffix = strtoupper(fake()->lexify('???'));
        $plate = "{$prefix} {$number} {$suffix}";

        return [
            'name' => fake()->randomElement(['Toyota Avanza', 'Honda Civic', 'Mitsubishi Pajero', 'Suzuki Ertiga', 'Hyundai Ioniq 5', 'BMW M4', 'Tesla Model S']),
            'type' => fake()->randomElement(['MPV', 'Sedan', 'SUV', 'EV']),
            'plate_number' => $plate,
            'rental_price' => fake()->randomElement([300000, 350000, 500000, 600000, 800000, 1200000]),
            'status' => 'available',
            'description' => fake()->paragraph(),
            'gearbox' => fake()->randomElement(['Automatic', 'Manual']),
            'seats' => fake()->randomElement([4, 5, 7]),
            'engine' => fake()->randomElement(['1500cc', '2000cc', 'Electric']),
            'year' => fake()->numberBetween(2018, 2024),
        ];
    }
}
