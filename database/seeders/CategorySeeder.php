<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Insert some sample categories
        DB::table('categories')->insert([
            [
                'category_name' => 'Spring Flowers',
                'category_description' => 'Bright and colorful flowers that bloom in spring.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_name' => 'Summer Flowers',
                'category_description' => 'Vibrant flowers that thrive in the heat of summer.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_name' => 'Autumn Flowers',
                'category_description' => 'Rich-hued flowers that herald the arrival of autumn.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_name' => 'Winter Flowers',
                'category_description' => 'Elegant flowers that blossom during the cold of winter.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}

//php artisan db:seed --class=CategorySeeder