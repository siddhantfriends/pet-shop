<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin \App\Models\PasswordReset
 */
class ForgotPasswordResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter
     * @return array<string, string>
     */
    public function toArray(Request $request): array
    {
        return JsonResponse::response([
            'reset_token' => $this->token,
        ]);
    }
}
