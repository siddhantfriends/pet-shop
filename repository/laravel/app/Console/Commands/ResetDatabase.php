<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ResetDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.PropertyTypeHint.MissingNativeTypeHint
     * @var string
     */
    protected $signature = 'app:reset-database';

    /**
     * The console command description.
     *
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.PropertyTypeHint.MissingNativeTypeHint
     * @var string
     */
    protected $description = 'Truncate database and re-seed.';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->call('migrate:refresh');
        $this->call('db:seed');
    }
}
