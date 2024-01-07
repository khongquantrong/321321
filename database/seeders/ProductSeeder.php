<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [];
        for ($i = 0; $i < 100000; $i++) {
            echo "Record No." . $i . "\n";

            $name = fake()->text(50);
            $categoryID = rand(1, 10);
            $data[] = [
                'category_id' => $categoryID,
                'sku' => Str::random() . '-' . rand(1, 10000) . $i . $categoryID,
                'name' => $name,
                'slug' => Str::slug($name) . '-' . rand(1, 10000) . $i . $categoryID,
                'describe' => fake()->text(),
            ];

            if ($i % 500 == 0) {
                DB::table('products')->insert($data);
            }
        }
    }
}
