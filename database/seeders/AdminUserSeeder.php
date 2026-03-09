<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\User::create([
            'name' => 'Tito',
            'email' => 'tito@gmail.com',
            'password' => bcrypt('tito1234'),
            'role' => 'admin',
        ]);
    }
}
