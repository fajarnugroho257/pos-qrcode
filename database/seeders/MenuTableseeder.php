<?php

namespace Database\Seeders;

use App\Models\Menu;
use Illuminate\Database\Seeder;

class MenuTableseeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // heading
        Menu::create([
            'menu_id' => 'M0000',
            'menu_name' => 'Dashboard',
            'menu_url' => 'dashboard',
            'menu_parent' => '0',
            'menu_level' => '1',
            'menu_st' => 'yes',
            'menu_icon' => 'fas fa-tachometer-alt',
        ]);
        // heading
        Menu::create([
            'menu_id' => 'M0001',
            'menu_name' => 'Setting Menu',
            'menu_url' => null,
            'menu_parent' => '0',
            'menu_level' => '1',
            'menu_st' => 'yes',
            'menu_icon' => 'fas fa-cogs',
        ]);
        // sub-heading Setting Menu
        Menu::create([
            'menu_id' => 'M0002',
            'menu_name' => 'Menu Aplikasi',
            'menu_url' => 'menuApp',
            'menu_parent' => 'M0001',
            'menu_level' => '2',
            'menu_st' => 'yes',
            'menu_icon' => 'fa fa-bars',
        ]);
        Menu::create([
            'menu_id' => 'M0003',
            'menu_name' => 'Role Pengguna',
            'menu_url' => 'rolePengguna',
            'menu_parent' => 'M0001',
            'menu_level' => '2',
            'menu_st' => 'yes',
            'menu_icon' => 'fas fa-user-shield',
        ]);
        Menu::create([
            'menu_id' => 'M0004',
            'menu_name' => 'Role Menu',
            'menu_url' => 'roleMenu',
            'menu_parent' => 'M0001',
            'menu_level' => '2',
            'menu_st' => 'yes',
            'menu_icon' => 'fas fa-sitemap',
        ]);
        Menu::create([
            'menu_id' => 'M0005',
            'menu_name' => 'Data User',
            'menu_url' => 'dataUser',
            'menu_parent' => 'M0001',
            'menu_level' => '2',
            'menu_st' => 'yes',
            'menu_icon' => 'fa fa-user',
        ]);
        // sub menu level 3
        Menu::create([
            'menu_id' => 'M0006',
            'menu_name' => 'Test',
            'menu_url' => null,
            'menu_parent' => 'M0001',
            'menu_level' => '2',
            'menu_st' => 'yes',
            'menu_icon' => 'fa fa-star',
        ]);
        Menu::create([
            'menu_id' => 'M0007',
            'menu_name' => 'Level 3',
            'menu_url' => 'testLevel3',
            'menu_parent' => 'M0006',
            'menu_level' => '3',
            'menu_st' => 'yes',
            'menu_icon' => 'fa fa-star',
        ]);
        Menu::create([
            'menu_id' => 'M0008',
            'menu_name' => 'Level 3 .1',
            'menu_url' => 'testLevel3.1',
            'menu_parent' => 'M0006',
            'menu_level' => '4',
            'menu_st' => 'yes',
            'menu_icon' => 'fa fa-star',
        ]);
    }
}
