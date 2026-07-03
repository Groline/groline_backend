<?php

namespace Database\Seeders;

use App\Models\Subcategory;
use Illuminate\Database\Seeder;

class SubcategorySeeder extends Seeder
{
    public function run(): void
    {
        $subcategories = [
            ['category_id' => 1, 'name_fr' => 'Mitigeurs cuisine', 'name_ar' => 'خلاطات المطبخ', 'name_en' => 'Kitchen Mixers'],
            ['category_id' => 1, 'name_fr' => 'Mitigeurs salle de bain', 'name_ar' => 'خلاطات الحمام', 'name_en' => 'Bathroom Mixers'],
            ['category_id' => 1, 'name_fr' => 'Accessoires robinetterie', 'name_ar' => 'إكسسوارات الصنابير', 'name_en' => 'Tap Accessories'],
            ['category_id' => 2, 'name_fr' => 'Lavabos', 'name_ar' => 'أحواض غسيل', 'name_en' => 'Washbasins'],
            ['category_id' => 2, 'name_fr' => 'WC et bidets', 'name_ar' => 'مراحيض وشطافات', 'name_en' => 'Toilets & Bidets'],
            ['category_id' => 2, 'name_fr' => 'Receveurs de douche', 'name_ar' => 'أحواض الاستحمام', 'name_en' => 'Shower Trays'],
            ['category_id' => 3, 'name_fr' => 'Tubes et raccords', 'name_ar' => 'أنابيب ووصلات', 'name_en' => 'Pipes & Fittings'],
            ['category_id' => 3, 'name_fr' => 'Robinets d\'arrêt', 'name_ar' => 'محابس الإغلاق', 'name_en' => 'Stop Valves'],
            ['category_id' => 4, 'name_fr' => 'Chauffe-eau', 'name_ar' => 'سخانات المياه', 'name_en' => 'Water Heaters'],
            ['category_id' => 4, 'name_fr' => 'Radiateurs', 'name_ar' => 'مشعات التدفئة', 'name_en' => 'Radiators'],
            ['category_id' => 5, 'name_fr' => 'Vis et boulons', 'name_ar' => 'براغي ومسامير', 'name_en' => 'Screws & Bolts'],
            ['category_id' => 5, 'name_fr' => 'Colliers de serrage', 'name_ar' => 'أطواق ربط', 'name_en' => 'Clamps'],
        ];

        foreach ($subcategories as $subcategory) {
            Subcategory::firstOrCreate(
                ['category_id' => $subcategory['category_id'], 'name_fr' => $subcategory['name_fr']],
                $subcategory
            );
        }
    }
}
