<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Http\Service\UserService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UserEditRequest;
use App\Http\Resources\Admin\UserEditResource;
use Illuminate\Http\Resources\Json\JsonResource;

class UserEditController extends Controller
{
    /**
     * @OA\Put(
     *     path="/api/v1/admin/user-edit/{uuid}",
     *     tags={"Admin"},
     *     summary="Edit a User account",
     *     description="Test Description",
     *     operationId="admin-user-edit",
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
     *                     property="first_name",
     *                     type="string",
     *                     description="User firstname",
     *                 ),
     *                 @OA\Property(
     *                     property="last_name",
     *                     type="string",
     *                     description="User lastname",
     *                 ),
     *                 @OA\Property(
     *                     property="email",
     *                     type="string",
     *                     description="User email",
     *                 ),
     *                 @OA\Property(
     *                     property="password",
     *                     type="string",
     *                     description="User password",
     *                 ),
     *                 @OA\Property(
     *                     property="password_confirmation",
     *                     type="string",
     *                     description="User password",
     *                 ),
     *                @OA\Property(
     *                     property="avatar",
     *                     type="string",
     *                     description="Avatar image UUID"
     *                 ),
     *               @OA\Property(
     *                     property="address",
     *                     type="string",
     *                     description="User main address",
     *                 ),
     *               @OA\Property(
     *                     property="phone_number",
     *                     type="string",
     *                     description="User main phone number",
     *                 ),
     *               @OA\Property(
     *                     property="is_marketing",
     *                     description="User marketing preferences",
     *                     type="string",
     *                     enum={"0", "1"},
     *                 ),
     *                 required={
     *                     "first_name", "last_name", "email", "password",
     *                     "password_confirmation", "address", "phone_number"
     *                 }
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
     * Handle the incoming request.
     * @throws \Throwable
     */
    public function __invoke(UserEditRequest $request, User $user, UserService $userService): JsonResource
    {
        $userService->editUser($request, $user);
        return new UserEditResource($user);
    }
}
