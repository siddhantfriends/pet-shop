<?php

namespace App\Http\Contracts;

use App\Models\OrderStatus;
use App\Http\Requests\OrderStatus\OrderStatusIndexRequest;
use App\Http\Requests\OrderStatus\OrderStatusStoreRequest;
use App\Http\Requests\OrderStatus\OrderStatusUpdateRequest;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface OrderStatusApiResource
{
    public function store(OrderStatusStoreRequest $request): OrderStatus;
    public function update(OrderStatusUpdateRequest $request, OrderStatus $model): void;
    public function destroy(OrderStatus $model): void;
    public function filter(OrderStatusIndexRequest $request): LengthAwarePaginator;
}
