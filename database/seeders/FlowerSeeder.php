<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FlowerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Insert some sample flowers
        DB::table('flowers')->insert([
            [
                'name' => 'Rose',
                'description' => 'Beautiful red rose.',
                'picture' => 'rose.jpg', // Assuming the picture is stored in public directory
                'stocks' => 50,
                'price' => 10.00,
                'category_id' => 1, // Assuming the category_id for Spring Flowers is 1
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Tulip',
                'description' => 'Colorful tulip flower.',
                'picture' => 'tulip.jpg', // Assuming the picture is stored in public directory
                'stocks' => 30,
                'price' => 8.50,
                'category_id' => 1, // Assuming the category_id for Spring Flowers is 1
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Daisy',
                'description' => 'Classic white daisy.',
                'picture' => 'daisy.jpg', // Assuming the picture is stored in public directory
                'stocks' => 40,
                'price' => 7.50,
                'category_id' => 2, // Assuming the category_id for Summer Flowers is 2
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Chrysanthemum',
                'description' => 'Colorful chrysanthemum flower.',
                'picture' => 'chrysanthemum.jpg', // Assuming the picture is stored in public directory
                'stocks' => 35,
                'price' => 9.00,
                'category_id' => 3, // Assuming the category_id for Autumn Flowers is 3
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Poinsettia',
                'description' => 'Traditional Christmas poinsettia.',
                'picture' => 'poinsettia.jpg', // Assuming the picture is stored in public directory
                'stocks' => 25,
                'price' => 12.00,
                'category_id' => 4, // Assuming the category_id for Winter Flowers is 4
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
