<?php

namespace App\Collections;

use Illuminate\Support\Collection;

class CipherCollection extends Collection
{
    public function __get($key)
    {
        return $this->offsetGet($key);
    }
}
