<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PublisherSeeder extends Seeder
{
    protected array $publishers = [
        ['name' => '2 Pionki'],
        ['name' => 'Albi'],
        ['name' => 'All In Games'],
        ['name' => 'Arcane Wonders'],
        ['name' => 'Awaken Realms Lite'],
        ['name' => 'Baldar'],
        ['name' => 'Bard Centrum Gier'],
        ['name' => 'Bombyx'],
        ['name' => 'Cardboard Alchemy'],
        ['name' => 'Cube'],
        ['name' => 'Cube Factory of Ideas'],
        ['name' => 'Czacha Games'],
        ['name' => 'Czech Games Edition'],
        ['name' => 'Days of Wonder'],
        ['name' => 'Dice&Bones'],
        ['name' => 'Egmont'],
        ['name' => 'Fantasy Flight Games'],
        ['name' => 'Fishbone Games'],
        ['name' => 'FoxGames'],
        ['name' => 'Funforge'],
        ['name' => 'G3'],
        ['name' => 'Galakta'],
        ['name' => 'Galmadrin'],
        ['name' => 'GameWorks'],
        ['name' => 'Gamelyn Games'],
        ['name' => 'Games Factory'],
        ['name' => 'Games Unplugged'],
        ['name' => 'Games Workshop'],
        ['name' => 'Go On Board'],
        ['name' => 'Granna'],
        ['name' => 'Hasbro'],
        ['name' => 'Hobbity'],
        ['name' => 'IUVI Games'],
        ['name' => 'Lacerta'],
        ['name' => 'Libellud'],
        ['name' => 'Lucky Duck Games'],
        ['name' => 'Lucrum Games'],
        ['name' => 'Ludonaute'],
        ['name' => 'Mattel'],
        ['name' => 'Moria Games'],
        ['name' => 'Muduko'],
        ['name' => 'Nasza Księgarnia'],
        ['name' => 'Ogry Games'],
        ['name' => 'Parker Brothers'],
        ['name' => 'Phalanx'],
        ['name' => 'Pokemon Company International'],
        ['name' => 'Portal Games'],
        ['name' => 'Queen Games'],
        ['name' => 'Ravensburger'],
        ['name' => 'Rebel'],
        ['name' => 'Spin Master'],
        ['name' => 'Tasty Minstrel Games'],
        ['name' => 'Trefl'],
        ['name' => 'What the Frog'],
        ['name' => 'Zielona Sowa'],
    ];

    public function run(): void
    {
        DB::table('publishers')->insert($this->publishers);
    }
}
