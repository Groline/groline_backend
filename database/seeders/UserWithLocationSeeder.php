<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Location;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserWithLocationSeeder extends Seeder
{
    public function run(): void
    {
        // ─── User 1 ────────────────────────────────────
        $user1 = User::firstOrCreate(
            ['email' => 'ahmed@test.com'],
            [
                'name' => 'Ahmed Benali',
                'phone' => '0555123456',
                'password' => Hash::make('123456789'),
                'role' => 1,
                'status' => 1,
            ]
        );

        Location::firstOrCreate(
            ['user_id' => $user1->id, 'name' => 'Domicile'],
            [
                'region_id' => 1,
                'address' => '123 Rue Didouche Mourad, Alger Centre',
                'longitude' => 3.0588,
                'latitude' => 36.7538,
            ]
        );

        $user1->activities()->syncWithoutDetaching([1, 2]);

        // ─── User 2 ────────────────────────────────────
        $user2 = User::firstOrCreate(
            ['email' => 'fatima@test.com'],
            [
                'name' => 'Fatima Zohra',
                'phone' => '0555987654',
                'password' => Hash::make('123456789'),
                'role' => 1,
                'status' => 1,
            ]
        );

        Location::firstOrCreate(
            ['user_id' => $user2->id, 'name' => 'Maison'],
            [
                'region_id' => 1,
                'address' => '45 Boulevard Khemisti, Alger',
                'longitude' => 3.0520,
                'latitude' => 36.7500,
            ]
        );

        $user2->activities()->syncWithoutDetaching(3);

        // ─── User 3 ────────────────────────────────────
        $user3 = User::firstOrCreate(
            ['email' => 'mohamed@test.com'],
            [
                'name' => 'Mohamed Amine',
                'phone' => '0555222333',
                'password' => Hash::make('123456789'),
                'role' => 1,
                'status' => 1,
            ]
        );

        Location::firstOrCreate(
            ['user_id' => $user3->id, 'name' => 'Travail'],
            [
                'region_id' => 2,
                'address' => '78 Avenue Ahmed Zabana, Oran',
                'longitude' => -0.6382,
                'latitude' => 35.6969,
            ]
        );

        $user3->activities()->syncWithoutDetaching([1, 2, 3]);
    }
}
