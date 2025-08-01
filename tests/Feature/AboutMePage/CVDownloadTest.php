<?php

namespace Tests\Feature\AboutMePage;

use Exception;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Mockery;
use Tests\AuthenticatedTestCase;

class CVDownloadTest extends AuthenticatedTestCase
{
    public function test_download_cv(): void
    {
        Storage::fake('public');
        $cv = UploadedFile::fake()->create('cv.pdf', 100, 'application/pdf');
        $cv->storeAs('documents/cv', 'burnejko-cv.pdf', 'public');
        $route = route('cv.download');

        $this->get($route)->assertStatus(200)->assertHeader('content-type', 'application/pdf');
        $this->actingAs($this->user)->get($route)->assertStatus(200)->assertHeader('content-type', 'application/pdf');
        $this->actingAs($this->admin)->get($route)->assertStatus(200)->assertHeader('content-type', 'application/pdf');
    }

    public function test_invoke_method_handles_throwable(): void
    {
        $storageMock = Mockery::mock(Filesystem::class);
        $storageMock->shouldReceive('mimeType')
            ->once()
            ->andThrow(new Exception('Storage error!'));

        $storageMock->shouldReceive('download')->never();

        Storage::shouldReceive('disk')
            ->with('public')
            ->andReturn($storageMock);

        $response = $this->get(route('cv.download'));

        $response->assertRedirect();
        $response->assertSessionHas('flash.banner', __('Failed download CV file!'));
        $response->assertSessionHas('flash.bannerStyle', 'danger');
    }
}
