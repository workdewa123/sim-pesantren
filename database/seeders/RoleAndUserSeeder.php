<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
// use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class RoleAndUserSeeder extends Seeder
{
    public function run(): void
    {
        $media = User::updateOrCreate(
            ['email' => 'test@gmail.com'],
            [
                'name' => 'Tim Media & Publikasi',
                'password' => Hash::make('12345678'), 
            ]
        );
    }
}