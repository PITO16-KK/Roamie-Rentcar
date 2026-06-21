<?php

namespace Tests\Feature;

use App\Models\Car;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CarPlateNumberTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        // Create an admin user to bypass CheckAdmin middleware
        $this->admin = User::factory()->create([
            'role' => 'admin',
        ]);
    }

    /**
     * Test successful creation of a car with a valid plate number.
     */
    public function test_can_create_car_with_valid_plate_number(): void
    {
        $response = $this->actingAs($this->admin)->post(route('admin.cars.store'), [
            'name' => 'Tesla Model Y',
            'type' => 'SUV',
            'plate_number' => 'b 1234 abc', // lowercase and spaced, should be normalized
            'rental_price' => 500000,
            'status' => 'available',
            'description' => 'Electric SUV',
            'gearbox' => 'Automatic',
            'seats' => 5,
            'engine' => 'EV',
            'year' => 2024,
        ]);

        $response->assertRedirect(route('admin.cars.index'));
        $response->assertSessionHas('success', 'Mobil berhasil ditambahkan.');

        // Verify the plate number is saved and normalized to uppercase
        $this->assertDatabaseHas('cars', [
            'name' => 'Tesla Model Y',
            'plate_number' => 'B 1234 ABC',
        ]);
    }

    /**
     * Test validation failure with invalid plate formats.
     *
     * @dataProvider invalidPlateProvider
     */
    public function test_fails_to_create_car_with_invalid_plate_number(string $invalidPlate): void
    {
        $response = $this->actingAs($this->admin)->post(route('admin.cars.store'), [
            'name' => 'Tesla Model Y',
            'type' => 'SUV',
            'plate_number' => $invalidPlate,
            'rental_price' => 500000,
            'status' => 'available',
        ]);

        $response->assertSessionHasErrors(['plate_number']);
        $this->assertDatabaseCount('cars', 0);
    }

    /**
     * Data provider for invalid plate numbers.
     */
    public static function invalidPlateProvider(): array
    {
        return [
            ['123456'], // No prefix and suffix
            ['ABCDEFG'], // No numbers
            ['B 12345 ABC'], // Numbers length too long (max 4 digits)
            ['BBBB 123 ABC'], // Prefix too long (max 2 characters)
            ['B 123 ABCDE'], // Suffix too long (max 3 characters)
            [''], // Required check
        ];
    }

    /**
     * Test uniqueness validation rule.
     */
    public function test_plate_number_must_be_unique(): void
    {
        // First car
        Car::factory()->create([
            'plate_number' => 'B 1234 ABC',
        ]);

        // Attempting to create a second car with the same plate number
        $response = $this->actingAs($this->admin)->post(route('admin.cars.store'), [
            'name' => 'BMW M3',
            'type' => 'Sedan',
            'plate_number' => 'b 1234 abc', // Should catch case-insensitively due to unique check / regex
            'rental_price' => 700000,
            'status' => 'available',
        ]);

        $response->assertSessionHasErrors(['plate_number']);
        $this->assertDatabaseCount('cars', 1);
    }

    /**
     * Test updating a car using the same plate number is allowed for the same car.
     */
    public function test_can_update_car_retaining_same_plate_number(): void
    {
        $car = Car::factory()->create([
            'plate_number' => 'B 1234 ABC',
        ]);

        $response = $this->actingAs($this->admin)->put(route('admin.cars.update', $car->id), [
            'name' => 'BMW M3 Updated',
            'type' => 'Sedan',
            'plate_number' => 'B 1234 ABC',
            'rental_price' => 750000,
            'status' => 'available',
        ]);

        $response->assertRedirect(route('admin.cars.index'));
        $response->assertSessionHas('success', 'Data mobil berhasil diperbarui.');

        $this->assertDatabaseHas('cars', [
            'id' => $car->id,
            'name' => 'BMW M3 Updated',
            'plate_number' => 'B 1234 ABC',
        ]);
    }

    /**
     * Test updating a car with a duplicate plate number of another car fails.
     */
    public function test_cannot_update_car_with_another_cars_plate_number(): void
    {
        $car1 = Car::factory()->create([
            'plate_number' => 'B 1234 ABC',
        ]);

        $car2 = Car::factory()->create([
            'plate_number' => 'D 999 XY',
        ]);

        $response = $this->actingAs($this->admin)->put(route('admin.cars.update', $car2->id), [
            'name' => 'BMW M3 Updated',
            'type' => 'Sedan',
            'plate_number' => 'B 1234 ABC', // Duplicates car1's plate
            'rental_price' => 750000,
            'status' => 'available',
        ]);

        $response->assertSessionHasErrors(['plate_number']);
        
        // Verify car2 wasn't updated to car1's plate
        $this->assertDatabaseHas('cars', [
            'id' => $car2->id,
            'plate_number' => 'D 999 XY',
        ]);
    }
}
