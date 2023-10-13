<?php

namespace App\Http\Service;

use App\Models\Payment;
use App\Http\Contracts\PaymentApiResource;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Http\Requests\Payment\PaymentIndexRequest;
use App\Http\Requests\Payment\PaymentStoreRequest;
use App\Http\Requests\Payment\PaymentUpdateRequest;

class PaymentService implements PaymentApiResource
{
    public function store(PaymentStoreRequest $request): Payment
    {
        return Payment::create($request->only([
            'type', 'details',
        ]));
    }

    public function update(PaymentUpdateRequest $request, Payment $payment): void
    {
        $payment->update($request->only([
            'type', 'details',
        ]));
    }

    public function destroy(Payment $model): void
    {
        $category = Payment::find($model->id);
        $category->delete();
    }

    public function filter(PaymentIndexRequest $request): LengthAwarePaginator
    {
        return Payment::query()
            ->sortBy(
                $request->get('sortBy', 'id'),
                match ($request->get('desc', true)) {
                    true => 'desc', default => 'asc'
                },
            )->paginate(perPage: $request->get('limit', 10));
    }
}
