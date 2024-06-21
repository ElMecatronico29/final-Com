<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Race extends Model
{
    protected $fillable = ['start_time','name', 'creator','jugadorActual', 'players','started','endGame'];

    protected $casts = [
        'players' => 'array', // Casting players as array
    ];
    use HasFactory;
}
