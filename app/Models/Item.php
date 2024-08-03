<?php

declare(strict_types = 1);

namespace App\Models;

use App\Casts\FloatToIntCast;
use App\Models\Trait\Search;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\{Model, SoftDeletes};

class Item extends Model
{
    use SoftDeletes;
    use HasFactory;
    use Search;

    protected $fillable = [
        'name',
        'description',
        'category_id',
        'reference',
        'quantity',
        'is_active',
        'signed_at',
        'price',
        'is_quotable',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    protected function casts(): array
    {
        return [
            'is_active'   => 'boolean',
            'is_quotable' => 'boolean',
            'signed_at'   => 'timestamp',
            'price'       => FloatToIntCast::class,
        ];
    }
}
