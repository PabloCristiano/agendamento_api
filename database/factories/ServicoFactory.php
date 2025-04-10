<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Servico;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Servico>
 */
class ServicoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Servico::class;

    public function definition()
    {
        return [
            'servico' => $this->faker->words(2, true),
            'tempo' => $this->faker->numberBetween(15, 120),
            'valor' => $this->faker->randomFloat(2, 30, 500),
            'comissao' => $this->faker->randomFloat(2, 5, 50),
            'categoria_id' => \App\Models\Categoria::factory(),
        ];
    }
}
