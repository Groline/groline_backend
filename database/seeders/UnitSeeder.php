<?php

namespace Database\Seeders;

use App\Models\Unit;
use Illuminate\Database\Seeder;

class UnitSeeder extends Seeder
{
    public function run(): void
    {
        $units = [
            ['name_fr' => 'Pièce', 'name_ar' => 'قطعة', 'name_en' => 'Piece'],
            ['name_fr' => 'Mètre', 'name_ar' => 'متر', 'name_en' => 'Meter'],
            ['name_fr' => 'Litre', 'name_ar' => 'لتر', 'name_en' => 'Liter'],
            ['name_fr' => 'Kilogramme', 'name_ar' => 'كيلوغرام', 'name_en' => 'Kilogram'],
            ['name_fr' => 'Paquet', 'name_ar' => 'حزمة', 'name_en' => 'Pack'],
        ];

        foreach ($units as $unit) {
            Unit::firstOrCreate(['name_fr' => $unit['name_fr']], $unit);
        }
    }
}
