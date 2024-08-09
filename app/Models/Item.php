<?php

declare(strict_types = 1);

namespace App\Models;

use App\Casts\FloatToIntCast;
use App\Models\Trait\Search;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\{Builder, Model, Relations\HasMany, SoftDeletes};

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
        'last_signed_at',
        'price',
        'is_quotable',
        'active',
        'quotable',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function signatures(): HasMany
    {
        return $this->hasMany(Signature::class);
    }

    protected function casts(): array
    {
        return [
            'is_active'      => 'boolean',
            'is_quotable'    => 'boolean',
            'last_signed_at' => 'timestamp',
            'price'          => FloatToIntCast::class,
        ];
    }

    public function scopeActive(Builder $query): void
    {
        $query->where('is_active', true);
    }

    public function available(): bool
    {
        return $this->signatures()->count() < $this->quantity;
    }

    public function priceQuoted(int $quantity, bool $realQuantity = true): float
    {
        return $this->price / ($realQuantity ? $this->availableQuantity() : $this->quantity) * $quantity;
    }

    public function availableQuantity(): int
    {
        return ($this->quantity - $this->signatures()->count());
    }
}
