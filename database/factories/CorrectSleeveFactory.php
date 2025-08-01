<?php

namespace Database\Factories;

use App\Models\Sleeve;
use Illuminate\Database\Eloquent\Factories\Factory;

class CorrectSleeveFactory extends Factory
{
    public function definition(): array
    {
        $sleeve = Sleeve::factory()->create();

        return [
            'sleeve_id' => $sleeve->getAttribute('id'),
            'description' => 'Correct description',
            'quantity_before' => random_int(0, 1000),
            'quantity_after' => random_int(0, 1000),
        ];
    }
}
