<?php

declare(strict_types = 1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\{Model, SoftDeletes};

class Category extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'is_active',
    ];

    public function items(): HasMany
    {
        return $this->hasMany(Item::class);
    }

    public function scopeActive(): void
    {
        $this->where('is_active', true);
    }

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }
}
