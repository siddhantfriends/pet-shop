<?php

namespace App\Http\Resources\Payment;

use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Payment
 */
class PaymentUpdateResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter
     * @return array<string, string|object|null>
     */
    public function toArray(Request $request): array
    {
        return JsonResponse::response([
            'uuid' => $this->uuid,
            'type' => $this->type,
            'details' => $this->details,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);
    }
}
