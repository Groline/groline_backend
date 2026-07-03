<?php

namespace Database\Seeders;

use App\Models\Activity;
use Illuminate\Database\Seeder;

class ActivitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Activity::create([
            'name_fr' => 'Robinetterie et sanitaires',
            'name_en' => 'Taps and sanitary ware',
            'name_ar' => 'الصنابير والمرافق الصحية'
        ]);

        Activity::create([
            'name_fr' => 'Plomberie et chauffage',
            'name_en' => 'Plumbing and heating',
            'name_ar' => 'السباكة والتدفئة'
        ]);

        Activity::create([
            'name_fr' => 'Quincaillerie',
            'name_en' => 'Hardware',
            'name_ar' => 'أدوات ومستلزمات'
        ]);
    }
}
