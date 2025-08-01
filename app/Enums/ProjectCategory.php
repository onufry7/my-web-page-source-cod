<?php

namespace App\Enums;

enum ProjectCategory: string
{
    case Coding = 'coding';
    case Games = 'games';
    case Ciphers = 'ciphers';
    case Others = 'others';

    public function label(): string
    {
        return match ($this) {
            self::Coding => 'Coding',
            self::Games => 'Board games',
            self::Ciphers => 'Ciphers',
            self::Others => 'Others',
        };
    }
}
