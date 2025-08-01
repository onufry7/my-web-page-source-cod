<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CorrectSleeve extends Model
{
    use HasFactory;

    protected $fillable = ['sleeve_id', 'description', 'quantity_before', 'quantity_after'];

    public function sleeve(): BelongsTo
    {
        return $this->belongsTo(Sleeve::class);
    }
}
