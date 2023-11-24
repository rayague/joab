<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        DB::table('admins')->insert([
            'name' => 'ledigitalmaster',
            'email' => 'ledigitalmaster@gmail.com',
            'password' => Hash::make('@azertyuiop@'),
        ]);
    }
}
