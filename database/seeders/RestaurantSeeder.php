<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class RestaurantSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('restaurants')->insert([
            [
                'admin_user_id' => 2, // pastikan user id ini ADA
                'name' => 'Cafe Nusantara',
                'address' => 'Jl. Merdeka No. 10',
                'phone' => '081234567890',
                'is_active' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
