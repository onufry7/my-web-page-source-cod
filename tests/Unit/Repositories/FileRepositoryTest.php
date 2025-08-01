<?php

namespace Tests\Unit\Repositories;

use App\Exceptions\FileException;
use App\Http\Requests\FileStoreRequest;
use App\Repositories\FileRepository;
use App\Services\FileService;
use Mockery;
use Tests\TestCase;

class FileRepositoryTest extends TestCase
{
    public function test_it_throws_exception_when_path_is_invalid_or_null(): void
    {
        $request = Mockery::mock(FileStoreRequest::class);
        $request->shouldReceive('validated')->andReturn([]);
        $request->shouldReceive('file')->with('file')->andReturn(null);
        $request->shouldReceive('hasFile')->with('file')->andReturn(true);

        $service = Mockery::mock(FileService::class);
        $service->shouldReceive('storeFile')->andReturn(false);

        $repository = new FileRepository($service instanceof FileService ? $service : null);

        $this->expectException(FileException::class);
        $this->expectExceptionMessage('File path return null or false!');

        $repository->store($request instanceof FileStoreRequest ? $request : null);
    }
}
