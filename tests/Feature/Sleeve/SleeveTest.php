<?php

namespace Tests\Feature\Sleeve;

use App\Models\Sleeve;

class SleeveTest extends SleeveTestCase
{
    public function test_get_quantity_available_function_if_quantity_is_not_null(): void
    {
        $sleeve = new Sleeve();
        $sleeve->quantity_available = 10;

        $this->assertEquals(10, $sleeve->getQuantityAvailable());
    }

    public function test_get_quantity_available_function_if_quantity_is_null(): void
    {
        $sleeve = new Sleeve();

        $this->assertEquals(0, $sleeve->getQuantityAvailable());
    }

    public function test_get_full_name_function_return_correct_name(): void
    {
        $sleeve = new Sleeve();
        $sleeve->mark = 'Maydey';
        $sleeve->name = 'Classic';

        $expectedFullName = 'Maydey - Classic';
        $this->assertEquals($expectedFullName, $sleeve->getFullName());
    }

    public function test_get_size_function_correct_size(): void
    {
        $sleeve = new Sleeve();
        $sleeve->width = 63;
        $sleeve->height = 88;

        $this->assertEquals('63x88 mm', $sleeve->getSize());
    }
}
