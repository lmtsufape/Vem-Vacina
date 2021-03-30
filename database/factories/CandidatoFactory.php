<?php

namespace Database\Factories;

use App\Models\Lote;
use App\Models\Etapa;
use App\Models\Candidato;
use App\Models\PostoVacinacao;
use Illuminate\Database\Eloquent\Factories\Factory;

class CandidatoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Candidato::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nome_completo' => $this->faker->regexify('[A-Z]{5}[0-4]{3}'),
            'data_de_nascimento' => $this->faker->dateTimeBetween('-2 week', '-1 week'),
            'idade' => $this->faker->numberBetween(50, 100),
            'cpf' => $this->faker->numberBetween(50, 100000) ,
            'numero_cartao_sus' =>$this->faker->numberBetween(50, 100000),
            'sexo' => Candidato::SEXO_ENUM[0],
            'nome_da_mae' => $this->faker->word(),
            'telefone' => $this->faker->word(),
            'whatsapp' => $this->faker->word(),
            'cep' => $this->faker->numberBetween(50, 5000),
            'cidade' => $this->faker->word(),
            'bairro' => $this->faker->word(),
            'logradouro' => $this->faker->word(),
            'numero_residencia' => $this->faker->numberBetween(50, 100),
            'complemento_endereco' => $this->faker->word(),
            'aprovacao' => Candidato::APROVACAO_ENUM[0],
            'dose' => Candidato::DOSE_ENUM[$this->faker->numberBetween(0, 1)],
            'chegada' => $this->faker->dateTimeBetween('-2 week', '-1 week'),
            'saida' => $this->faker->dateTimeBetween('-2 week', '-1 week'),
            'lote_id' => $this->faker->numberBetween(1, Lote::count()),
            'posto_vacinacao_id' => $this->faker->numberBetween(1, PostoVacinacao::count()),
            'etapa_id' => $this->faker->numberBetween(1, Etapa::count()),

        ];
    }
}
