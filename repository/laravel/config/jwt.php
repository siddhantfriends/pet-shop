<?php

return [
    'private' => env('JWT_PRIVATE', storage_path('app/jwt/private.pem')),
    'public' => env('JWT_PUBLIC', storage_path('app/public/public.pem')),
];
