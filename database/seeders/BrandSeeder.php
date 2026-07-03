<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    public function run(): void
    {
        $brands = [
            ['name_fr' => 'Grohe', 'name_ar' => 'جروهي', 'name_en' => 'Grohe', 'slug' => 'grohe', 'status' => 1],
            ['name_fr' => 'Jacob Delafon', 'name_ar' => 'جاكوب ديلافون', 'name_en' => 'Jacob Delafon', 'slug' => 'jacob-delafon', 'status' => 1],
            ['name_fr' => 'Villeroy & Boch', 'name_ar' => 'فيليروي وبوخ', 'name_en' => 'Villeroy & Boch', 'slug' => 'villeroy-boch', 'status' => 1],
            ['name_fr' => 'Kohler', 'name_ar' => 'كولر', 'name_en' => 'Kohler', 'slug' => 'kohler', 'status' => 1],
            ['name_fr' => 'Générique', 'name_ar' => 'عام', 'name_en' => 'Generic', 'slug' => 'generic', 'status' => 1],
        ];

        foreach ($brands as $brand) {
            Brand::firstOrCreate(['slug' => $brand['slug']], $brand);
        }
    }
}
