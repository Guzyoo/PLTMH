<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class DeviceFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'name' => $this->faker->word,
            'device_type' => $this->faker->randomElement(['ESP32', 'Raspberry Pi']),
            'device_identifier' => $this->faker->uuid
        ];
    }
}
