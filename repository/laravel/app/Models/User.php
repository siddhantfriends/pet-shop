<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Notifications\Notifiable;
use App\Http\Service\GenerateUUIDService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.PropertyTypeHint.MissingNativeTypeHint
     * @var array<string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'is_admin',
        'email',
        'email_verified_at',
        'password',
        'avatar',
        'address',
        'phone_number',
        'is_marketing',
        'last_login_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.PropertyTypeHint.MissingNativeTypeHint
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
    ];

    /**
     * The attributes that should be cast.
     *
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.PropertyTypeHint.MissingNativeTypeHint
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Bootstrap the model and its traits.
     */
    protected static function boot(): void
    {
        parent::boot();
        app(GenerateUUIDService::class)->handle(new User());
    }

    /**
     * Returns true if the user is an admin else false.
     */
    public function isAdmin(): bool
    {
        return $this->is_admin;
    }

    /**
     * Returns true if the user is NOT an admin else false.
     */
    public function isNotAdmin(): bool
    {
        return !$this->is_admin;
    }

    public function avatar(): BelongsTo
    {
        return $this->belongsTo(File::class, 'uuid', 'avatar');
    }

    public function scopeUsers(Builder $query): void
    {
        $query->whereIsAdmin(0);
    }

    public function scopeSortBy(Builder $query, string $column, ?string $direction = 'asc'): void
    {
        $query->orderBy($column, $direction);
    }

    /**
     * @param array<string, string> $options
     */
    public function scopeWhereFilters(Builder $query, array $options): void
    {
        array_walk(
            $options,
            fn ($value, $key) => $query->when(
                $value,
                fn () => $query->where($key, $value)
            )
        );
    }

    /**
     * @param array<string, string> $options
     */
    public function scopeWhereLikeFilters(Builder $query, array $options): void
    {
        array_walk(
            $options,
            fn ($value, $key) => $query->when(
                $value,
                fn () => $query->where($key, 'LIKE', "%{$value}%")
            )
        );
    }
}
