<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Http\Service\PasswordResetTokenGeneratorService;

class PasswordReset extends Model
{
    use HasFactory;

    /**
     * The primary key for the model.
     *
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.PropertyTypeHint.MissingNativeTypeHint
     * @var string $primaryKey
     */
    protected $primaryKey = 'email';

    /**
     * The attributes that are mass assignable.
     *
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.PropertyTypeHint.MissingNativeTypeHint
     * @var array<string>
     */
    protected $fillable = ['email'];

    /**
     * The name of the "updated at" column.
     */
    const UPDATED_AT = null;

    /**
     * @throws \Exception
     */
    protected static function boot(): void
    {
        parent::boot();

        app(PasswordResetTokenGeneratorService::class)->handle(new PasswordReset());
    }
}
