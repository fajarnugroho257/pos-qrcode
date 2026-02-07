<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserTableseeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Developer',
            'user_st' => 'yes',
            'role_id' => 'R0001',
            'username' => 'jarvis123',
            'password' => bcrypt('dev220899'),
        ]);
        User::create([
            'name' => 'Admin',
            'user_st' => 'yes',
            'role_id' => 'R0002',
            'username' => 'admin123',
            'password' => bcrypt('admin123'),
        ]);
        User::create([
            'name' => 'Pengguna',
            'user_st' => 'yes',
            'role_id' => 'R0003',
            'username' => 'pengguna',
            'password' => bcrypt('pengguna'),
        ]);
    }
}
