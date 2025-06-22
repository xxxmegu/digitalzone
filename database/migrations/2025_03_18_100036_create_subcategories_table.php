<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('subcategories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedInteger('category_id');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->timestamps();
        });

        // Добавляем только поле subcategory_id в таблицу products
        if (!Schema::hasColumn('products', 'subcategory_id')) {
            Schema::table('products', function (Blueprint $table) {
                $table->foreignId('subcategory_id')->nullable()->constrained()->onDelete('set null');
            });
        }

        // Заполняем подкатегории начальными данными
        $subcategories = [
            'Мыши' => ['Проводные', 'Беспроводные'],
            'Клавиатуры' => ['Механические', 'Мембранные'],
            'Наушники' => ['Проводные', 'Беспроводные'],
            'Микрофоны' => ['Динамические микрофоны', 'Конденсаторные микрофоны', 'USB-микрофоны'],
        ];

        foreach ($subcategories as $categoryName => $subs) {
            $category = DB::table('categories')->where('product_type', $categoryName)->first();
            if ($category) {
                foreach ($subs as $subName) {
                    DB::table('subcategories')->insert([
                        'name' => $subName,
                        'category_id' => $category->id,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('products', 'subcategory_id')) {
            Schema::table('products', function (Blueprint $table) {
                $table->dropForeign(['subcategory_id']);
                $table->dropColumn('subcategory_id');
            });
        }
        Schema::dropIfExists('subcategories');
    }
};
