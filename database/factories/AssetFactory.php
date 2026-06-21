<?php

namespace Database\Factories;

use App\Models\Location;
use Illuminate\Database\Eloquent\Factories\Factory;

class AssetFactory extends Factory
{
    public function definition(): array
    {
        return [
            'asset_code' => $this->faker->unique()->bothify('AST-####'),
            'register_number' => 'REG-'.$this->faker->unique()->numberBetween(1000, 9999),
            'name' => $this->faker->words(3, true),
            'category' => $this->faker->randomElement(['Elektronik', 'Mebel', 'Kendaraan', 'Alat Tulis']),
            'quantity' => $this->faker->numberBetween(1, 50),
            'unit' => 'Unit',
            'condition' => $this->faker->randomElement(['baik', 'cukup', 'rusak']),
            'location_id' => Location::factory(),
            'description' => $this->faker->paragraph(),
        ];
    }
}
