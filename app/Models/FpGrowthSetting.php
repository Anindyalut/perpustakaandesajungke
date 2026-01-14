<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FpGrowthSetting extends Model
{
    protected $table = 'fp_growth_settings'; // ⬅️ INI KUNCINYA

    protected $fillable = [
        'min_support'
    ];
}
