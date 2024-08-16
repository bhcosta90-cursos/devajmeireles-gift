<?php

declare(strict_types = 1);

namespace App\Models;

use Illuminate\Database\Eloquent\{Factories\HasFactory, Model, SoftDeletes};

class Presence extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $fillable = [
        'name',
        'quantity',
        'is_confirmed',
    ];
}
