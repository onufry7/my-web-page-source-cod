<?php

namespace Tests\Unit\Repositories;

use App\Enums\BoardGameType;
use App\Filters\BoardGameFilter;
use App\Models\BoardGame;
use App\Repositories\BoardGameRepository;
use App\Services\BoardGameService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Mockery;
use Tests\TestCase;

class BoardGameRepositoryTest extends TestCase
{
    use RefreshDatabase;

    protected BoardGameService $mockService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->mockService = Mockery::mock(BoardGameService::class);
        $this->app->instance(BoardGameService::class, $this->mockService);
    }

    public function test_games_methode(): void
    {
        BoardGame::factory()->create([
            'type' => BoardGameType::Expansion->value,
        ]);

        BoardGame::factory()->create([
            'type' => BoardGameType::BaseGame->value,
        ]);

        $service = new BoardGameRepository($this->mockService);
        $result = $service->games();

        $this->assertInstanceOf(Collection::class, $result);

        $this->assertCount(2, $result);
    }

    public function test_base_games_methode(): void
    {
        BoardGame::factory()->create([
            'type' => BoardGameType::Expansion->value,
        ]);

        $base = BoardGame::factory()->create([
            'type' => BoardGameType::BaseGame->value,
        ]);

        $service = new BoardGameRepository($this->mockService);
        $result = $service->baseGames();

        $this->assertInstanceOf(Collection::class, $result);

        $this->assertCount(1, $result);
        $this->assertEquals($base->name, $result->first()->name);
    }

    public function test_expansions_methode(): void
    {
        $expansion = BoardGame::factory()->create([
            'type' => BoardGameType::Expansion->value,
        ]);

        BoardGame::factory()->create([
            'type' => BoardGameType::BaseGame->value,
        ]);

        $service = new BoardGameRepository($this->mockService);
        $result = $service->expansions();

        $this->assertInstanceOf(Collection::class, $result);

        $this->assertCount(1, $result);
        $this->assertEquals($expansion->name, $result->first()->name);
    }

    public function test_games_paginated(): void
    {
        BoardGame::factory(3)->create([
            'type' => BoardGameType::Expansion->value,
        ]);
        BoardGame::factory()->create([
            'type' => BoardGameType::BaseGame->value,
        ]);

        $filters = new BoardGameFilter();
        $service = new BoardGameRepository($this->mockService);
        $perPage = 2;
        $result = $service->gamesPaginated($filters, $perPage);

        $this->assertInstanceOf(LengthAwarePaginator::class, $result);
        $this->assertCount($perPage, $result->items());
        $this->assertEquals(2, $result->perPage());
        $this->assertEquals(4, $result->total());
    }

    public function test_base_games_paginated(): void
    {
        BoardGame::factory(3)->create([
            'type' => BoardGameType::Expansion->value,
        ]);
        BoardGame::factory(2)->create([
            'type' => BoardGameType::BaseGame->value,
        ]);

        $filters = new BoardGameFilter();
        $service = new BoardGameRepository($this->mockService);
        $perPage = 2;
        $result = $service->baseGamesPaginated($filters, $perPage);

        $this->assertInstanceOf(LengthAwarePaginator::class, $result);
        $this->assertCount($perPage, $result->items());
        $this->assertEquals(2, $result->perPage());
        $this->assertEquals(2, $result->total());
    }

    public function test_expansions_paginated(): void
    {
        BoardGame::factory(3)->create([
            'type' => BoardGameType::Expansion->value,
        ]);
        BoardGame::factory()->create([
            'type' => BoardGameType::BaseGame->value,
        ]);

        $filters = new BoardGameFilter();
        $service = new BoardGameRepository($this->mockService);
        $perPage = 2;
        $result = $service->expansionsPaginated($filters, $perPage);

        $this->assertInstanceOf(LengthAwarePaginator::class, $result);
        $this->assertCount($perPage, $result->items());
        $this->assertEquals(2, $result->perPage());
        $this->assertEquals(3, $result->total());
    }

    public function test_select_games_with_type_all(): void
    {
        $request = Request::create('/some-url', 'GET', ['type' => 'all']);

        $gamesCollection = collect([
            new BoardGame(['id' => 1, 'name' => 'Test Game 1']),
            new BoardGame(['id' => 2, 'name' => 'Test Game 2']),
        ]);

        $repository = $this->getMockBuilder(BoardGameRepository::class)
            ->setConstructorArgs([$this->mockService])
            ->onlyMethods(['games'])
            ->getMock($this->mockService);

        $repository->expects($this->once())
            ->method('games')
            ->willReturn($gamesCollection);

        $result = $repository->selectGames($request);

        $this->assertInstanceOf(Collection::class, $result);
        $this->assertCount(2, $result);
    }

    public function test_select_games_with_type_expansion(): void
    {
        $request = Request::create('/some-url', 'GET', ['type' => 'expansion']);

        $expansionsCollection = collect([
            new BoardGame(['id' => 1, 'name' => 'Expansion Game 1']),
            new BoardGame(['id' => 2, 'name' => 'Expansion Game 2']),
        ]);

        $repository = $this->getMockBuilder(BoardGameRepository::class)
            ->setConstructorArgs([$this->mockService])
            ->onlyMethods(['expansions'])
            ->getMock();

        $repository->expects($this->once())
            ->method('expansions')
            ->willReturn($expansionsCollection);

        $result = $repository->selectGames($request);

        $this->assertInstanceOf(Collection::class, $result);
        $this->assertCount(2, $result);
    }

    public function test_select_games_with_default_type(): void
    {
        $request = Request::create('/some-url', 'GET', ['type' => 'unknown']);

        $baseGamesCollection = collect([
            new BoardGame(['id' => 1, 'name' => 'Base Game 1']),
            new BoardGame(['id' => 2, 'name' => 'Base Game 2']),
        ]);

        $repository = $this->getMockBuilder(BoardGameRepository::class)
            ->setConstructorArgs([$this->mockService])
            ->onlyMethods(['baseGames'])
            ->getMock();

        $repository->expects($this->once())
            ->method('baseGames')
            ->willReturn($baseGamesCollection);

        $result = $repository->selectGames($request);

        $this->assertInstanceOf(Collection::class, $result);
        $this->assertCount(2, $result);
    }

    public function test_select_games_paginated_with_all_type(): void
    {
        $filters = new BoardGameFilter();
        $type = 'wszystkie';
        $perPage = 10;

        $paginatorMock = $this->createMock(LengthAwarePaginator::class);
        $repository = $this->getMockBuilder(BoardGameRepository::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['gamesPaginated', 'expansionsPaginated', 'baseGamesPaginated'])
            ->getMock();
        $repository->expects($this->once())
            ->method('gamesPaginated')
            ->with($filters, $perPage)
            ->willReturn($paginatorMock);

        $result = $repository->selectGamesPaginated($filters, $type, $perPage);

        $this->assertInstanceOf(LengthAwarePaginator::class, $result);
    }

    public function test_select_games_paginated_with_expansions_type(): void
    {
        $filters = new BoardGameFilter();
        $type = 'dodatki';
        $perPage = 10;

        $paginatorMock = $this->createMock(LengthAwarePaginator::class);
        $repository = $this->getMockBuilder(BoardGameRepository::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['gamesPaginated', 'expansionsPaginated', 'baseGamesPaginated'])
            ->getMock();
        $repository->expects($this->once())
            ->method('expansionsPaginated')
            ->with($filters, $perPage)
            ->willReturn($paginatorMock);

        $result = $repository->selectGamesPaginated($filters, $type, $perPage);

        $this->assertInstanceOf(LengthAwarePaginator::class, $result);
    }

    public function test_select_games_paginated_with_base_type(): void
    {
        $filters = new BoardGameFilter();
        $type = 'podstawki';
        $perPage = 10;

        $paginatorMock = $this->createMock(LengthAwarePaginator::class);
        $repository = $this->getMockBuilder(BoardGameRepository::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['gamesPaginated', 'expansionsPaginated', 'baseGamesPaginated'])
            ->getMock();
        $repository->expects($this->once())
            ->method('baseGamesPaginated')
            ->with($filters, $perPage)
            ->willReturn($paginatorMock);

        $result = $repository->selectGamesPaginated($filters, $type, $perPage);

        $this->assertInstanceOf(LengthAwarePaginator::class, $result);
    }
}
