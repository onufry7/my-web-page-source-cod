<?php

namespace Tests\Feature\CorrectSleeve;

use App\Models\CorrectSleeve;
use App\Models\Sleeve;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CorrectSleeveTest extends TestCase
{
    use RefreshDatabase;

    public function test_sleeve_relationship(): void
    {
        $sleeve = Sleeve::factory()->create();
        $correctSleeve = CorrectSleeve::factory()->create(['sleeve_id' => $sleeve->id]);

        $this->assertInstanceOf(Sleeve::class, $correctSleeve->sleeve);
        $this->assertEquals($sleeve->id, $correctSleeve->sleeve->id);
    }

    public function test_correct_sleeve_can_be_persisted(): void
    {
        $sleeve = Sleeve::factory()->create();
        $data = [
            'sleeve_id' => $sleeve->id,
            'description' => 'Test description',
            'quantity_before' => 10,
            'quantity_after' => 5,
        ];

        CorrectSleeve::create($data);

        $this->assertDatabaseHas('correct_sleeves', $data);
    }
}
