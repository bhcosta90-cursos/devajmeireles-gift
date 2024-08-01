<?php

declare(strict_types = 1);

namespace App\Models;

use App\Casts\FloatToIntCast;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\{Model, SoftDeletes};

class Item extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'category_id',
        'reference',
        'quantity',
        'is_active',
        'signed_at',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'signed_at' => 'timestamp',
            'price'     => FloatToIntCast::class,
        ];
    }
}
