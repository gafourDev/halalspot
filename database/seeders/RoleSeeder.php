<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Role::insert([
            ['name' => 'user', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'owner', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
