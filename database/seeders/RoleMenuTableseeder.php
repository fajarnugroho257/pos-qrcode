<?php

namespace Database\Seeders;

use App\Models\Role_menu;
use Illuminate\Database\Seeder;

class RoleMenuTableseeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role_menu::create([
            'role_menu_id' => 'R0001M0000',
            'menu_id' => 'M0000',
            'role_id' => 'R0001',
        ]);
        Role_menu::create([
            'role_menu_id' => 'R0001M0001',
            'menu_id' => 'M0001',
            'role_id' => 'R0001',
        ]);
        Role_menu::create([
            'role_menu_id' => 'R0001M0002',
            'menu_id' => 'M0002',
            'role_id' => 'R0001',
        ]);
        Role_menu::create([
            'role_menu_id' => 'R0001M0003',
            'menu_id' => 'M0003',
            'role_id' => 'R0001',
        ]);
        Role_menu::create([
            'role_menu_id' => 'R0001M0004',
            'menu_id' => 'M0004',
            'role_id' => 'R0001',
        ]);
        Role_menu::create([
            'role_menu_id' => 'R0001M0005',
            'menu_id' => 'M0005',
            'role_id' => 'R0001',
        ]);
        Role_menu::create([
            'role_menu_id' => 'R0002M0000',
            'menu_id' => 'M0000',
            'role_id' => 'R0002',
        ]);
    }
}
