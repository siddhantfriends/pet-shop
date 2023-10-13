<?php

namespace App\Http\Service;

use App\Models\OrderStatus;
use App\Http\Contracts\OrderStatusApiResource;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Http\Requests\OrderStatus\OrderStatusIndexRequest;
use App\Http\Requests\OrderStatus\OrderStatusStoreRequest;
use App\Http\Requests\OrderStatus\OrderStatusUpdateRequest;

class OrderStatusService implements OrderStatusApiResource
{
    public function store(OrderStatusStoreRequest $request): OrderStatus
    {
        return OrderStatus::create($request->only([
            'title',
        ]));
    }

    public function update(OrderStatusUpdateRequest $request, OrderStatus $model): void
    {
        $model->update($request->only([
            'title',
        ]));
    }

    public function destroy(OrderStatus $model): void
    {
        $category = OrderStatus::find($model->id);
        $category->delete();
    }

    public function filter(OrderStatusIndexRequest $request): LengthAwarePaginator
    {
        return OrderStatus::query()
            ->sortBy(
                $request->get('sortBy', 'id'),
                match ($request->get('desc', true)) {
                    true => 'desc', default => 'asc'
                },
            )->paginate(perPage: $request->get('limit', 10));
    }
}
