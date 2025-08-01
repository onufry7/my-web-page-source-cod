<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TechnologySeeder extends Seeder
{
    protected array $technologies = [
        ['name' => 'PHP'],
        ['name' => 'CSS'],
        ['name' => 'Tailwind'],
        ['name' => 'HTML'],
        ['name' => 'JavaScript'],
        ['name' => 'Angular'],
        ['name' => 'React'],
        ['name' => 'MySQL'],
        ['name' => 'PostgreSQL'],
        ['name' => 'SQLite'],
        ['name' => 'Python'],
        ['name' => 'C++'],
        ['name' => 'C#'],
        ['name' => 'Java'],
        ['name' => 'Kotlin'],
        ['name' => 'Ruby'],
        ['name' => 'AJAX'],
        ['name' => 'jQuery'],
    ];

    public function run(): void
    {
        DB::table('technologies')->insert($this->technologies);
    }
}
