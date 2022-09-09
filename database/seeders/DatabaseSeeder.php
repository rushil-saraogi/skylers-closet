<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $tech = DB::table('categories')->insertGetId([
            'name' => 'Tech',
        ]);

        $home = DB::table('categories')->insertGetId([
            'name' => 'Home',
        ]);

        $books = DB::table('categories')->insertGetId([
            'name' => 'Books',
        ]);

        $fashion = DB::table('categories')->insertGetId([
            'name' => 'Fashion',
        ]);

        $watches = DB::table('categories')->insertGetId([
            'name' => 'Watches',
        ]);

        DB::table('global_items')->insert([
            'title' => 'Rubber Chicken Purse - The Hen Bag Handbag',
            'image' => 'https://m.media-amazon.com/images/I/61eiIozbjeL._AC_UY695_.jpg',
            'price' => 32,
            'url' => 'https://www.amazon.com/dp/B001G8N95I',
            'asin' => 'B001G8N95I',
            'category_id' => $fashion
        ]);

        DB::table('global_items')->insert([
            'title' => 'Thanos Swimsuit Male One Piece Swimwear for Men and Boys',
            'image' => 'https://m.media-amazon.com/images/I/61jFyhk5WfL._AC_UX679_.jpg',
            'price' => 35.99,
            'url' => 'https://www.amazon.com/dp/B07SJ77C8V',
            'asin' => 'B07SJ77C8V',
            'category_id' => $fashion
        ]);

        DB::table('global_items')->insert([
            'title' => 'Nicolas Cage Pillow',
            'image' => 'https://m.media-amazon.com/images/I/81Ga6hCDooL._AC_SX679_.jpg',
            'price' => 12.99,
            'url' => 'https://www.amazon.com/dp/B07WTVQ171',
            'asin' => 'B07WTVQ171',
            'category_id' => $home
        ]);
    }
}
