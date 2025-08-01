<?php

namespace Tests\Unit\Models;

use App\Models\BoardGame;
use PHPUnit\Framework\TestCase;

class BoardGameTest extends TestCase
{
    public function test_returns_single_value_when_min_equals_max(): void
    {
        $game = $this->makeGame(3, 3);
        $this->assertSame('3', $game->getPlayersNumber());
    }

    public function test_returns_range_when_min_and_max_are_different(): void
    {
        $game = $this->makeGame(2, 5);
        $this->assertSame('2 - 5', $game->getPlayersNumber());
    }

    public function test_returns_min_when_only_min_is_set(): void
    {
        $game = $this->makeGame(4, null);
        $this->assertSame('4', $game->getPlayersNumber());
    }

    public function test_returns_max_when_only_max_is_set(): void
    {
        $game = $this->makeGame(null, 6);
        $this->assertSame('6', $game->getPlayersNumber());
    }

    public function test_returns_empty_string_when_min_and_max_are_null(): void
    {
        $game = $this->makeGame(null, null);
        $this->assertSame('', $game->getPlayersNumber());
    }

    public function test_returns_all_links_when_all_are_present(): void
    {
        $game = $this->makeGameWithUrls(
            'https://boardgamegeek.com/game/123',
            'https://planszeo.pl/gra/abc',
            'https://youtube.com/video/xyz'
        );

        $this->assertSame([
            'bgg' => 'https://boardgamegeek.com/game/123',
            'planszeo' => 'https://planszeo.pl/gra/abc',
            'video' => 'https://youtube.com/video/xyz',
        ], $game->getMultimediaContent());
    }

    public function test_returns_only_non_null_links(): void
    {
        $game = $this->makeGameWithUrls(
            null,
            'https://planszeo.pl/gra/abc',
            null
        );

        $this->assertSame([
            'planszeo' => 'https://planszeo.pl/gra/abc',
        ], $game->getMultimediaContent());
    }

    public function test_returns_empty_array_when_all_are_null(): void
    {
        $game = $this->makeGameWithUrls(null, null, null);
        $this->assertSame([], $game->getMultimediaContent());
    }

    private function makeGameWithUrls(?string $bgg, ?string $planszeo, ?string $video): BoardGame
    {
        $game = new BoardGame();
        $game->bgg_url = $bgg;
        $game->planszeo_url = $planszeo;
        $game->video_url = $video;

        return $game;
    }

    private function makeGame(?int $min, ?int $max): BoardGame
    {
        $game = new BoardGame();
        $game->min_players = $min;
        $game->max_players = $max;

        return $game;
    }
}
