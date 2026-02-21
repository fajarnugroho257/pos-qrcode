<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RestaurantUserSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('restaurant_user')->insert([
            [
                'restaurant_id' => 1,
                'user_id' => 3, // cashier
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
