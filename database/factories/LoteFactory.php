<?php

namespace Database\Factories;

use App\Models\Lote;
use Illuminate\Database\Eloquent\Factories\Factory;
use DateTime;

class LoteFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Lote::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {   $bool = [false, false];
        return [
            'numero_lote' => $this->faker->regexify('[A-Z]{5}[0-4]{3}'),
            'fabricante' => $this->faker->numerify('fab-####'),
            'numero_vacinas' => $this->faker->numberBetween(10, 50),
            'dose_unica' => $bool[$this->faker->numberBetween(0, 1)] ,
            'inicio_periodo' => $this->faker->numberBetween(2, 30),
            'fim_periodo' => $this->faker->numberBetween(30, 90),
            'data_fabricacao' => $this->faker->dateTimeBetween('-2 week', '-1 week'),
            'data_validade' => $this->faker->dateTimeBetween('+1 week', '+3 week')
        ];
    }
}
