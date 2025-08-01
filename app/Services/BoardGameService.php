<?php

namespace App\Services;

use App\Exceptions\FileException;
use App\Interfaces\FileManager;
use App\Models\BoardGame;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Throwable;

class BoardGameService
{
    private const IMG_BOX_FOLDER = 'board-games/boxes';
    private const INSTRUCTION_FOLDER = 'board-games/instructions';

    private FileManager $fileManager;

    public function __construct(FileManager $fileManager)
    {
        $this->fileManager = $fileManager;
    }

    public function storeBoxImage(UploadedFile $uploadFile): ?string
    {
        try {
            $path = $this->fileManager->saveFile($uploadFile, self::IMG_BOX_FOLDER);

            return ($path) ? $path : null;
        } catch (Throwable $th) {
            throw new FileException(__('Box image saving error.'));
        }
    }

    public function storeInstruction(UploadedFile $uploadFile): ?string
    {
        try {
            $path = $this->fileManager->saveFile($uploadFile, self::INSTRUCTION_FOLDER);

            return ($path) ? $path : null;
        } catch (Throwable $th) {
            throw new FileException(__('Instruction file saving error.'));
        }
    }

    public function deleteBoxImage(string $file): bool
    {
        try {
            return $this->fileManager->deleteFile($file);
        } catch (Throwable $th) {
            throw new FileException(__('Box image deleting error.'));
        }
    }

    public function deleteInstruction(string $file): bool
    {
        try {
            return $this->fileManager->deleteFile($file);
        } catch (Throwable $th) {
            throw new FileException(__('Instruction file deleting error.'));
        }
    }

    public function deleteFolder(string $folder): bool
    {
        $directory = '/board-games/' . $folder;

        try {
            return $this->fileManager->deleteFolder($directory);
        } catch (Throwable $th) {
            throw new FileException(__('Game files deleting error.'));
        }
    }

    public function downloadInstruction(BoardGame $boardGame): StreamedResponse
    {
        if (is_null($boardGame->instruction) || !Storage::disk('public')->exists($boardGame->instruction)) {
            throw new FileException(__('No instruction.'));
        }

        $extension = pathinfo($boardGame->instruction, PATHINFO_EXTENSION);
        $fileName = Str::lower($boardGame->name) . ' - instrukcja.' . $extension;

        try {
            return $this->fileManager->downloadFile($boardGame->instruction, $fileName);
        } catch (Throwable $th) {
            throw new FileException(__('Instruction download error.'));
        }
    }

    public function titleForDynamicList(string $type): string
    {
        return match (mb_strtolower($type)) {
            'podstawowe-bez-wydawcy' => 'Base games without publisher',
            'bez-wydawcy' => 'Games without publisher',
            'bez-instrukcji' => 'Games without instruction',
            'zagrane' => 'Played',
            'niezagrane' => 'To play',
            'liczba-graczy' => 'Players count',
            'bez-insertu' => 'Needed insert',
            'do-koszulkowania' => 'To sleeve up',
            'do-malowania' => 'To painting',
            default => 'Games list',
        };
    }

    public function getPublishers(BoardGame $boardGame): array
    {
        return array_filter([
            'Publisher' => $boardGame->publisher,
            'Original publisher' => $boardGame->originalPublisher,
        ]);
    }

    public function relatedGames(BoardGame $boardGame): array
    {
        return match (true) {
            $boardGame->baseGame !== null => [
                'title' => 'Base',
                'games' => collect([$boardGame->baseGame]),
            ],

            $boardGame->expansions->isNotEmpty() => [
                'title' => 'Expansions',
                'games' => $boardGame->expansions,
            ],

            default => [],
        };
    }
}
