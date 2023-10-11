<?php

namespace Tests\Feature;

use App\Models\File;
use Illuminate\Http\Response;
use Illuminate\Http\UploadedFile;
use Illuminate\Routing\ResponseFactory;
use Illuminate\Support\Facades\Storage;
use Mockery;
use Tests\TestCase;

class FileDownloadTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->instance(
            ResponseFactory::class,
            Mockery::mock(
                ResponseFactory::class,
                function ($mock) {
                    $mock->shouldReceive('download');
                }
            )
        );
    }

    /**
     * Test checks if a file can be downloaded from the /api/v1/file/{uuid} endpoint
     *
     * @test
     */
    public function can_download_file(): void
    {
        $file = $this->createFakeFileOnStorageAndReturnUuid();

        $response = $this->call('GET', route('file.read', compact('file')));

        $response->assertStatus(Response::HTTP_OK);
        $response->assertDownload('default.webp');
    }

    private function createFakeFileOnStorageAndReturnUuid(): string
    {
        Storage::fake();
        $uploaded = UploadedFile::fake()->create('default.webp');
        Storage::move(
            $uploaded->getRealPath() . DIRECTORY_SEPARATOR . $uploaded->getClientOriginalName(),
            storage_path('app/public/pet-shop/' . $uploaded->getClientOriginalName())
        );

        $file = File::factory()->create(
            [
                'name' => 'default.webp',
                'path' => 'public/pet-shop/' . $uploaded->getClientOriginalName(),
                'size' => $uploaded->getSize(),
                'type' => $uploaded->getMimeType(),
            ]
        );

        return $file->uuid;
    }
}
