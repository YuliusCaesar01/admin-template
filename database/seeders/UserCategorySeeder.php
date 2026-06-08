<?php

namespace Database\Seeders;

use App\Models\UserCategory;
use Illuminate\Database\Seeder;

class UserCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [

            [
                'code' => 'I1',
                'user_type' => 'internal',
                'category_name' => 'Mahasiswa Politeknik ATMI',
            ],

            [
                'code' => 'I2',
                'user_type' => 'internal',
                'category_name' => 'Instruktur / Dosen Politeknik ATMI',
            ],

            [
                'code' => 'I3',
                'user_type' => 'internal',
                'category_name' => 'Unit Internal Institusi',
            ],

            [
                'code' => 'E1',
                'user_type' => 'external',
                'category_name' => 'Institusi Pendidikan',
            ],

            [
                'code' => 'E2',
                'user_type' => 'external',
                'category_name' => 'Institusi Penelitian',
            ],

            [
                'code' => 'E3',
                'user_type' => 'external',
                'category_name' => 'Kampus Internasional',
            ],

            [
                'code' => 'E4',
                'user_type' => 'external',
                'category_name' => 'Peneliti Individu',
            ],

            [
                'code' => 'E5',
                'user_type' => 'external',
                'category_name' => 'Peneliti Perwakilan Kampus',
            ],

            [
                'code' => 'E6',
                'user_type' => 'external',
                'category_name' => 'Industri / Manufaktur',
            ],

            [
                'code' => 'E7',
                'user_type' => 'external',
                'category_name' => 'UMKM / Startup',
            ],

            [
                'code' => 'E8',
                'user_type' => 'external',
                'category_name' => 'Profesional',
            ],
        ];

        foreach ($categories as $category) {
            UserCategory::create($category);
        }
    }
}