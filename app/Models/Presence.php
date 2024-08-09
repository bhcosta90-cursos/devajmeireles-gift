<?php

declare(strict_types = 1);

namespace App\Models;

use Illuminate\Database\Eloquent\{Model, SoftDeletes};

class Presence extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'quantity',
        'is_confirmed',
    ];
}
