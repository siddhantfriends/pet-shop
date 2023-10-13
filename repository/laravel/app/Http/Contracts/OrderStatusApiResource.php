<?php

namespace App\Http\Contracts;

use App\Models\OrderStatus;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\Http\Requests\OrderStatus\OrderStatusIndexRequest;
use App\Http\Requests\OrderStatus\OrderStatusStoreRequest;
use App\Http\Requests\OrderStatus\OrderStatusUpdateRequest;

interface OrderStatusApiResource
{
    public function store(OrderStatusStoreRequest $request): OrderStatus;
    public function update(OrderStatusUpdateRequest $request, OrderStatus $model): void;
    public function destroy(OrderStatus $model): void;
    public function filter(OrderStatusIndexRequest $request): LengthAwarePaginator;
}
