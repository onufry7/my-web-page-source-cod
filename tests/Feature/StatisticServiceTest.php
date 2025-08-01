<?php

namespace Tests\Feature;

use App\Models\Cipher;
use App\Models\Project;
use App\Models\Technology;
use App\Services\Statistics\StatisticService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StatisticServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_dominant_method_correct_data(): void
    {
        $statisticService = new StatisticService();

        $dominant = $statisticService->dominant([5, 6, 7, 7, 8, 9, 7, 6]);

        $this->assertEquals([0 => 7], $dominant);
    }

    public function test_arithmetic_average_method_correct_data(): void
    {
        $statisticService = new StatisticService();

        $dominant = $statisticService->arithmeticAverage([5, 5, 2]);

        $this->assertEquals(4, $dominant);
    }

    public function test_count_of_individual_models_method(): void
    {
        Project::factory(4)->create();
        Cipher::factory(2)->create();
        Technology::factory(2)->create();

        $statisticService = new StatisticService();
        $obtainedCollection = $statisticService->countOfIndividualModels()->toArray();

        $project = $obtainedCollection['project']['count'] == 4;
        $cipher = $obtainedCollection['cipher']['count'] == 2;
        $technology = $obtainedCollection['technology']['count'] == 2;
        $boardGame = $obtainedCollection['boardGame']['count'] == 0;
        $publisher = $obtainedCollection['publisher']['count'] == 0;
        $file = $obtainedCollection['file']['count'] == 0;

        $this->assertTrue($project, 'project count is invalid');
        $this->assertTrue($cipher, 'cipher count is invalid');
        $this->assertTrue($technology, 'technology count is invalid');
        $this->assertTrue($boardGame, 'boardGame count is invalid');
        $this->assertTrue($publisher, 'publisher count is invalid');
        $this->assertTrue($file, 'file count is invalid');
    }
}
