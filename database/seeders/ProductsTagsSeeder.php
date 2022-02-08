<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Tag;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class ProductsTagsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Tag::create(['name' => 'Clothes', 'status' => true]);
        // Tag::create(['name' => 'Shoes', 'status' => true]);
        // Tag::create(['name' => 'Watches', 'status' => true]);
        // Tag::create(['name' => 'Electronics', 'status' => true]);
        // Tag::create(['name' => 'Men', 'status' => true]);
        // Tag::create(['name' => 'Woman', 'status' => true]);
        // Tag::create(['name' => 'Boyes', 'status' => true]);
        // Tag::create(['name' => 'Girls', 'status' => true]);
        
        // $tags = Tag::whereStatus(true)->pluck('id')->toArray();

        // Product::all()->each(function ($product) use ($tags) {
        //     $product->tags()->attach(Arr::random($tags, rand(2, 3)));
        // });







        $tags = Tag::whereStatus(true)->pluck('id')->toArray();

        Product::all()->each(function ($product) use ($tags) {
            $product->tags()->attach(Arr::random($tags, rand(2, 3)));
        });
    }
}
