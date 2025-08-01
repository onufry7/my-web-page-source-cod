<?php

namespace Tests\Feature\BoardGame;

use App\Interfaces\FileManager;
use App\Models\BoardGame;
use App\Models\Publisher;
use App\Services\BoardGameService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\MockObject\MockObject;
use Tests\TestCase;

class BoardGameServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_return_base_game_when_base_game_id_is_set(): void
    {
        $baseGame = BoardGame::factory()->create(['name' => 'Podstawowa']);
        $expansion = BoardGame::factory()->create(['base_game_id' => $baseGame->id, 'name' => 'Dodatek']);

        $service = new BoardGameService($this->mockFileManager());

        $result = $service->relatedGames($expansion);

        $this->assertEquals('Base', $result['title']);
        $this->assertCount(1, $result['games']);
        $this->assertTrue($result['games']->first()->is($baseGame));
    }

    public function test_return_expansions_when_expansion_is_set(): void
    {
        $baseGame = BoardGame::factory()->create(['name' => 'Podstawowa']);
        $expansion1 = BoardGame::factory()->create(['base_game_id' => $baseGame->id, 'name' => 'Dodatek 1']);
        $expansion2 = BoardGame::factory()->create(['base_game_id' => $baseGame->id, 'name' => 'Dodatek 2']);

        $service = new BoardGameService($this->mockFileManager());

        $result = $service->relatedGames($baseGame);

        $this->assertEquals('Expansions', $result['title']);
        $this->assertCount(2, $result['games']);
        $this->assertTrue($result['games']->contains(fn ($g) => $g->is($expansion1)));
        $this->assertTrue($result['games']->contains(fn ($g) => $g->is($expansion2)));
    }

    public function test_return_empty_array_when_dont_have_relations(): void
    {
        $game = BoardGame::factory()->create();

        $service = new BoardGameService($this->mockFileManager());

        $result = $service->relatedGames($game);

        $this->assertEquals([], $result);
    }

    public function test_return_all_publishers_when_exist(): void
    {
        $publisher = Publisher::factory()->create(['name' => 'Rebel']);
        $originalPublisher = Publisher::factory()->create(['name' => 'Asmodee']);

        $boardGame = BoardGame::factory()->create([
            'publisher_id' => $publisher->id,
            'original_publisher_id' => $originalPublisher->id,
        ]);

        $service = new BoardGameService($this->mockFileManager());

        $result = $service->getPublishers($boardGame);

        $this->assertEqualsCanonicalizing([
            'Publisher' => $publisher->id,
            'Original publisher' => $originalPublisher->id,
        ], [
            'Publisher' => $result['Publisher']->id,
            'Original publisher' => $result['Original publisher']->id,
        ]);
    }

    public function test_return_omly_one_publisher_when_second_not_exist(): void
    {
        $publisher = Publisher::factory()->create(['name' => 'Rebel']);

        $boardGame = BoardGame::factory()->create([
            'publisher_id' => $publisher->id,
            'original_publisher_id' => null,
        ]);

        $service = new BoardGameService($this->mockFileManager());

        $result = $service->getPublishers($boardGame);

        $this->assertEquals([
            'Publisher' => $publisher->id,
        ], [
            'Publisher' => $result['Publisher']->id,
        ]);
    }

    public function test_return_empty_array_when_no_publishers(): void
    {
        $boardGame = BoardGame::factory()->create([
            'publisher_id' => null,
            'original_publisher_id' => null,
        ]);

        $service = new BoardGameService($this->mockFileManager());

        $result = $service->getPublishers($boardGame);

        $this->assertEqualsCanonicalizing([], $result);
    }

    private function mockFileManager(): FileManager|MockObject
    {
        return $this->getMockBuilder(FileManager::class)
            ->disableOriginalConstructor()
            ->getMock();
    }
}
