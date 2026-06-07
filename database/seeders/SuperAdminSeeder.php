<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Admin::create([
          'name' => 'super admin',
          'phone' => '0123456789',
          'email' => 'super@admin.com',
          'password' => Hash::make('123456789'),
          'status' => 1
        ]);
    }
}
