<?php

namespace Tests\Feature;

use App\Enums\BoardGameType;
use App\Models\BoardGame;
use App\Models\BoardGameSleeve;
use App\Models\Gameplay;
use App\Models\Publisher;
use App\Services\Statistics\BoardGameStatisticService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BoardGameStatisticServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_basic_statistics_method(): void
    {
        // Każdy BoardGameSleeve tworzy dodatkową grę bazową
        BoardGame::factory(2)->create([
            'type' => BoardGameType::BaseGame->value,
            'instruction' => 'http://chmiel.pl/sequi-ut',
            'to_painting' => true,
        ]);
        BoardGame::factory(1)->create([
            'type' => BoardGameType::Expansion->value,
            'instruction' => null,
            'need_instruction' => true,
        ]);
        BoardGame::factory(1)->create([
            'type' => BoardGameType::Expansion->value,
            'instruction' => null,
            'need_instruction' => false,
        ]);
        BoardGame::factory(1)->create([
            'type' => BoardGameType::MiniExpansion->value,
            'instruction' => null,
            'need_instruction' => true,
            'need_insert' => true,
        ]);
        BoardGameSleeve::factory()->create([
            'sleeved' => false,
        ]);
        BoardGameSleeve::factory()->create([
            'sleeved' => true,
        ]);

        $statisticService = new BoardGameStatisticService();

        $obtainedCollection = $statisticService->basicStatistics();

        $this->assertTrue($obtainedCollection->get('baseCount') == 4, 'Base game count is invalid');
        $this->assertTrue($obtainedCollection->get('expansionCount') == 3, 'Expansion count is invalid');
        $this->assertTrue($obtainedCollection->get('totalGameCount') == 7, 'Game count is invalid');
        $this->assertTrue($obtainedCollection->get('withoutInstructionCount') == 2, 'Without instruction count is invalid');
        $this->assertTrue($obtainedCollection->get('neededInsertCount') == 1, 'Needed insert count is invalid');
        $this->assertTrue($obtainedCollection->get('toSleeved') == 1, 'Sleeve up count is invalid');
        $this->assertTrue($obtainedCollection->get('toPainting') == 2, 'To painting count is invalid');
    }

    public function test_number_games_for_number_players_method(): void
    {
        BoardGame::factory(1)->create([
            'min_players' => 3,
            'max_players' => 8,
        ]);
        BoardGame::factory(1)->create([
            'min_players' => 1,
            'max_players' => 5,
        ]);
        BoardGame::factory(1)->create([
            'min_players' => 6,
            'max_players' => 12,
        ]);
        BoardGame::factory(1)->create([
            'min_players' => 3,
            'max_players' => 6,
        ]);
        $expectedCollection = collect([
            '1' => 1,
            '2' => 1,
            '3' => 3,
            '4' => 3,
            '5' => 3,
            '6' => 3,
            '7' => 2,
            '8' => 2,
            '9' => 1,
            '10' => 1,
            '11' => 1,
            '12' => 1,
        ]);
        $statisticService = new BoardGameStatisticService();

        $obtainedCollection = $statisticService->numberGamesForNumberPlayers();

        $this->assertTrue($obtainedCollection->all() == $expectedCollection->all(), 'Collection is not equal');
    }

    public function test_publishers_with_games_percentages_are_calculated_correctly(): void
    {
        $publishersWithGames = Publisher::factory()->count(3)->create();
        $totalGamesCount = 0;

        foreach ($publishersWithGames as $publisher) {
            $gamesCount = rand(1, 5);
            BoardGame::factory($gamesCount)->create(['publisher_id' => $publisher->id]);
            $totalGamesCount += $gamesCount;
        }
        $statisticService = new BoardGameStatisticService();

        $publishersData = $statisticService->publishersGamesPercentCollect(false);

        foreach ($publishersData as $data) {
            $this->assertArrayHasKey('games_count', $data);
            $this->assertArrayHasKey('percent', $data);
            $this->assertNotNull($data['games_count']);
            $expectedPercent = number_format(($data['games_count'] / $totalGamesCount) * 100, 2, ',') . '%';
            $this->assertEquals($expectedPercent, $data['percent']);
        }
    }

    public function test_top_ten_games_are_retrieved_correctly(): void
    {
        $boardGames = BoardGame::factory()->count(12)->create();

        foreach ($boardGames as $game) {
            Gameplay::factory()->count(rand(1, 10))->create(['board_game_id' => $game->id]);
        }
        $statisticService = new BoardGameStatisticService();

        $topTenGames = $statisticService->topTenGames();

        $this->assertCount(10, $topTenGames);

        foreach ($topTenGames as $game) {
            $this->assertArrayHasKey('name', $game->boardGame);
            $this->assertArrayHasKey('sum_count', $game);
        }
    }

    public function test_play_to_no_play_method(): void
    {
        BoardGame::factory(2)->create();
        BoardGame::factory()->create(['type' => BoardGameType::Expansion->value]);
        Gameplay::factory()->create();
        $expectedCollection = collect(['played' => 1, 'noPlayed' => 2]);
        $statisticService = new BoardGameStatisticService();

        $obtainedCollection = $statisticService->playToNoPlay();

        $this->assertTrue($obtainedCollection->all() == $expectedCollection->all(), 'Collection is not equal');
    }
}
