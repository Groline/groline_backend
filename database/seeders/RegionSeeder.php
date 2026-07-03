<?php

namespace Database\Seeders;

use App\Models\Region;
use Illuminate\Database\Seeder;

class RegionSeeder extends Seeder
{
    public function run(): void
    {
        $regions = [
            ['name' => 'Alger', 'longitude' => 3.0588, 'latitude' => 36.7538, 'boundaries' => '{}'],
            ['name' => 'Oran', 'longitude' => -0.6382, 'latitude' => 35.6969, 'boundaries' => '{}'],
        ];

        foreach ($regions as $region) {
            Region::firstOrCreate(['name' => $region['name']], $region);
        }
    }
}
