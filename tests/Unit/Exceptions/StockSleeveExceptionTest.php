<?php

namespace Tests\Unit\Exceptions;

use App\Exceptions\StockSleeveException;
use Exception;
use PHPUnit\Framework\TestCase;

class StockSleeveExceptionTest extends TestCase
{
    public function test_it_creates_a_custom_exception_with_message(): void
    {
        $message = 'This is a custom exception message';
        $exception = new StockSleeveException($message);

        $this->assertEquals($message, $exception->getCustomMessage());
    }

    public function test_it_creates_an_exception_with_default_message(): void
    {
        $exception = new StockSleeveException();

        $this->assertEquals('', $exception->getCustomMessage());
    }

    public function test_it_inherits_from_exception(): void
    {
        $exception = new StockSleeveException('Test message');

        $this->assertInstanceOf(Exception::class, $exception);
    }

    public function test_it_can_be_thrown_and_caught(): void
    {
        try {
            throw new StockSleeveException('This is a throwable exception');
        } catch (StockSleeveException $exception) {
            $this->assertInstanceOf(StockSleeveException::class, $exception);
            $this->assertEquals('This is a throwable exception', $exception->getMessage());
        }
    }
}
