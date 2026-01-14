<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FPGrowthResult extends Model
{
    protected $fillable = [
        'book_a',
        'book_b',
        'support',
        'confidence'
    ];
}

