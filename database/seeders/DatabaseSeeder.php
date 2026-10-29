<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'wagner.rivera@dorel.cl'],
            [
                'name' => 'Wagner Rivera',
                'password' => bcrypt('password123'),
            ]
        );

        $this->call([
            RfcDocumentSeeder::class,
        ]);
    }
}
