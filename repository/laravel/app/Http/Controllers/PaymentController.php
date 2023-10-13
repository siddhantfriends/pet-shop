<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\JsonResponse;
use App\Http\Service\PaymentService;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Requests\Payment\PaymentIndexRequest;
use App\Http\Requests\Payment\PaymentStoreRequest;
use App\Http\Requests\Payment\PaymentUpdateRequest;
use App\Http\Resources\Payment\PaymentShowResource;
use App\Http\Resources\Payment\PaymentStoreResource;
use App\Http\Resources\Payment\PaymentUpdateResource;
use App\Http\Resources\Payment\PaymentDestroyResource;
use App\Http\Resources\Payment\PaymentIndexCollection;

class PaymentController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/v1/payments",
     *     tags={"Payments"},
     *     summary="List all payments",
     *     description="Test Description",
     *     operationId="payments-listing",
     *     security={{"bearerAuth":{}}},
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
    public function index(PaymentIndexRequest $request, PaymentService $service): JsonResponse
    {
        $response = new PaymentIndexCollection($service->filter($request));

        return response()->json($response->resource);
    }

    /**
     * @OA\Post(
     *     path="/api/v1/payment/create",
     *     tags={"Payments"},
     *     summary="Create a new payment",
     *     description="Test Description",
     *     operationId="payments-create",
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/x-www-form-urlencoded",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="type",
     *                     type="string",
     *                     description="Payment type",
     *                     enum={"credit_card", "cash_on_delivery", "bank_transfer"}
     *                 ),
     *                 @OA\Property(
     *                     property="details",
     *                     type="object",
     *                     description="Review documentation for the payment type JSON format",
     *                 ),
     *                 required={"type", "details"}
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
    public function store(PaymentStoreRequest $request, PaymentService $service): JsonResource
    {
        $payments = $service->store($request);
        return new PaymentStoreResource($payments->fresh());
    }

    /**
     * @OA\Get(
     *     path="/api/v1/payment/{uuid}",
     *     tags={"Payments"},
     *     summary="Fetch a payment",
     *     description="Test Description",
     *     operationId="payments-read",
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
     * Display the specified resource.
     */
    public function show(Payment $payment): JsonResource
    {
        return new PaymentShowResource($payment);
    }

    /**
     * @OA\Put(
     *     path="/api/v1/payment/{uuid}",
     *     tags={"Payments"},
     *     summary="Update an existing payment",
     *     description="Test Description",
     *     operationId="payments-update",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="uuid",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/x-www-form-urlencoded",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="type",
     *                     type="string",
     *                     description="Payment type",
     *                     enum={"credit_card", "cash_on_delivery", "bank_transfer"}
     *                 ),
     *                 @OA\Property(
     *                     property="details",
     *                     type="object",
     *                     description="Review documentation for the payment type JSON format",
     *                 ),
     *                 required={"type", "details"}
     *             )
     *         )
     *     ),
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
    public function update(PaymentUpdateRequest $request, Payment $payment, PaymentService $service): JsonResource
    {
        $service->update($request, $payment);
        return new PaymentUpdateResource($payment->fresh());
    }

    /**
     * @OA\Delete(
     *     path="/api/v1/payment/{uuid}",
     *     tags={"Payments"},
     *     summary="delete an existing payment",
     *     description="Test Description",
     *     operationId="payments-delete",
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
    public function destroy(Payment $payment, PaymentService $service): JsonResource
    {
        $service->destroy($payment);

        return new PaymentDestroyResource([]);
    }
}
