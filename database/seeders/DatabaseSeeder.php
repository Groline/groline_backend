<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        $this->call([
            SuperAdminSeeder::class,
            ActivitySeeder::class,
            RegionSeeder::class,
            UnitSeeder::class,
            BrandSeeder::class,
            CategorySeeder::class,
            SubcategorySeeder::class,
            ProductSeeder::class,
            UserWithLocationSeeder::class,
            OrderSeeder::class,
        ]);
    }
}
