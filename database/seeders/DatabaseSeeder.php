<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(WorldSeeder::class);
        $this->call(EntrustSeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(ProductSeeder::class);
        $this->call(ProductsImagesSeeder::class);
        $this->call(ProductsTagsSeeder::class);
        $this->call(ProductCouponSeeder::class);
        $this->call(ProductReviewSeeder::class);
        $this->call(WorldSeeder::class);
        $this->call(WorldStatusSeedar::class);
        $this->call(UserAddressSeeder::class);
        $this->call(ShippingCompanySeeder::class);

    }
}
