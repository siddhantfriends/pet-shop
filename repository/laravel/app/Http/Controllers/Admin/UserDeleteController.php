<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Http\Service\UserService;
use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\UserDeleteResource;
use Illuminate\Http\Resources\Json\JsonResource;

class UserDeleteController extends Controller
{
    /**
     *  @OA\Delete(
     *     path="/api/v1/admin/user-delete/{uuid}",
     *     tags={"Admin"},
     *     summary="Edit a User account",
     *     description="Test Description",
     *     operationId="admin-user-delete",
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
     * Handle the incoming request.
     */
    public function __invoke(User $user, UserService $userService): JsonResource
    {
        $userService->deleteUser($user);

        return new UserDeleteResource([]);
    }
}
