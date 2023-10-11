<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Http\Service\GenerateUUIDService;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class File extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.PropertyTypeHint.MissingNativeTypeHint
     * @var array<string>
     */
    protected $fillable = [
        'name',
        'path',
        'size',
        'type',
    ];

    /**
     * Bootstrap the model and its traits.
     * @throws \Exception
     */
    protected static function boot(): void
    {
        parent::boot();
        app(GenerateUUIDService::class)->handle(new File());
    }
}
