<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\UserListingIndexCollection;

class UserListingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $users = User::users()->paginate(10);

        $response = new UserListingIndexCollection($users);

        return response()->json($response->resource);
    }
}
