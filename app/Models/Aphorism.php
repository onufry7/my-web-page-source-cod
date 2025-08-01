<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aphorism extends Model
{
    use HasFactory;

    protected $fillable = ['sentence', 'author'];
    public $timestamps = false;
}
