<?php

declare(strict_types = 1);

namespace App\Models;

use App\Models\Trait\Search;
use Cache;
use Illuminate\Database\Eloquent\{Model, SoftDeletes};
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Signature extends Model
{
    use SoftDeletes;
    use HasFactory;
    use Search;

    protected $fillable = [
        'name',
        'presence_id',
        'item_id',
        'created_at',
        'observation',
        'phone',
    ];

    protected const CACHE_AVATAR = 'v1';

    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class);
    }

    public function avatar(): string
    {
        return Cache::rememberForever(
            self::CACHE_AVATAR . '-signature-avatar-' . md5($this->name),
            fn () => 'https://ui-avatars.com/api/?name=' . $this->name . '&background=e63f66&color=fff'
        );
    }
}
