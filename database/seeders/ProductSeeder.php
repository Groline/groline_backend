<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            ['subcategory_id' => 1, 'brand_id' => 1, 'unit_id' => 1, 'name_fr' => 'Mitigeur cuisine chrome Grohe', 'name_ar' => 'خلاط مطبخ كروم جروهي', 'name_en' => 'Grohe Chrome Kitchen Mixer', 'unit_price' => 8500, 'pack_price' => null, 'pack_units' => null, 'unit_type' => 1, 'status' => 'available', 'description' => 'Mitigeur de cuisine en chrome de haute qualité.'],
            ['subcategory_id' => 2, 'brand_id' => 2, 'unit_id' => 1, 'name_fr' => 'Mitigeur lavabo Jacob Delafon', 'name_ar' => 'خلاط حوض جاكوب ديلافون', 'name_en' => 'Jacob Delafon Basin Mixer', 'unit_price' => 6200, 'pack_price' => null, 'pack_units' => null, 'unit_type' => 1, 'status' => 'available', 'description' => 'Mitigeur de lavabo élégant finition chromée.'],
            ['subcategory_id' => 3, 'brand_id' => 5, 'unit_id' => 1, 'name_fr' => 'Flexible de raccordement 40cm', 'name_ar' => 'خرطوم توصيل 40 سم', 'name_en' => '40cm Connection Hose', 'unit_price' => 350, 'pack_price' => null, 'pack_units' => null, 'unit_type' => 1, 'status' => 'available', 'description' => 'Flexible de raccordement inox 40 cm.'],
            ['subcategory_id' => 4, 'brand_id' => 3, 'unit_id' => 1, 'name_fr' => 'Lavabo suspendu Villeroy & Boch', 'name_ar' => 'حوض معلق فيليروي وبوخ', 'name_en' => 'Villeroy & Boch Wall-Hung Basin', 'unit_price' => 18500, 'pack_price' => null, 'pack_units' => null, 'unit_type' => 1, 'status' => 'available', 'description' => 'Lavabo suspendu en céramique blanche.'],
            ['subcategory_id' => 5, 'brand_id' => 4, 'unit_id' => 1, 'name_fr' => 'WC suspendu Kohler', 'name_ar' => 'مرحاض معلق كولر', 'name_en' => 'Kohler Wall-Hung Toilet', 'unit_price' => 22000, 'pack_price' => null, 'pack_units' => null, 'unit_type' => 1, 'status' => 'available', 'description' => 'WC suspendu avec bride de fixation.'],
            ['subcategory_id' => 6, 'brand_id' => 2, 'unit_id' => 1, 'name_fr' => 'Receveur de douche 90x90 Jacob Delafon', 'name_ar' => 'حوض استحمام 90x90 جاكوب ديلافون', 'name_en' => 'Jacob Delafon 90x90 Shower Tray', 'unit_price' => 16000, 'pack_price' => null, 'pack_units' => null, 'unit_type' => 1, 'status' => 'available', 'description' => 'Receveur de douche carré en acrylique.'],
            ['subcategory_id' => 7, 'brand_id' => 5, 'unit_id' => 2, 'name_fr' => 'Tube PVC 32mm (3 mètres)', 'name_ar' => 'أنبوب PVC 32 ملم (3 متر)', 'name_en' => 'PVC Pipe 32mm (3 meters)', 'unit_price' => 450, 'pack_price' => 4200, 'pack_units' => 10, 'unit_type' => 1, 'status' => 'available', 'description' => 'Tube PVC pression 32 mm, longueur 3 mètres.'],
            ['subcategory_id' => 8, 'brand_id' => 5, 'unit_id' => 1, 'name_fr' => 'Robinet d\'arrêt 15/21', 'name_ar' => 'محبس إغلاق 15/21', 'name_en' => '15/21 Stop Valve', 'unit_price' => 280, 'pack_price' => 2500, 'pack_units' => 10, 'unit_type' => 1, 'status' => 'available', 'description' => 'Robinet d\'arrêt laiton 15/21.'],
            ['subcategory_id' => 9, 'brand_id' => 5, 'unit_id' => 1, 'name_fr' => 'Chauffe-eau électrique 50L', 'name_ar' => 'سخان ماء كهربائي 50 لتر', 'name_en' => '50L Electric Water Heater', 'unit_price' => 28000, 'pack_price' => null, 'pack_units' => null, 'unit_type' => 1, 'status' => 'available', 'description' => 'Chauffe-eau électrique à accumulation 50 litres.'],
            ['subcategory_id' => 10, 'brand_id' => 5, 'unit_id' => 1, 'name_fr' => 'Radiateur fonte 5 éléments', 'name_ar' => 'مشعاع حديد زهر 5 عناصر', 'name_en' => 'Cast Iron Radiator 5 Sections', 'unit_price' => 35000, 'pack_price' => null, 'pack_units' => null, 'unit_type' => 1, 'status' => 'available', 'description' => 'Radiateur en fonte 5 éléments.'],
            ['subcategory_id' => 11, 'brand_id' => 5, 'unit_id' => 5, 'name_fr' => 'Vis inox 4x30 (boîte 100)', 'name_ar' => 'براغي ستانلس 4x30 (علبة 100)', 'name_en' => 'Stainless Screws 4x30 (box of 100)', 'unit_price' => 550, 'pack_price' => null, 'pack_units' => null, 'unit_type' => 1, 'status' => 'available', 'description' => 'Boîte de 100 vis inox 4x30 mm.'],
            ['subcategory_id' => 12, 'brand_id' => 5, 'unit_id' => 1, 'name_fr' => 'Collier de serrage inox 20-32mm', 'name_ar' => 'طوق ربط ستانلس 20-32 مم', 'name_en' => 'Stainless Clamp 20-32mm', 'unit_price' => 120, 'pack_price' => 1000, 'pack_units' => 10, 'unit_type' => 1, 'status' => 'available', 'description' => 'Collier de serrage en inox, diamètre 20-32 mm.'],
        ];

        foreach ($products as $product) {
            Product::firstOrCreate(
                ['name_fr' => $product['name_fr']],
                $product
            );
        }
    }
}
