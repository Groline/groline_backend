<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name_fr' => 'Robinetterie', 'name_ar' => 'الصنابير', 'name_en' => 'Taps & Faucets'],
            ['name_fr' => 'Sanitaires', 'name_ar' => 'الأدوات الصحية', 'name_en' => 'Sanitary Ware'],
            ['name_fr' => 'Plomberie', 'name_ar' => 'السباكة', 'name_en' => 'Plumbing'],
            ['name_fr' => 'Chauffage', 'name_ar' => 'التدفئة', 'name_en' => 'Heating'],
            ['name_fr' => 'Quincaillerie', 'name_ar' => 'الخردوات', 'name_en' => 'Hardware'],
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate(['name_fr' => $category['name_fr']], $category);
        }
    }
}
