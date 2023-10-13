<?php

namespace App\Http\Controllers;

use App\Models\OrderStatus;
use Illuminate\Http\JsonResponse;
use App\Http\Service\OrderStatusService;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Requests\OrderStatus\OrderStatusIndexRequest;
use App\Http\Requests\OrderStatus\OrderStatusStoreRequest;
use App\Http\Requests\OrderStatus\OrderStatusUpdateRequest;
use App\Http\Resources\OrderStatus\OrderStatusShowResource;
use App\Http\Resources\OrderStatus\OrderStatusStoreResource;
use App\Http\Resources\OrderStatus\OrderStatusUpdateResource;
use App\Http\Resources\OrderStatus\OrderStatusDestroyResource;
use App\Http\Resources\OrderStatus\OrderStatusIndexCollection;

class OrderStatusController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/v1/order-statuses",
     *     tags={"Order Statuses"},
     *     summary="List all order-statuses",
     *     description="Test Description",
     *     operationId="order-statuses-listing",
     *     @OA\Parameter(
     *         name="page",
     *         in="query",
     *         required=false,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="limit",
     *         in="query",
     *         required=false,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="sortBy",
     *         in="query",
     *         required=false,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *      @OA\Parameter(
     *         name="desc",
     *         in="query",
     *         required=false,
     *         @OA\Schema(
     *             type="boolean"
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="OK"
     *     ),
     *     @OA\Response(
     *         response="401",
     *         description="Unauthorized"
     *     ),
     *     @OA\Response(
     *         response="404",
     *         description="Page not found"
     *     ),
     *     @OA\Response(
     *         response="422",
     *         description="Unprocessable Entity"
     *     ),
     *     @OA\Response(
     *         response="500",
     *         description="Internal server error"
     *     )
     * )
     *
     * Display a listing of the resource.
     */
    public function index(OrderStatusIndexRequest $request, OrderStatusService $service): JsonResponse
    {
        $response = new OrderStatusIndexCollection($service->filter($request));

        return response()->json($response->resource);
    }

    /**
     * @OA\Post(
     *     path="/api/v1/order-status/create",
     *     tags={"Order Statuses"},
     *     summary="Create a new order status",
     *     description="Test Description",
     *     operationId="order-statuses-create",
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/x-www-form-urlencoded",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="title",
     *                     type="string",
     *                 ),
     *                 required={"title"}
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="OK"
     *     ),
     *     @OA\Response(
     *         response="401",
     *         description="Unauthorized"
     *     ),
     *     @OA\Response(
     *         response="404",
     *         description="Page not found"
     *     ),
     *     @OA\Response(
     *         response="422",
     *         description="Unprocessable Entity"
     *     ),
     *     @OA\Response(
     *         response="500",
     *         description="Internal server error"
     *     )
     * )
     *
     * Store a newly created resource in storage.
     */
    public function store(OrderStatusStoreRequest $request, OrderStatusService $service): JsonResource
    {
        $orderStatus = $service->store($request);
        return new OrderStatusStoreResource($orderStatus->fresh());
    }

    /**
     * @OA\Get(
     *     path="/api/v1/order-status/{uuid}",
     *     tags={"Order Statuses"},
     *     summary="Fetch a order status",
     *     description="Test Description",
     *     operationId="order-statuses-read",
     *     @OA\Parameter(
     *         name="uuid",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="OK"
     *     ),
     *     @OA\Response(
     *         response="401",
     *         description="Unauthorized"
     *     ),
     *     @OA\Response(
     *         response="404",
     *         description="Page not found"
     *     ),
     *     @OA\Response(
     *         response="422",
     *         description="Unprocessable Entity"
     *     ),
     *     @OA\Response(
     *         response="500",
     *         description="Internal server error"
     *     )
     * )
     *
     * Display the specified resource.
     */
    public function show(OrderStatus $orderStatus): JsonResource
    {
        return new OrderStatusShowResource($orderStatus);
    }

    /**
     * @OA\Put(
     *     path="/api/v1/order-status/{uuid}",
     *     tags={"Order Statuses"},
     *     summary="Update an existing order status",
     *     description="Test Description",
     *     operationId="order-statuses-update",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="uuid",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *             mediaType="application/x-www-form-urlencoded",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="title",
     *                     type="string",
     *                 ),
     *                 required={"title"}
     *             )
     *         )
     *    ),
     *    @OA\Response(
     *         response="200",
     *         description="OK"
     *     ),
     *     @OA\Response(
     *         response="401",
     *         description="Unauthorized"
     *     ),
     *     @OA\Response(
     *         response="404",
     *         description="Page not found"
     *     ),
     *     @OA\Response(
     *         response="422",
     *         description="Unprocessable Entity"
     *     ),
     *     @OA\Response(
     *         response="500",
     *         description="Internal server error"
     *     )
     * )
     *
     * Update the specified resource in storage.
     */
    public function update(
        OrderStatusUpdateRequest $request,
        OrderStatus $orderStatus,
        OrderStatusService $service
    ): JsonResource {
        $service->update($request, $orderStatus);
        return new OrderStatusUpdateResource($orderStatus->fresh());
    }

    /**
     * @OA\Delete(
     *     path="/api/v1/order-status/{uuid}",
     *     tags={"Order Statuses"},
     *     summary="delete an existing order status",
     *     description="Test Description",
     *     operationId="order-statuses-delete",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="uuid",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="OK"
     *     ),
     *     @OA\Response(
     *         response="401",
     *         description="Unauthorized"
     *     ),
     *     @OA\Response(
     *         response="404",
     *         description="Page not found"
     *     ),
     *     @OA\Response(
     *         response="422",
     *         description="Unprocessable Entity"
     *     ),
     *     @OA\Response(
     *         response="500",
     *         description="Internal server error"
     *     )
     * )
     *
     * Remove the specified resource from storage.
     */
    public function destroy(OrderStatus $orderStatus, OrderStatusService $service): JsonResource
    {
        $service->destroy($orderStatus);

        return new OrderStatusDestroyResource([]);
    }
}
