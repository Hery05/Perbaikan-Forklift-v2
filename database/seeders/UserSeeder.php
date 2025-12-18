<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        $users = [
            [
                'name' => 'Admin',
                'email' => 'admin@test',
                'role' => 'admin'
            ],
            [
                'name' => 'Koordinator Alat',
                'email' => 'koordinator@test',
                'role' => 'coordinator'
            ],
            [
                'name' => 'Teknisi',
                'email' => 'technician@test',
                'role' => 'technician'
            ],
            [
                'name' => 'Tim Sparepart',
                'email' => 'sparepart@test',
                'role' => 'sparepart'
            ],
        ];

        foreach ($users as $user) {
            User::updateOrCreate(
                ['email' => $user['email']],
                [
                    'name' => $user['name'],
                    'password' => Hash::make('admin123'),
                    'role' => $user['role']
                ]
            );
        }
    }
}
