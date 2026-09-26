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
        $users = [
            [
                'name' => 'Super Admin',
                'email' => 'superadmin@dapurwarga',
                'role' => 'superadmin',
            ],
            [
                'name' => 'Admin',
                'email' => 'admin@dapurwarga',
                'role' => 'admin',
            ],
            [
                'name' => 'Seller',
                'email' => 'seller@dapurwarga',
                'role' => 'seller',
            ],
            [
                'name' => 'Layanan',
                'email' => 'layanan@dapurwarga',
                'role' => 'layanan',
                'kategori_layanan' => 'servis',
            ],
        ];

        foreach ($users as $user) {
            User::updateOrCreate(
                ['email' => $user['email']],
                [
                    'name' => $user['name'],
                    'role' => $user['role'],
                    'kategori_layanan' => $user['kategori_layanan'] ?? null,
                    'password' => 'password',
                    'email_verified_at' => now(),
                ],
            );
        }
    }
}
