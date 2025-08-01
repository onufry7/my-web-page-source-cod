<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class AphorismFactory extends Factory
{
    public function definition(): array
    {
        return [
            'sentence' => $this->faker->sentence(12),
            'author' => $this->faker->randomElement([
                'przysłowie ludowe',
                'anonim',
                'Jan Twardowski',
                'Albert Einstein',
                null,
            ]),
        ];
    }
}
