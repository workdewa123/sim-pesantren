<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Santri;

class SantriSeeder extends Seeder
{
    public function run(): void
    {
        // 15 Santri Mukim
        for ($i = 1; $i <= 15; $i++) {
            Santri::create([
                'kelas_id' => null,
                'nama_santri' => "Santri Mukim $i",
                'tanggal_lahir' => fake()->date('Y-m-d', '-10 years'),
                'alamat_santri' => fake()->address(),
                'tahun_masuk' => rand(2022, 2025),
                'jenis_santri' => 'mukim',
                'status_santri' => 'aktif',

                'nama_ayah' => fake()->name('male'),
                'nama_ibu' => fake()->name('female'),
                'alamat_orang_tua' => fake()->address(),
                'no_hp_wali' => '08' . fake()->numerify('##########'),

                'pilihan_biaya' => fake()->randomElement([
                    300000,
                    400000,
                    500000
                ]),

                'file_kk' => null,
                'file_akte' => null,
            ]);
        }

        // 15 Santri Non Mukim
        for ($i = 1; $i <= 15; $i++) {
            Santri::create([
                'kelas_id' => null,
                'nama_santri' => "Santri Non Mukim $i",
                'tanggal_lahir' => fake()->date('Y-m-d', '-10 years'),
                'alamat_santri' => fake()->address(),
                'tahun_masuk' => rand(2022, 2025),
                'jenis_santri' => 'non-mukim',
                'status_santri' => 'aktif',

                'nama_ayah' => fake()->name('male'),
                'nama_ibu' => fake()->name('female'),
                'alamat_orang_tua' => fake()->address(),
                'no_hp_wali' => '08' . fake()->numerify('##########'),

                'pilihan_biaya' => fake()->randomElement([
                    300000,
                    400000,
                    500000
                ]),

                'file_kk' => null,
                'file_akte' => null,
            ]);
        }
    }
}