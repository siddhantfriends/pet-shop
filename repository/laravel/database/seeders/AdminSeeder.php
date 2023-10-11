<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->admin()->create([
            'first_name' => 'Buckhill',
            'last_name' => 'Administrator',
            'email' => 'admin@buckhill.co.uk',
            'password' => 'admin',
        ]);
    }
}
