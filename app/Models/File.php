<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Facades\Storage;

class File extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'path', 'model_id', 'model_type'];

    public function model(): MorphTo
    {
        return $this->morphTo();
    }

    public function getSize(bool $inMB = false): string
    {
        if (!empty($this->path) && Storage::disk('public')->exists($this->path)) {
            $sizeInKb = Storage::disk('public')->size($this->path) / 1024;

            return $inMB
                ? number_format(round($sizeInKb / 1024, 2), 2, ',', '.') . ' MB'
                : number_format(round($sizeInKb, 2), 2, ',', '.') . ' KB';
        }

        return '0 KB';
    }

    public function getNameWithModelName(): string
    {
        if (!is_null($this->model) && !empty($this->model->name)) {
            return $this->model->name . ' - ' . $this->name;
        }

        return $this->name;
    }
}
