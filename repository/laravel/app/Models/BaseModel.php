<?php

namespace App\Models;

use Str;
use Illuminate\Database\Eloquent\Model;
use App\Http\Service\GenerateUUIDService;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @template T
 */
class BaseModel extends Model
{
    use HasFactory;

    /**
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.PropertyTypeHint.MissingNativeTypeHint
     * @var array<string>
     */
    protected $guarded = [];

    /**
     * Bootstrap the model and its traits.
     */
    protected static function boot(): void
    {
        parent::boot();
        app(GenerateUUIDService::class)->handle(new BaseModel());
    }

    protected static function registerSlugGenerator(): void
    {
        static::saving(fn ($model) => $model->slug = Str::slug($model->title));
    }
}
