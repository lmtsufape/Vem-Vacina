<?php

namespace Database\Factories;

use App\Models\PostoVacinacao;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostoVacinacaoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PostoVacinacao::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nome' => $this->faker->numerify('posto-####'),
            'endereco' => "rua 1"
        ];
    }
}
