<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Sender User',
            'email' => 'sender@example.com',
            'password' => Hash::make('123456'),
        ]);
        User::factory()->create([
            'name' => 'Recipient User',
            'email' => 'recipient@example.com',
            'password' => Hash::make('123456'),
        ]);
    }
}
