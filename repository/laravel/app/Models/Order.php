<?php

namespace App\Models;

use App\Http\Service\GenerateUUIDService;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @template T
 *
 * @extends BaseModel<T>
 */
class Order extends BaseModel
{
    use HasFactory;

    protected static function boot(): void
    {
        parent::boot();

        app(GenerateUUIDService::class)->handle(new Order());
    }

    public function getRouteKeyName(): string
    {
        return 'uuid';
    }
}
