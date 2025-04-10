<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Usuario;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Usuario>
 */
class UsuarioFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Usuario::class;

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
