<?php

namespace Tests\Feature\AboutMePage;

use Tests\TestCase;

class AboutMePageTest extends TestCase
{
    public function test_show_page_about_me(): void
    {
        $this->get(route('about'))->assertStatus(200);
    }

    public function test_page_about_me_has_sections(): void
    {
        $response = $this->get(route('about'));

        $response->assertSee('Na stronie:');
        $response->assertSee('Zawodowo:');
        $response->assertSee('W czasie wolnym:');
        $response->assertSee('Inne zajawki:');
    }
}
