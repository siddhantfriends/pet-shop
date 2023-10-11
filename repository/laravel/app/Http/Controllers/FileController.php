<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Http\Requests\FileStoreRequest;
use App\Http\Resources\FileStoreResource;
use Illuminate\Http\Resources\Json\JsonResource;

class FileController extends Controller
{
    /**
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
}
