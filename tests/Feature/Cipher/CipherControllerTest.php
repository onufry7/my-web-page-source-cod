<?php

namespace Tests\Feature\Cipher;

use App\Models\Cipher;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class CipherControllerTest extends CipherTestCase
{
    public function test_cipher_index_method_render_correct_view_and_info_if_does_not_have_records(): void
    {
        $route = route($this->routeIndex);

        $this->get($route)->assertOk()
            ->assertViewIs('cipher.index')
            ->assertSeeText(__('No ciphers'));
    }

    public function test_cipher_index_method_render_correct_view_and_info_if_have_records(): void
    {
        $cipher = Cipher::factory()->create();
        $route = route($this->routeIndex);

        $this->get($route)->assertOk()
            ->assertViewIs('cipher.index')
            ->assertSeeText(Str::title($cipher->name))
            ->assertDontSeeText(__('No ciphers'));
    }

    public function test_cipher_show_method_render_correct_view(): void
    {
        $cipher = Cipher::factory()->create();
        $route = route($this->routeShow, $cipher);

        $this->get($route)->assertOk()
            ->assertViewIs('cipher.show')
            ->assertViewHas('cipher', $cipher)
            ->assertViewHas('adjacent');
    }

    public function test_cipher_create_method_render_correct_view(): void
    {
        $route = route($this->routeCreate);

        $this->actingAs($this->admin)->get($route)->assertOk()
            ->assertViewIs('cipher.create');
    }

    public function test_cipher_edit_method_render_correct_view(): void
    {
        $cipher = Cipher::factory()->create();
        $route = route($this->routeEdit, $cipher);

        $this->actingAs($this->admin)->get($route)->assertOk()
            ->assertViewIs('cipher.edit')
            ->assertViewHas('cipher', $cipher);
    }

    public function test_cipher_store_method_creates_a_record(): void
    {
        $file = UploadedFile::fake()->create('template.htm')->size(100);
        file_put_contents($file, '<div>Test</div><p>Content</p><b>File</b>');
        $newCipher = Cipher::factory()->make([
            'name' => 'Name',
            'slug' => 'name',
            'file' => $file,
        ])->toArray();

        $response = $this->actingAs($this->admin)->post(route($this->routeStore), $newCipher);

        $cipher = Cipher::first();

        $response->assertRedirectToRoute($this->routeShow, $cipher)->assertSessionHasNoErrors();
        $this->assertDatabaseHas('ciphers', [
            'name' => 'Name',
            'content' => '<div>Test</div><p>Content</p><b>File</b>',
        ]);
    }

    public function test_cipher_update_method_updates_the_record(): void
    {
        $cipher = Cipher::factory()->create([
            'name' => 'Old name',
            'slug' => 'old-name',
        ]);
        $updateCipher = Cipher::factory()->make([
            'name' => 'New name',
            'slug' => 'new-name',
        ]);
        $route = route($this->routeUpdate, $cipher);

        $response = $this->actingAs($this->admin)->put($route, $updateCipher->toArray());

        $response->assertRedirectToRoute($this->routeShow, $updateCipher)->assertSessionHasNoErrors();
        $this->assertDatabaseMissing('ciphers', ['name' => 'Old name']);
        $this->assertDatabaseHas('ciphers', ['name' => 'New name']);
    }

    public function test_cipher_update_method_updated_file_in_record(): void
    {
        $file = UploadedFile::fake()->create('template.htm')->size(100);
        file_put_contents($file, '<div>Test</div><p>Content</p><b>File</b>');
        $cipher = Cipher::factory()->create();
        $updateCipher = Cipher::factory()->make([
            'file' => $file,
        ]);
        $route = route($this->routeUpdate, $cipher);

        $response = $this->actingAs($this->admin)->put($route, $updateCipher->toArray());

        $response->assertRedirectToRoute($this->routeShow, $updateCipher)->assertSessionHasNoErrors();
        $this->assertDatabaseHas('ciphers', ['content' => '<div>Test</div><p>Content</p><b>File</b>']);
    }

    public function test_cipher_destroy_method_deletes_the_record(): void
    {
        $cipher = Cipher::factory()->create();
        $route = route($this->routeDestroy, $cipher);

        $response = $this->actingAs($this->admin)->delete($route);

        $response->assertRedirectToRoute($this->routeIndex)->assertSessionHasNoErrors();
        $this->assertDatabaseMissing('ciphers', ['id' => $cipher->id]);
    }

    public function test_cipher_entry_route_render_correct_view(): void
    {
        $route = route($this->routeEntry);

        $this->get($route)->assertOk()
            ->assertViewIs('cipher.entry')
            ->assertSeeText(__('Entry'));
    }

    public function test_cipher_does_not_show_adjacent_ciphers_if_they_do_not_exist(): void
    {
        $cipher = Cipher::factory()->create();

        $response = $this->get(route($this->routeShow, $cipher));

        $adjacent = $response->original->getData()['adjacent'];

        $this->assertNull($adjacent->previous);
        $this->assertNull($adjacent->next);
    }

    public function test_cipher_shows_adjacent_ciphers_if_it_has_any(): void
    {
        $cipherPrevious = Cipher::factory()->create();
        $cipherCurrent = Cipher::factory()->create();
        $cipherNext = Cipher::factory()->create();

        $response = $this->get(route($this->routeShow, $cipherCurrent));

        $adjacent = $response->original->getData()['adjacent'];

        $this->assertEquals($cipherPrevious->name, $adjacent->previous->name);
        $this->assertEquals($cipherNext->name, $adjacent->next->name);
    }

    public function test_cipher_catalog_method_render_correct_view_and_info_if_does_not_have_records(): void
    {
        $route = route($this->routeCatalog);

        $this->get($route)->assertOk()
            ->assertViewIs('cipher.catalog')
            ->assertSeeText(__('Alphabetical list of ciphers'))
            ->assertSeeText(__('No ciphers'));
    }

    public function test_cipher_catalog_method_render_correct_view_and_info_if_have_records(): void
    {
        $cipher = Cipher::factory()->create();
        $route = route($this->routeCatalog);

        $this->get($route)->assertOk()
            ->assertViewIs('cipher.catalog')
            ->assertSeeText($cipher->name)
            ->assertSeeText(__('Alphabetical list of ciphers'))
            ->assertDontSeeText(__('No ciphers'));
    }
}
