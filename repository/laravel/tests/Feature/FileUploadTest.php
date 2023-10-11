<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class FileUploadTest extends TestCase
{
    /**
     * Test checks if a file can be uploaded to the /api/v1/file/upload endpoint
     *
     * @test
     */
    public function can_upload_file(): void
    {
        Storage::fake();

        $response = $this->json('POST', route('file.upload'), [
            'file' => UploadedFile::fake()->image('default.webp')->size('100'),
        ]);

        $response->assertStatus(Response::HTTP_OK);

        $response->assertJsonPath('success', 1)
            ->assertJsonPath('data.size', '102400')
            ->assertJsonPath('data.type', 'image/webp');
    }
}
