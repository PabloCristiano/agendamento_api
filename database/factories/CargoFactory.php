<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Cargo;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Cargo>
 */
class CargoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Cargo::class;

    public function definition()
    {
        return [
            'cargo' => $this->faker->jobTitle,
            'empresa_id' => \App\Models\Empresa::factory(),
        ];
    }
}
