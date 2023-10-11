<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JwtToken extends Model
{
    use HasFactory;

    /**
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.PropertyTypeHint.MissingNativeTypeHint
     * @var array<string>
     */
    protected $guarded = [];

    /**
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.PropertyTypeHint.MissingNativeTypeHint
     * @var array<string, string>
     */
    protected $casts = [
        'restrictions' => 'json',
        'permissions' => 'json',
    ];

    public const TOKEN_TITLE_PERSONAL = 'Personal Access Token';
    public const TOKEN_TITLE_ADMIN = 'Admin Access Token';

    public const RESTRICTIONS_PERSONAL = [
        'scopes' => [
            'admin-access',
        ],
    ];

    public const RESTRICTIONS_ADMIN = [
        'scopes' => [
            'user-access',
        ],
    ];

    public const PERMISSIONS_PERSONAL = [
        'scopes' => [
            'user-access',
        ],
    ];

    public const PERMISSIONS_ADMIN = [
        'scopes' => [
            'admin-access',
        ],
    ];
}
