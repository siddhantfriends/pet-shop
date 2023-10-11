<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Http\Requests\FileStoreRequest;
use App\Http\Resources\FileStoreResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class FileController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/v1/file/upload",
     *     tags={"File"},
     *     summary="Upload a file",
     *     description="Test Description",
     *     operationId="file-upload",
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     type="string",
     *                     property="file",
     *                     format="binary",
     *                     description="file to upload",
     *                 ),
     *                 required={"file"}
     *             )
     *         )
     *    ),
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
    public function store(FileStoreRequest $request): JsonResource
    {
        $file = $request->file('file');
        $path = $file->store('public/pet-shop');
        $fileName = basename($path);

        $fileObject = File::create([
            'name' => $fileName,
            'path' => 'public/pet-shop/' . $fileName,
            'size' => $file->getSize(),
            'type' => $file->getClientMimeType(),
        ]);

        return new FileStoreResource($fileObject->fresh());
    }

    public function show(File $file): BinaryFileResponse
    {
        return response()->download(storage_path('app/' . $file->path));
    }
}
