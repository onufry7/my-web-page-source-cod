<?php

namespace App\Exceptions;

use Exception;
use Throwable;

class FileException extends Exception
{
    protected string $customMessage;

    public function __construct(string $customMessage = '', int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($customMessage, $code, $previous);
        $this->customMessage = $customMessage;
    }

    public function getCustomMessage(): string
    {
        return $this->customMessage;
    }
}
