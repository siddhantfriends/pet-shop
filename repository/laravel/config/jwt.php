<?php

return [
    /**
     * Private key should never be shared
     */
    'private' => env('JWT_PRIVATE', storage_path('app/jwt/private.pem')),

    /**
     * Public key can be shared
     */
    'public' => env('JWT_PUBLIC', storage_path('app/public/public.pem')),

    /**
     * JWT will expire after the given time
     */
    'expires_after' => env('JWT_EXPIRES_AFTER', '+2 hours'),
];
