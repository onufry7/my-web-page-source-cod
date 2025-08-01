<?php

namespace Tests\Feature\BoardGameSleeve;

use App\Models\Sleeve;
use App\Repositories\BoardGameSleeveRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Collection;
use Illuminate\Support\Fluent;
use Tests\TestCase;

class BoardGameSleeveRepositoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_return_collect_fluent_with_correct_data(): void
    {
        $sleeve = Sleeve::factory()->create([
            'mark' => 'Mayday',
            'name' => 'Classic',
            'width' => '63',
            'height' => '88',
        ]);

        $repo = new BoardGameSleeveRepository();

        $result = $repo->getSleevesForSelectInput();

        $this->assertInstanceOf(Collection::class, $result);
        $this->assertCount(1, $result);

        $fluent = $result->first();
        $this->assertInstanceOf(Fluent::class, $fluent);
        $this->assertEquals($sleeve->id, $fluent->id);
        $this->assertEquals('Mayday - Classic (63x88 mm)', $fluent->label);
    }

    public function test_return_kollection_is_empty_when_not_sleeves(): void
    {
        $repo = new BoardGameSleeveRepository();

        $result = $repo->getSleevesForSelectInput();

        $this->assertInstanceOf(Collection::class, $result);
        $this->assertTrue($result->isEmpty());
    }

    public function test_any_element_of_collection_is_fluent(): void
    {
        Sleeve::factory()->count(3)->create();

        $repo = new BoardGameSleeveRepository();

        $result = $repo->getSleevesForSelectInput();

        $this->assertTrue($result->every(fn ($item) => $item instanceof Fluent));
    }

    public function test_generate_correct_labels_for_many_records(): void
    {
        Sleeve::factory()->create(['mark' => 'Mayday', 'name' => 'Classic', 'width' => '63', 'height' => '88']);
        Sleeve::factory()->create(['mark' => 'Ultra Pro', 'name' => 'Caro', 'width' => '70', 'height' => '120']);

        $repo = new BoardGameSleeveRepository();

        $result = $repo->getSleevesForSelectInput();

        $labels = $result->pluck('label')->toArray();

        $this->assertContains('Mayday - Classic (63x88 mm)', $labels);
        $this->assertContains('Ultra Pro - Caro (70x120 mm)', $labels);
    }
}
