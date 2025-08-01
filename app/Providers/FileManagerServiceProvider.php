<?php

namespace App\Providers;

use App\Interfaces\FileManager;
use App\Services\StorageFileManager;
use Illuminate\Support\ServiceProvider;

class FileManagerServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(FileManager::class, StorageFileManager::class);
    }
}
