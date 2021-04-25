<?php

namespace Database\Factories;

use App\Models\Collection;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CollectionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Collection::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            //sentence($nbWords = 6, $variableNbWords = true)
            'name' => $this->faker->word(),
            'label' => $this->faker->sentence(2),
            'fields' => '[{"name":"' . 'a'.$this->faker->word() . '","label":"' . $this->faker->word() . '","type":"text","order":null},{"name":"' . 'a'.$this->faker->word() . '","label":"' . $this->faker->word() . '","type":"text","order":null}]',
            'options' => '',
        ];
    }
}
