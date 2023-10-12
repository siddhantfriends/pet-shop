<?php

namespace App\Jobs;

use App\Models\PasswordReset;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ResetPasswordTokenCleanupJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public string $token;

    /**
     * Create a new job instance.
     */
    public function __construct(string $token)
    {
        $this->token = $token;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        PasswordReset::whereToken($this->token)->first()->delete();
    }
}
