<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create([
            'id' => 1, 'code' => 'ADMIN', 'name' => 'Administrator'
        ]);
        Role::create([
            'id' => 2, 'code' => 'GIGGER', 'name' => 'Gigger'
        ]);
        Role::create([
            'id' => 3, 'code' => 'GIGHOST', 'name' => 'Gig Host'
        ]);
    }
}
