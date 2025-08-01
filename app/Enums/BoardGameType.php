<?php

namespace App\Enums;

enum BoardGameType: string
{
    case BaseGame = 'base';
    case Expansion = 'expansion';
    case MiniExpansion = 'mini';

    public function label(): string
    {
        return match ($this) {
            self::BaseGame => 'Base game',
            self::Expansion => 'Expansion',
            self::MiniExpansion => 'Mini expansion',
        };
    }
}
