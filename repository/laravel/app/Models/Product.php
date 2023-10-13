<?php

namespace App\Models;

use App\Http\Service\GenerateUUIDService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends BaseModel
{
    use HasFactory;

    /**
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.PropertyTypeHint.MissingNativeTypeHint
     * @var array<string, string>
     */
    protected $casts = [
        'metadata' => 'json',
    ];

    protected static function boot(): void
    {
        parent::boot();

        app(GenerateUUIDService::class)->handle(new Product());
    }

    public function getRouteKeyName(): string
    {
        return 'uuid';
    }

    public function scopeSortBy(Builder $query, string $column, ?string $direction = 'asc'): void
    {
        $query->orderBy($column, $direction);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_uuid', 'uuid');
    }
}
