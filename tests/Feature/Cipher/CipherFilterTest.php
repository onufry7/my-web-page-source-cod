<?php

namespace Tests\Feature\Cipher;

use App\Models\Cipher;

class CipherFilterTest extends CipherTestCase
{
    public function test_cipher_check_name_filter_is_correct(): void
    {
        Cipher::create([
            'name' => 'Cezara',
            'sub_name' => 'cesarski',
            'slug' => 'cezara',
        ]);

        Cipher::create([
            'name' => 'Nihilistów',
            'sub_name' => 'Venusjan',
            'slug' => 'nihilistow',
        ]);

        Cipher::create([
            'name' => 'Polibiusza',
            'slug' => 'polibiusza',
        ]);

        $route = route($this->routeIndex, ['nazwa' => 'cezara']);

        $response = $this->get($route);

        $response->assertStatus(200)
            ->assertSeeText('Cezara')
            ->assertDontSeeText('Nihilistów')
            ->assertDontSeeText('Polibiusza')
            ->assertDontSeeText(__('No ciphers'));
    }

    public function test_cipher_check_sub_name_filter_is_correct(): void
    {
        Cipher::create([
            'name' => 'Cezara',
            'sub_name' => 'cesarski',
            'slug' => 'cezara',
        ]);

        Cipher::create([
            'name' => 'Nihilistów',
            'sub_name' => 'Venusjan',
            'slug' => 'nihilistow',
        ]);

        Cipher::create([
            'name' => 'Polibiusza',
            'slug' => 'polibiusza',
        ]);

        $route = route($this->routeIndex, ['nazwa' => 'cesarski']);

        $response = $this->get($route);

        $response->assertStatus(200)
            ->assertSeeText('Cezara')
            ->assertDontSeeText('Nihilistów')
            ->assertDontSeeText('Polibiusza')
            ->assertDontSeeText(__('No ciphers'));
    }

    public function test_cipher_filter_is_incorrect(): void
    {
        Cipher::create([
            'name' => 'Cezara',
            'sub_name' => 'cesarski',
            'slug' => 'cezara',
        ]);

        Cipher::create([
            'name' => 'Nihilistów',
            'sub_name' => 'Venusjan',
            'slug' => 'nihilistow',
        ]);

        Cipher::create([
            'name' => 'Polibiusza',
            'slug' => 'polibiusza',
        ]);

        $route = route($this->routeIndex, ['nazwa' => 'No name']);

        $response = $this->get($route);

        $response->assertStatus(200)
            ->assertSeeText(__('No ciphers'))
            ->assertDontSeeText('Nihilistów')
            ->assertDontSeeText('Polibiusza')
            ->assertDontSeeText(__('Cezara'));
    }

    public function test_cipher_filter_is_empty(): void
    {
        Cipher::create([
            'name' => 'Cezara',
            'sub_name' => 'cesarski',
            'slug' => 'cezara',
        ]);

        Cipher::create([
            'name' => 'Nihilistów',
            'sub_name' => 'Venusjan',
            'slug' => 'nihilistow',
        ]);

        Cipher::create([
            'name' => 'Polibiusza',
            'slug' => 'polibiusza',
        ]);

        $route = route($this->routeIndex, ['nazwa' => '']);

        $response = $this->get($route);

        $response->assertStatus(200)
            ->assertSeeText('Cezara')
            ->assertSeeText('Nihilistów')
            ->assertSeeText('Polibiusza')
            ->assertDontSeeText(__('No ciphers'));
    }
}
