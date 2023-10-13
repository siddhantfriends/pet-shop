<?php

namespace App\Models;

use App\Http\Service\GenerateUUIDService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends BaseModel
{
    use HasFactory;

    /**
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.PropertyTypeHint.MissingNativeTypeHint
     * @var array<string, string>
     */
    protected $casts = [
        'details' => 'json',
    ];

    protected static function boot(): void
    {
        parent::boot();

        app(GenerateUUIDService::class)->handle(new Payment());
    }

    public function getRouteKeyName(): string
    {
        return 'uuid';
    }

    public function scopeSortBy(Builder $query, string $column, ?string $direction = 'asc'): void
    {
        $query->orderBy($column, $direction);
    }

    public function isCreditCard(): bool
    {
        return $this->type === 'credit_card';
    }

    public function isBankTransfer(): bool
    {
        return $this->type === 'bank_transfer';
    }

    public function isCashOnDelivery(): bool
    {
        return $this->type === 'cash_on_delivery';
    }
}
