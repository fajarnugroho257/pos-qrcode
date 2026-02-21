<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleTableseeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create([
            'role_id' => 'R0001',
            'role_name' => 'developer',
        ]);
        Role::create([
            'role_id' => 'R0002',
            'role_name' => 'owner',
        ]);
        Role::create([
            'role_id' => 'R0003',
            'role_name' => 'cashier',
        ]);
    }
}
