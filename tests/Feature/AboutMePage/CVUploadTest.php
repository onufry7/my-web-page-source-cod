<?php

namespace Tests\Feature\AboutMePage;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\AuthenticatedTestCase;

class CVUploadTest extends AuthenticatedTestCase
{
    public function test_upload_form_access(): void
    {
        $route = route('cv.form');

        $this->get($route)->assertStatus(302);
        $this->actingAs($this->user)->get($route)->assertStatus(403);
        $this->actingAs($this->admin)->get($route)->assertStatus(200);
    }

    public function test_can_upload_cv(): void
    {
        Storage::fake('public');

        $response = $this->actingAs($this->admin)->post(route('cv.upload'), [
            'cv' => UploadedFile::fake()->create('cv.pdf', 100, 'application/pdf'),
        ]);

        $response->assertSessionHas('flash.banner', __('CV uploaded successfully.'));
        Storage::disk('public')->assertExists('documents/cv/burnejko-cv.pdf');
    }

    public function test_uploading_invalid_file_fails(): void
    {
        $response = $this->actingAs($this->admin)->post(route('cv.upload'), [
            'cv' => UploadedFile::fake()->create('invalid_file.txt', 100, 'text/plain'),
        ]);

        $response->assertStatus(302)->assertSessionHasErrors('cv');
    }
}
