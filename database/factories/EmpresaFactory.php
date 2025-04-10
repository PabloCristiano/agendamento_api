<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Empresa;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Empresa>
 */
class EmpresaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Empresa::class;

    public function definition()
    {
        return [
            'razao_social' => $this->faker->company,
            'cnpj' => $this->faker->numerify('##############'),
            'nome_responsavel' => $this->faker->name,
            'telefone' => $this->faker->phoneNumber,
            'email' => $this->faker->companyEmail,
            'logradouro' => $this->faker->streetName,
            'numero' => $this->faker->buildingNumber,
            'complemento' => $this->faker->secondaryAddress,
            'bairro' => $this->faker->city,
            'cep' => $this->faker->postcode,
            'status' => true,
            'observacao' => $this->faker->sentence,
        ];
    }
}
