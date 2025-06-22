<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubcategorySeeder extends Seeder
{
    public function run(): void
    {
        DB::table('subcategories')->insert([
            // Подкатегории для мышек (id категории = 1)
            [
                'name' => 'Беспроводные',
                'category_id' => 1,
                'created_at' => now()
            ],
            [
                'name' => 'Проводные',
                'category_id' => 1,
                'created_at' => now()
            ],
            [
                'name' => 'Гибридные',
                'category_id' => 1,
                'created_at' => now()
            ],
            
            // Подкатегории для клавиатур (id категории = 2)
            [
                'name' => 'Механические',
                'category_id' => 2,
                'created_at' => now()
            ],
            [
                'name' => 'Мембранные',
                'category_id' => 2,
                'created_at' => now()
            ],
            [
                'name' => 'Беспроводные',
                'category_id' => 2,
                'created_at' => now()
            ],
            
            // Подкатегории для наушников (id категории = 3)
            [
                'name' => 'Проводные',
                'category_id' => 3,
                'created_at' => now()
            ],
            [
                'name' => 'Беспроводные',
                'category_id' => 3,
                'created_at' => now()
            ],

            // Подкатегории для микрофонов (id категории = 4)
            [
                'name' => 'Конденсаторные',
                'category_id' => 4,
                'created_at' => now()
            ],
            [
                'name' => 'USB',
                'category_id' => 4,
                'created_at' => now()
            ],
            

            // Подкатегории для геймпадов (id категории = 5)
            [
                'name' => 'PlayStation',
                'category_id' => 5,
                'created_at' => now()
            ],
            [
                'name' => 'Xbox',
                'category_id' => 5,
                'created_at' => now()
            ],
            [
                'name' => 'Другие',
                'category_id' => 5,
                'created_at' => now()
            ],
        ]);
    }
} 