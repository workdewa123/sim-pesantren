<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class RoleAndUserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Membuat Role di dalam sistem (Tambahkan staf_media)
        $roleAdmin     = Role::updateOrCreate(['name' => 'admin']);
        $roleBendahara = Role::updateOrCreate(['name' => 'bendahara']);
        $rolePengawas  = Role::updateOrCreate(['name' => 'pengawas']);
        $rolePencatat  = Role::updateOrCreate(['name' => 'pencatat']);
        $roleMedia     = Role::updateOrCreate(['name' => 'staf_media']); // <--- Peran Baru

        // 2. Membuat / Memastikan Akun Admin
        $admin = User::updateOrCreate(
            ['email' => 'admin@pesantren.com'],
            [
                'name' => 'Admin Utama SIM',
                'password' => Hash::make('password123'),
            ]
        );
        if (!$admin->hasRole('admin')) {
            $admin->assignRole($roleAdmin);
        }

        // 3. Membuat Akun Bendahara
        $bendahara = User::updateOrCreate(
            ['email' => 'bendahara@pesantren.com'],
            [
                'name' => 'Bendahara Kantor',
                'password' => Hash::make('password123'),
            ]
        );
        if (!$bendahara->hasRole('bendahara')) {
            $bendahara->assignRole($roleBendahara);
        }

        // 4. BIKIN AKUN CONTOH STAF MEDIA BARU DI SINI:
        $media = User::updateOrCreate(
            ['email' => 'media@pesantren.com'],
            [
                'name' => 'Tim Media & Publikasi',
                'password' => Hash::make('password123'), // Ganti saat produksi
            ]
        );
        if (!$media->hasRole('staf_media')) {
            $media->assignRole($roleMedia);
        }
    }
}