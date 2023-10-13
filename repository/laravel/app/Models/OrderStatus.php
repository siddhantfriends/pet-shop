<?php

namespace App\Models;

use App\Http\Service\GenerateUUIDService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @template T
 *
 * @extends BaseModel<T>
 */
class OrderStatus extends BaseModel
{
    use HasFactory;

    protected static function boot(): void
    {
        parent::boot();

        app(GenerateUUIDService::class)->handle(new OrderStatus());
    }

    public function getRouteKeyName(): string
    {
        return 'uuid';
    }

    public function scopeSortBy(Builder $query, string $column, ?string $direction = 'asc'): void
    {
        $query->orderBy($column, $direction);
    }
}
