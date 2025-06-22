<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')->insert(
            [
                [
                    'id' => 1,
                    'product_type' => 'Мыши',
                ],
                [
                    'id' => 2,
                    'product_type' => 'Клавиатуры',
                ],
                [
                    'id' => 3,
                    'product_type' => 'Наушники',
                ],
                [
                    'id' => 4,
                    'product_type' => 'Микрофоны',
                ],
                [
                    'id' => 5,
                    'product_type' => 'Геймпады',
                ]
            ]
        );
    }
}
