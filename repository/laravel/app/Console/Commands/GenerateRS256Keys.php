<?php

namespace App\Console\Commands;

use Spatie\Crypto\Rsa\KeyPair;
use Illuminate\Console\Command;

class GenerateRS256Keys extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'jwt:keys';

    /**
     * The console command description.
     */
    protected $description = 'Generate Key Pair for JsonWebToken';

    /**
     * Execute the console command.
     */
    public function handle(KeyPair $keys): void
    {
        $keys->generate(config('jwt.private'), config('jwt.public'));
    }
}
