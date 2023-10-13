<?php

namespace App\Http\Contracts;

use App\Models\Payment;
use App\Http\Requests\Payment\PaymentIndexRequest;
use App\Http\Requests\Payment\PaymentStoreRequest;
use App\Http\Requests\Payment\PaymentUpdateRequest;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface PaymentApiResource
{
    public function store(PaymentStoreRequest $request): Payment;
    public function update(PaymentUpdateRequest $request, Payment $model): void;
    public function destroy(Payment $model): void;
    public function filter(PaymentIndexRequest $request): LengthAwarePaginator;
}
