<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Profissional;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Profissional>
 */
class ProfissionalFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Profissional::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'password' => bcrypt('password'),
            'cpf' => $this->faker->numerify('###########'),
            'telefone' => $this->faker->phoneNumber,
            'cargo_id' => \App\Models\Cargo::factory(),
            'empresa_id' => \App\Models\Empresa::factory(),
        ];
    }
}
