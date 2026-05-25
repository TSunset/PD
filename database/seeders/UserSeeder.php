<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Администратор MVP',
                'phone' => '+7 (900) 000-00-01',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );

        User::updateOrCreate(
            ['email' => 'user@example.com'],
            [
                'name' => 'Тестовый пользователь',
                'phone' => '+7 (900) 000-00-02',
                'password' => Hash::make('password'),
                'role' => 'user',
            ]
        );
    }
}
